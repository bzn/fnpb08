<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");

//取得最後一次更新時間
$str = "SELECT * FROM player_record_log ORDER BY `datetime` DESC LIMIT 0,1";
$SQLObj0->RunSQL($str);
$SQLObj0->LinkNext();
$datetime = $SQLObj0->GetData('DATETIME');
$datetime = substr($datetime,0,10);
$today = substr($datetime,5,2)."/".$today = substr($datetime,8,2);;
//取得投手漲
$str = "SELECT * FROM player_record_log WHERE pitcher=1 AND `datetime`<='".$datetime." 24:00:00' AND `datetime`>'".$datetime." 00:00:00' ORDER BY pricemove DESC LIMIT 0,10";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkAll())
{
	$a_p_upid = $SQLObj0->GetData('PLAYER_ID');
	$a_p_up = $SQLObj0->GetData('PRICEMOVE');
}
for($i=0;$i<10;$i++)
{	
	//取得投手漲2008
	$str = "SELECT * FROM player_record_2008 WHERE player_id='".$a_p_upid[$i]."'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$p = $SQLObj0->GetData('POINTS');
		$g = $SQLObj0->GetData('G');
		if($g)
			$a_p_upavg[$i] = number_format($p/$g);
		else 
			$a_p_upavg[$i] = 0;
	}
}
//取得投手跌
$str = "SELECT * FROM player_record_log WHERE pitcher=1 AND `datetime`<='".$datetime." 24:00:00' AND `datetime`>'".$datetime." 00:00:00' ORDER BY pricemove LIMIT 0,10";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkAll())
{
	$a_p_downid = $SQLObj0->GetData('PLAYER_ID');
	$a_p_down = $SQLObj0->GetData('PRICEMOVE');
}
for($i=0;$i<10;$i++)
{	
	//取得投手漲2008
	$str = "SELECT * FROM player_record_2008 WHERE player_id='".$a_p_downid[$i]."'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$p = $SQLObj0->GetData('POINTS');
		$g = $SQLObj0->GetData('G');
		if($g)
			$a_p_downavg[$i] = number_format($p/$g);
		else 
			$a_p_downavg[$i] = 0;
	}
}
//取得野手漲
$str = "SELECT * FROM player_record_log WHERE pitcher=0 AND `datetime`<='".$datetime." 24:00:00' AND `datetime`>'".$datetime." 00:00:00' ORDER BY pricemove DESC LIMIT 0,10";
//echo $str."<BR>";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkAll())
{
	$a_h_upid = $SQLObj0->GetData('PLAYER_ID');
	$a_h_up = $SQLObj0->GetData('PRICEMOVE');
}
for($i=0;$i<10;$i++)
{	
	//取得投手漲2008
	$str = "SELECT * FROM player_record_2008 WHERE player_id='".$a_h_upid[$i]."'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$p = $SQLObj0->GetData('POINTS');
		$g = $SQLObj0->GetData('G');
		if($g)
			$a_h_upavg[$i] = number_format($p/$g);
		else 
			$a_h_upavg[$i] = 0;
	}
}
//取得野手跌
$str = "SELECT * FROM player_record_log WHERE pitcher=0 AND `datetime`<='".$datetime." 24:00:00' AND `datetime`>'".$datetime." 00:00:00' ORDER BY pricemove LIMIT 0,10";
//echo $str;
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkAll())
{
	$a_h_downid = $SQLObj0->GetData('PLAYER_ID');
	$a_h_down = $SQLObj0->GetData('PRICEMOVE');
}
for($i=0;$i<10;$i++)
{	
	//取得投手漲2008
	$str = "SELECT * FROM player_record_2008 WHERE player_id='".$a_h_downid[$i]."'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$p = $SQLObj0->GetData('POINTS');
		$g = $SQLObj0->GetData('G');
		if($g)
			$a_h_downavg[$i] = number_format($p/$g);
		else 
			$a_h_downavg[$i] = 0;
	}
}
for($i=0;$i<10;$i++)
{
	if($a_p_up[$i]!=0)
		$a_p_up[$i] = $a_p_up[$i]."0,000";
	if($a_p_down[$i]!=0)
		$a_p_down[$i] = $a_p_down[$i]."0,000";
	if($a_h_up[$i]!=0)
		$a_h_up[$i] = $a_h_up[$i]."0,000";
	if($a_h_down[$i]!=0)
		$a_h_down[$i] = $a_h_down[$i]."0,000";
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
    <span class="pageTitle"><?php echo $today;?>的價格漲跌</span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12">球隊買賣球員會造成球員價錢的變動，每天傍晚會結算一次，以下是最新的漲跌資料</div>
</div>  
<p class="line">&nbsp;</p><br>
    
<table class="infotable v12">
	<tr>
    <th colspan="6">投手</td>	</tr>
	<tr>
	    <th colspan="5">上漲排行</td>
    <th>價錢</td>	</tr>
    <tr class="even">
        <td class="tleft">選手</td>
        <td class="tleft">球隊</td>  
        <td>守備位置</td>
        <td>價錢</td>        	          
    	<td>平均積分</td>             
		<td><?php echo $today;?></a></td>
  </tr>
<?php
for($i=0;$i<10;$i++)
{
	if($i%2){
	?>
		<tr class="even">
	<?php }?>
		<td><a href="res_playerdata.php?view=1&playerid=<?php echo $a_p_upid[$i];?>"><?php echo GetPlayerName2($SQLObj0,$a_p_upid[$i]);?></a></td>
		<td><a href="res_team.php?teamid=<?php echo GetTeamIDByPlayerID($SQLObj0,$a_p_upid[$i]);?>"><?php echo GetTeamNameByPlayerID($SQLObj0,$a_p_upid[$i]);?></a></td>
		<td><?php echo GetPlayerPos($SQLObj0,$a_p_upid[$i]);?></td>
		<td><a href="trade.php?addid=<?php echo $a_p_upid[$i];?>"><?php echo ShowPrice1(GetPlayerPrice($SQLObj0,$a_p_upid[$i]));?></a></td>
		<td><?php echo $a_p_upavg[$i];?></td><td>    <?php echo $a_p_up[$i];?></td>
  </tr>
	<?php
}
?>
</table>
<BR>
<table class="infotable v12">
    <tr>
    <th colspan="6">野手</td>    </tr>
    <tr>
        <th colspan="5">上漲排行</td>
    <th>價錢</td>    </tr>
    <tr class="even">
        <td class="tleft">選手</td>
        <td class="tleft">球隊</td>  
        <td>守備位置</td>
        <td>價錢</td>        	          
    	<td>平均積分</td>             
		<td><?php echo $today;?></a></td>
  </tr>
<?php
for($i=0;$i<10;$i++)
{
	if($i%2){
	?>
		<tr class="even">
	<?php }?>
		<td><a href="res_playerdata.php?view=1&playerid=<?php echo $a_h_upid[$i];?>"><?php echo GetPlayerName2($SQLObj0,$a_h_upid[$i]);?></a></td>
		<td><a href="res_team.php?teamid=<?php echo GetTeamIDByPlayerID($SQLObj0,$a_p_upid[$i]);?>"><?php echo GetTeamNameByPlayerID($SQLObj0,$a_h_upid[$i]);?></a></td>
		<td><?php echo GetPlayerPos($SQLObj0,$a_h_upid[$i]);?></td>
		<td><a href="trade.php?addid=<?php echo $a_p_upid[$i];?>"><?php echo ShowPrice1(GetPlayerPrice($SQLObj0,$a_h_upid[$i]));?></a></td>
		<td><?php echo $a_h_upavg[$i];?> </td>
		<td>    <?php echo $a_h_up[$i];?></td>
  </tr>
	<?php
}
?>
</table>
<BR>
<table class="infotable v12">
	<tr>
    <th colspan="6">投手</td>	</tr>
	<tr>
	    <th colspan="5">下跌排行</td>
    <th>價錢</td>	</tr>
    <tr class="even">
        <td class="tleft">選手</td>
        <td class="tleft">球隊</td>  
        <td>守備位置</td>
        <td>價錢</td>        	          
    	<td>平均積分</td>             
		<td><?php echo $today;?></a></td>
  </tr>
<?php
for($i=0;$i<10;$i++)
{
	if($i%2){
	?>
		<tr class="even">
	<?php }?>
		<td><a href="res_playerdata.php?view=1&playerid=<?php echo $a_p_downid[$i];?>"><?php echo GetPlayerName2($SQLObj0,$a_p_downid[$i]);?></a></td>
		<td><a href="res_team.php?teamid=<?php echo GetTeamIDByPlayerID($SQLObj0,$a_p_downid[$i]);?>"><?php echo GetTeamNameByPlayerID($SQLObj0,$a_p_downid[$i]);?></a></td>
		<td><?php echo GetPlayerPos($SQLObj0,$a_p_downid[$i]);?></td>
		<td><a href="trade.php?addid=<?php echo $a_p_downid[$i];?>"><?php echo ShowPrice1(GetPlayerPrice($SQLObj0,$a_p_downid[$i]));?></a></td>
		<td><?php echo $a_p_downavg[$i];?></td><td>    <?php echo $a_p_down[$i];?></td>
  </tr>
	<?php
}
?>
</table>
<BR>
<table class="infotable v12">
    <tr>
    <th colspan="6">野手</td>    </tr>
    <tr>
        <th colspan="5">下跌排行</td>
    <th>價錢</td>    </tr>
    <tr class="even">
        <td class="tleft">選手</td>
        <td class="tleft">球隊</td>  
        <td>守備位置</td>
        <td>價錢</td>        	          
    	<td>平均積分</td>             
		<td><?php echo $today;?></a></td>
  </tr>
<?php
for($i=0;$i<10;$i++)
{
	if($i%2){
	?>
		<tr class="even">
	<?php }?>
		<td><a href="res_playerdata.php?view=1&playerid=<?php echo $a_h_downid[$i];?>"><?php echo GetPlayerName2($SQLObj0,$a_h_downid[$i]);?></a></td>
		<td><a href="res_team.php?teamid=<?php echo GetTeamIDByPlayerID($SQLObj0,$a_p_downid[$i]);?>"><?php echo GetTeamNameByPlayerID($SQLObj0,$a_h_downid[$i]);?></a></td>
		<td><?php echo GetPlayerPos($SQLObj0,$a_h_downid[$i]);?></td>
		<td><a href="trade.php?addid=<?php echo $a_p_downid[$i];?>"><?php echo ShowPrice1(GetPlayerPrice($SQLObj0,$a_h_downid[$i]));?></a></td>
		<td><?php echo $a_h_downavg[$i];?> </td>
		<td>    <?php echo $a_h_down[$i];?></td>
  </tr>
	<?php
}
?>
</table>
<BR>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>