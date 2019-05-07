<?php
session_start();
extract($_POST);
extract($_GET);
//include(dirname(__FILE__)."/check.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//測試初始數據====================
$startmoney = 5000;
//==============================
include_once(dirname(__FILE__)."/connect.php");
if(!$_SESSION['loginid'])
{
	echo "Login Err";
	exit();
}
if(!$_SESSION['loginid'])
{
	echo "Login Err";
	exit();
}
if($_SESSION['myteamid0801'])
{
	echo "Had MyTeamID Err , please logout and try again<BR>";
	echo "隊伍標號錯誤,請<a href='/logout.php'>重新登入</a>";
	exit();
}
//先取得球隊id
$str = "SELECT * FROM myteam_index WHERE user_id=".$_SESSION['loginid'];
$SQLObj0->RunSQL($str);
//避免重複申請隊伍
if($SQLObj0->LinkNext())
{
	?>
	<script language="javascript">
	alert("您只能申請一個隊伍");
	//轉址
	self.location.href='myteam_lineup.php?view=2';
	</script>
	<?php
}

if($_POST['action'] == 1)
{
	$teamname = $_POST['textfield'];
	if(strlen($teamname) > 36)
	{
		$errmsg = "名稱不能超過20個字";
	}
	elseif(strlen($teamname)==0) 
	{
		$errmsg = "必須輸入一個隊伍名稱";
	}
	else 
	{
		$str = "SELECT * FROM myteam_data WHERE name ='".$teamname."'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			$errmsg = "這個名稱已經有人使用了";
		else 
		{
			$str = "INSERT INTO myteam_data (name,cash,trade_1,trade_2,points,money) VALUES ('".$teamname."',".$startmoney.",3,3,0,".$startmoney.")";
			$SQLObj0->RunSQL($str);
			$str = "SELECT * FROM myteam_data WHERE name='".$teamname."'";
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			//取得id
			$teamid = $SQLObj0->GetData('ID');
			//加入到index
			$str = "INSERT INTO myteam_index (myteam_id,user_id) VALUES (".$teamid.",".$_SESSION['loginid'].")";
			$SQLObj0->RunSQL($str);
			$_SESSION['myteamid0801'] = $teamid;
			?>
			<script language="javascript">
			alert("新增隊伍成功");
			//轉址
			self.location.href='myteam_lineup.php?view=2';
			</script>
			<?php
		}
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
	<link rel="stylesheet" href="css/fantasygames.css" type="text/css">
	<link rel="stylesheet" href="css/style2007.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">	
	<link rel="stylesheet" href="css/top.css" type="text/css">
    <style type="text/css">
<!--
.style18 {font-size: 12px}
-->
    </style>
</head>
<!--- needed for carlo init func for fs popup to rollover -->
<body id="body_centered">

<div id="content">
   <table width="770" border="0" align="center">
    <tr>
      <td><?php
include(dirname(__FILE__)."/include/head.inc.php");
?></td>
    </tr>
  </table>
<br />
   
<p class="line">&nbsp;</p>
<div id="headerSection">
    <span class="pageTitle">設定你的隊伍名稱</span>
    <p class="dottedLine">&nbsp;</p>
    名稱設定稍後仍可被更改
</div>  
<p class="line">&nbsp;</p>

<br/>
<form name="form1" method="post" action=""><input type="hidden" name="action" value="1">
    輸入隊伍名稱: 
    <input name="textfield" type="text" class="v11" maxlength="20">
    <br><br>
    <input type="submit" name="Submit" value="送出" class="v11">
</form> 

<div style="width:780px; background-color:#eeeeee; height:12px; line-height:12px;">&nbsp;</div>

<div style="width:780px; background-color: #FFF" align="left"></div>
        
        <div style="background-color:#eeeeee; padding:10px 23px 13px 23px;"><br />
        
  </div>        
        <br />
        <br />    
</div>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>