<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
//測試初始數據====================

//==============================
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
include_once(dirname(__FILE__)."/connect.php");

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
			$str = "UPDATE myteam_data SET name ='".$teamname."' WHERE id=".$_SESSION['myteamid0801'];
			$SQLObj0->RunSQL($str);
			?>
			<script language="javascript">
			alert("變更隊伍名稱成功");
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
	body,td,th {
		font-family: Arial, Helvetica, sans-serif;
	}
	.style22 {color: #FFFFFF}
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
    <span class="pageTitle">隊伍名稱</span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12">這裡加入描述.................</div>
</div>  
<p class="line">&nbsp;</p><br>

<td class="v12"><?php 
	  if(strlen($errmsg))
	  	echo "<div class='v12'>".$errmsg."</div><BR>";?></td>
<form name="form1" method="post" action=""><input type="hidden" name="action" value="1">
<table class="v12 infotable">
    <div class="v12">為你的隊伍命名
    <tr>
    <input name="textfield" type="text" maxlength="20">
    <input type="submit" name="Submit" value="送出"></td>
    </tr>
    </div>
</table>
</form>

<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>