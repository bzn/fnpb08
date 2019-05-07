<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fantasy NPB!!</title>
</head>
<?php 
//測試用數據=============
//$_SESSION['charid'] = 1;
//$_SESSION['myteamid'] = 1;
//$_SESSION['nickname'] = "布魯斯爆炸";
//$delid = 229;
//$addid = 229;
//$addpos = 'c';
//======================
include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/npb.class.php");
//取得上次pricemove之後最新的一筆trade_log
$str = "SELECT * FROM myteam_trade_log WHERE myteam_id=".$myteamid." ORDER BY `datetime` DESC LIMIT 0,1";
$SQLObj0->RunSQL($str);
$SQLObj0->LinkNext();
$datetime = $SQLObj0->GetData('DATETIME');
$in_id = $SQLObj0->GetData('IN_ID');
$out_id = $SQLObj0->GetData('OUT_ID');

//檢查是否可以undo
//現在是

$sellmsg = "確認";
if($delid)
{
	$delname = GetPlayerName2($SQLObj0,$delid);
	$sellmsg = $sellmsg." 賣出 ".$delname;
}
if($delid&&$addid)
	$sellmsg = $sellmsg." 並 ";
//如果有買進
if($addid)
{
	$addname = GetPlayerName2($SQLObj0,$addid);
	$sellmsg = $sellmsg." 買進 ".$addname;
}

if($_POST['action']==1)
{
	$errmsg = '';
	if($delid && IsForzen($SQLObj0,$delid))
		$errmsg = "無法買賣正在凍結狀態的球員";
	elseif($addid && IsForzen($SQLObj0,$addid))
		$errmsg = "無法買賣正在凍結狀態的球員";
	$MyTeamObj = new MyTeamObj();
	//取得球員名單
	$MyTeamObj->GetData($SQLObj0,$_SESSION['myteamid']);
	
	//如果有賣出
	if($delid)
	{
		$errmsg = $MyTeamObj->DelPlayer($SQLObj0,$delid);
	}
	//如果有買進
	if($addid)
	{	
		$errmsg = $MyTeamObj->AddPlayer($SQLObj0,$addid,$addpos);	
	}
	
	//如果買進賣出都成功
	if(strlen($errmsg)==0)
	{
		//排序
		$MyTeamObj->Sort($SQLObj0);
		
		$sellmsg = $sellmsg." ?";
		//更新資料庫
		$MyTeamObj->UpdateDB($SQLObj0);
		//交易紀錄
		if($addid && $delid)
			$str = "INSERT INTO myteam_trade_log (datetime,myteam_id,in_id,out_id) VALUES ('".NOW()."',".$_SESSION['myteamid'].",".$addid.",".$delid.")";
		elseif ($addid)
			$str = "INSERT INTO myteam_trade_log (datetime,myteam_id,in_id) VALUES ('".NOW()."',".$_SESSION['myteamid'].",".$addid.")";
		elseif ($delid)
			$str = "INSERT INTO myteam_trade_log (datetime,myteam_id,out_id) VALUES ('".NOW()."',".$_SESSION['myteamid'].",".$delid.")";
		
		$SQLObj0->RunSQL($str);
		?>
		<script language="javascript">
		//轉址
		self.location.href='myteam_lineup.php?view=1';
		</script>
		<?php
	}
	else
	{
		//印出賣出失敗
		//echo "2";
		?>
		<script language="javascript">
		alert("<?php echo $errmsg;?>");
		//轉址
		self.location.href='myteam_lineup.php?view=1';
		</script>
		<?php
	}
}
?>
<body>
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="action" value="1">
<input type="hidden" name="delid" value="<?php echo $delid;?>">
<input type="hidden" name="addid" value="<?php echo $addid;?>">
<input type="hidden" name="addpos" value="<?php echo $addpos;?>">
<script language="javascript">
if(confirm("<?php echo $sellmsg;?>"))
{
	//alert('交易!');
	window.form1.submit();
}
else
{
	//轉址
	//alert('轉址!');
	self.location.href='myteam_lineup.php?view=1';
}
</script>
</form>
</body>
</html>