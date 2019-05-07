<?php 
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/npb.class.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fantasy NPB!!</title>
</head>
<?php
echo $delid;
exit;
if($_POST['action']==1)
{
	$errmsg = '';
	if($delid && IsForzen($SQLObj0,$delid))
		$errmsg = "無法買賣正在凍結狀態的球員";
	elseif($addid && IsForzen($SQLObj0,$addid))
		$errmsg = "無法買賣正在凍結狀態的球員";
	if(strlen($errmsg)==0)
	{
		$MyTeamObj = new MyTeamObj();
		//取得球員名單
		$MyTeamObj->GetData($SQLObj0,$_SESSION['myteamid0801']);
		
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
	}
	//如果買進賣出都成功
	if(strlen($errmsg)==0)
	{
		//排序
		$MyTeamObj->Sort($SQLObj0);
		
		$sellmsg = $sellmsg." ?";
		//更新資料庫
		$MyTeamObj->UpdateDB($SQLObj0);
		
		$str = "SELECT * FROM myteam_data WHERE id=".$MyTeamObj->teamid;
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$flag = $SQLObj0->GetData("READY");
		//如果未買滿
		if($flag == 0)
		{
			//是否買滿
			$flag = 1;
			//計分
			for($j=0;$j<14;$j++)
			{
				//避免有任何一個位置沒買滿(FULL)
				if($MyTeamObj->pos[$j] != 0)
				{
					//$a_team[$i+1] += $a_player['points'][$MyTeamObj->pos[$j]];
				}
				else 
				{
					$flag = 0;
					break;
				}
			}
		}
		$str = "UPDATE myteam_data SET ready =".$flag." WHERE id=".$MyTeamObj->teamid;
		$SQLObj0->RunSQL($str);
		//如果買滿球員了,且季賽已經開始,才紀錄
		if($flag && IsSeasonStart())
		{
			//交易紀錄
			if($addid && $delid)
				$str = "INSERT INTO myteam_trade_log (datetime,myteam_id,in_id,out_id) VALUES ('".NOW()."',".$_SESSION['myteamid0801'].",".$addid.",".$delid.")";
			elseif ($addid)
				$str = "INSERT INTO myteam_trade_log (datetime,myteam_id,in_id) VALUES ('".NOW()."',".$_SESSION['myteamid0801'].",".$addid.")";
			elseif ($delid)
				$str = "INSERT INTO myteam_trade_log (datetime,myteam_id,out_id) VALUES ('".NOW()."',".$_SESSION['myteamid0801'].",".$delid.")";
			
			$SQLObj0->RunSQL($str);
		}
		?>
		<script language="javascript">
		//轉址
		self.location.href='myteam_lineup.php?view=2';
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
		self.location.href='myteam_lineup.php?view=2';
		</script>
		<?php
	}
}
?>