<?php
/*********************************************************************************************
SESSION
*********************************************************************************************/
if ($_COOKIE['PHPSESSID'])	session_id($_COOKIE['PHPSESSID']);
session_start();
header("Content-type: text/html; charset=UTF-8");

/*********************************************************************************************
INCLUDE
*********************************************************************************************/
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");

/*********************************************************************************************
BASIC SETTINGS
*********************************************************************************************/
//將GET也當作POST來處理//
if(count($_GET)) $_POST = $_GET;

/**
 * 7 day Bargain
 */
//Pither//
$sqlstr = '
SELECT C.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_record_7` AS C ON C.`player_id`=B.`id`
WHERE 1 AND B.`p` = 1 
ORDER BY C.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $plist7 = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$plist7 .= '<tr class="even">';
        else
        	$plist7 .= '<tr class="odd">';
        $plist7 .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}
//Hitter//
$sqlstr = '
SELECT C.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_record_7` AS C ON C.`player_id`=B.`id`
WHERE 1 AND B.`p` = 0 
ORDER BY C.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $hlist7 = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$hlist7 .= '<tr class="even">';
        else
        	$hlist7 .= '<tr class="odd">';
        $hlist7 .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}

/**
 * 15 day Bargain
 */
//Pither//
$sqlstr = '
SELECT C.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_record_15` AS C ON C.`player_id`=B.`id`
WHERE 1 AND B.`p`=1 
ORDER BY C.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $plist15 = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$plist15 .= '<tr class="even">';
        else
        	$plist15 .= '<tr class="odd">';
        $plist15 .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}
//Hitter//
$sqlstr = '
SELECT C.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_record_15` AS C ON C.`player_id`=B.`id`
WHERE 1 AND B.`p`=0 
ORDER BY C.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $hlist15 = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$hlist15 .= '<tr class="even">';
        else
        	$hlist15 .= '<tr class="odd">';
        $hlist15 .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}

/**
 * 30 day Bargain
 */
//Pither//
$sqlstr = '
SELECT C.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_record_30` AS C ON C.`player_id`=B.`id`
WHERE 1 AND B.`p` = 1 
ORDER BY C.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $plist30 = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$plist30 .= '<tr class="even">';
        else
        	$plist30 .= '<tr class="odd">';
        $plist30 .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}
//Hitter//
$sqlstr = '
SELECT C.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_record_30` AS C ON C.`player_id`=B.`id`
WHERE 1 AND B.`p` = 0 
ORDER BY C.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $hlist30 = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$hlist30 .= '<tr class="even">';
        else
        	$hlist30 .= '<tr class="odd">';
        $hlist30 .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}

/**
 * season Bargain
 */
//Pither//
$sqlstr = '
SELECT A.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` 
WHERE 1 AND B.`p`=1 
ORDER BY A.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $plist = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$plist .= '<tr class="even">';
        else
        	$plist .= '<tr class="odd">';
        $plist .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}
//Hitter//
$sqlstr = '
SELECT A.`points`, A.`price`,B.`name_2`,B.`id` 
FROM `'.$ini_array['system']['dbname'].'`.`player_record_2008` AS A LEFT JOIN 
`'.$ini_array['system']['dbname'].'`.`player_base_data` AS B ON A.`player_id`=B.`id` 
WHERE 1 AND B.`p`=0 
ORDER BY A.`points` DESC LIMIT 0,10';
$SQLObj0->RunSQL($sqlstr);
$nrows = $SQLObj0->LinkAll();
if($nrows > 0)
{
    $hlist = '';
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        if($i%2)
        	$hlist .= '<tr class="even">';
        else
        	$hlist .= '<tr class="odd">';
        $hlist .= '
		<td>'.($i+1).'</td>
		<td><a href="res_playerdata.php?view=1&playerid='.$row['id'].'">'.$row['name_2'].'</a> ( '.GetPlayerPos($SQLObj1,$row['id']).' )</td>
		<td>'.GetTeamNameByPlayerID($SQLObj1,$row['id']).'</td>
		<td>'.round($row['points']).'</td>
		<td><a href="trade.php?addid='.$row['id'].'">'.ShowPrice2($row['price']).'</a></td></tr>
        ';
    }
}

/*********************************************************************************************
HTML
*********************************************************************************************/
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
    <span class="pageTitle">績優球員</span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12">以下是積分優異的球員</div>
</div>  
<p class="line">&nbsp;</p><br>

<br class="cboth">
<div class="left w45"> 
   <h2>投手(最近7日)</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $plist7;?>
   </table>
</div>
<div class="right w45">

   <h2>打者(最近7日)</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $hlist7;?>
   </table>
</div>

<br class="cboth">
<div class="left w45"> 
<br \>
   <h2>投手(最近15日)</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $plist15;?>
   </table>
</div>
<div class="right w45">
<br \>
   <h2>打者(最近15日)</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $hlist15;?>
   </table>
</div>

<br class="cboth">
<div class="left w45"> 
<br \>
   <h2>投手(最近30日)</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $plist30;?>
   </table>
</div>
<div class="right w45">
<br \>
   <h2>打者(最近30日)</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $hlist30;?>
   </table>
</div>

<br class="cboth">
<div class="left w45"> 
<br \>
   <h2>投手本季</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $plist;?>
   </table>
</div>
<div class="right w45">
<br \>
   <h2>打者本季</h2>
    <table class="infotable w100 v12">
       <tr>
          <th class="tleft">排名</td>
          <th class="tleft">球員</th>
      	  <th class="tleft">球隊</th>      	  
      	  <th class="tleft">積分</th>
      	  <th class="tleft">價錢</th>
       </tr>
    	  <!--<td colspan="5">Top Players will be available when the season begins.</td>-->
    	  <?php echo $hlist;?>
   </table>
</div>

<?php include(dirname(__FILE__)."/down.php");?>

</body>
</html>