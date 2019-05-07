<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");
//顯示10天內的msg
$datetime = NOW();
$mm = substr($datetime,5,2);
$dd = substr($datetime,8,2);
$yy = substr($datetime,0,4);
$mktime = gmmktime(gmdate("H")+GMHOUR,gmdate("i"),gmdate("s"),$mm,$dd-10,$yy);
$datetime = gmdate("Y-m-d H:i:s",$mktime);
$str = "SELECT * FROM lea_msg WHERE lea_id=".$_SESSION['leaid']." AND `datetime`>='".$datetime."' ORDER BY `datetime` DESC";
$SQLObj0->RunSQL($str);
if($count = $SQLObj0->LinkAll())
{
	$a_datetime = $SQLObj0->GetData('DATETIME');
	$a_userid= $SQLObj0->GetData('USER_ID');
	$a_txt = $SQLObj0->GetData('TXT');
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
    <span class="pageTitle">聯盟留言板</span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12">這裡主要供聯盟球隊間交流用，只會顯示10日之內的留言，需要更進階的功能請到<a href="http://npb.club.tw/viewforum.php?f=93">我們的討論區</a></div>
</div>  
<p class="line">&nbsp;</p>
<div align="right">
      <input type="button" name="button" id="button" value="張貼留言" class="v11" onclick="location='lea_postmsg.php';"><br>
  
</div>
<table class="v12 infotable">
    <col width="10%" />
    <col width="10%" />
    <col width="auto" />
       <tr>
 		<th class="tleft">時間</th>

		<th class="tleft">發言人</th>
		<th class="tleft">留言</th>
	</tr>
    <?php
	for($i=0;$i<$count;$i++)
	{
		if($i%2)
		{
			?><tr class="even"><?php
		}
		else
		{
			?><tr class="odd"><?php
		}
	?>
		<td class="tleft"><?php echo $a_datetime[$i];?></td>
        <td class="tleft"><?php echo GetNickname($SQLObj0,$a_userid[$i]);?></td>
        <td class="tleft"><?php echo strip_tags($a_txt[$i]);?></td>
	</tr>
    <?php 
    }
	?>
</table>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>