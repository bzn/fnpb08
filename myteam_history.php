<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");

$str = "SELECT * FROM myteam_data WHERE id='".$_SESSION['myteamid0801']."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$myteamname = $SQLObj0->GetData('NAME');
}

$str = "SELECT * FROM myteam_trade_log WHERE myteam_id=".$_SESSION['myteamid0801']." ORDER BY `datetime` DESC";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_datetime = $SQLObj0->GetData('DATETIME');
	$a_in = $SQLObj0->GetData('IN_ID');
	$a_out = $SQLObj0->GetData('OUT_ID');
}
for($i=0;$i<$nrows;$i++)
{
	if($a_in[$i])
	{
		$a_inprice[$i] = GetPlayerPriceByDatetime($SQLObj0,$a_in[$i],$a_datetime[$i]);
		$a_in[$i] = GetPlayerName2($SQLObj0,$a_in[$i]);	
	}
	else
	{
		$a_inprice[$i] = '';
		$a_in[$i] = '';
	}
	if($a_out[$i])
	{
		$a_outprice[$i] = GetPlayerPriceByDatetime($SQLObj0,$a_out[$i],$a_datetime[$i]);
		$a_out[$i] = GetPlayerName2($SQLObj0,$a_out[$i]);
	}
	else
	{
		$a_outprice[$i] = '';
		$a_out[$i] = '';
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
    <span class="pageTitle">我的交易紀錄</span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12">這裡加入描述.................</div>
</div>  
<p class="line">&nbsp;</p><br>

<table class="v12 infotable">
       <tr>
 		<th class="tleft">交易時間</th>

		<th class="tleft">選手</th>
		<th class="tleft">買入價錢</th>
		<th class="tleft">賣出價錢</th>
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
		<td class="tleft"><?php echo $a_datetime[$i];?></td>
		<?php 
		if(!empty($a_in[$i]))
		{
			?>
			<td class="tleft"><?php echo $a_in[$i];?></td>
			<td class="tleft"><?php echo ShowPrice1($a_inprice[$i]);?></td>
			<td class="tleft">-</td></tr>
			<?php
		}
		else 
		{
			?>
			<td class="tleft"><?php echo $a_out[$i];?></td>
			<td class="tleft">-</td>
			<td class="tleft"><?php echo ShowPrice1($a_outprice[$i]);?></td></tr>
			<?php
		}
	}
	?>

</table>

<?php include(dirname(__FILE__)."/down.php");?>

</body>
</html>