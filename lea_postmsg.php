<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");
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
</head>
<?php
if($_POST['action'] == 1)
{
	//echo $_POST['textarea'];
	//exit;
	$str = "INSERT INTO lea_msg SET lea_id=".$_SESSION['leaid'].",user_id=".$_SESSION['loginid'].",txt='".$_POST['textfield']."',datetime='".NOW()."'";
	$SQLObj0->RunSQL($str);
	?>
	<script language="javascript">
	alert("留言成功");
	self.location.href='lea_msg.php';
	</script>
	<?php
}
?>
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
    <span class="pageTitle">張貼留言</span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12">只有同聯盟的球隊可以看到留言，請注意發言是否得體，切勿言語攻擊球隊、球員或玩家</div>
</div>  
<p class="line">&nbsp;</p><br>

<form name="form1" method="post" action="">
<input type="hidden" name="action" value="1">
<textarea name="textfield" cols="80" rows="10" id="textfield"></textarea>
<BR>
<input type="submit" name="Submit" value="送出" class="v11">
</form>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>