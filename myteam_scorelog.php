<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");

if(empty($myteamid))
{
	$myteamid = $_SESSION['myteamid0801'];
}

$str = "SELECT * FROM myteam_data WHERE id='".$myteamid."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$myteamname = $SQLObj0->GetData('NAME');
}

$str = "SELECT * FROM myteam_score_log WHERE teamid=".$myteamid." ORDER BY `datetime` DESC";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_datetime = $SQLObj0->GetData('DATETIME');
	$a_score = $SQLObj0->GetData('POINTS');
	$a_prank = $SQLObj0->GetData('POINT_RANK');
	$a_tprice = $SQLObj0->GetData('TOL_PRICE');
	$a_pmove = $SQLObj0->GetData('PRICEMOVE');
}
for($i=0;$i<$nrows;$i++)
{
	$mm = substr($a_datetime[$i],5,2);
	$dd = substr($a_datetime[$i],8,2);
	$a_link[$i] = "res_roster.php?myteamid=".$myteamid."&mm=".$mm."&dd=".$dd."";
	$a_datetime[$i] = "<a href='".$a_link[$i]."'>".substr($a_datetime[$i],0,10)."</a>";
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
    <span class="pageTitle"><?php echo $myteamname;?>的積分紀錄</span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12">這裡加入描述.................</div>
</div>  
<p class="line">&nbsp;</p><br>

<table class="infotable v12">
   <tr>
      <th class="tleft">日期</th>
      <th class="tright">當日積分</th>
      <th class="tright">總排名 (Change)</th>
      <th class="tright">聯盟排名 (Change)</th>
      <th class="tright">資產變動 (Change)</th>
   </tr>
	<?php
	for($i=0;$i<$nrows;$i++)
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
	   <td><a href="stats_breakdown.html?date=03-NOV-07"><?php echo $a_datetime[$i];?></a></td>
	   <td><?php echo $a_score[$i];?></td>
	   <td><?php echo $a_prank[$i];?> (-)</td>
	   <td>103 (-)</td>
	   <td><?php echo $a_tprice[$i];?>(
	   <?php
	   if($a_pmove[$i]>0)
	   		echo "<img src='images/up.gif'>".ShowPrice1($a_pmove[$i]);
	   else if($a_pmove[$i]<0)
	   		echo "<img src='images/down.gif'>".ShowPrice1($a_pmove[$i]);
	   else 
	   		echo "-";
	   	?>
	   )</td></tr>
	<?php
	}   
	?>
</table>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>