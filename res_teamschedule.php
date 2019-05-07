<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
//測試初始數據====================
//$_SESSION['charid'] = 1;
//$_SESSION['myteamid'] = 1;
//$_SESSION['nickname'] = "布魯斯爆炸";
//last,career,log
//$tab = 'career';
//$playerid = 218;
//echo $playerid;
//==============================
include_once(dirname(__FILE__)."/connect.php");
if($_POST['action'] == 1)
{
	//echo $_POST['select'];
	?>
	<script language="javascript">
	//轉址
	self.location.href="res_teamschedule.php?teamid=<?php echo $_POST['select'];?>";
	</script>
	<?php
	//header("res_team.php?teamid=".$_POST['select']);
}
$a_schedule = GetScheduleAll($SQLObj0,$teamid);
$str = "SELECT * FROM team_data WHERE id = ".$teamid."";
$SQLObj0->RunSQL($str);
$SQLObj0->LinkNext();
$teamname = $SQLObj0->GetData('NAME');

/*
//防守位置字串
$posstr = '';
if($a_player_base['p'])
	$posstr = $posstr.'P ';
if($a_player_base['c'])
	$posstr = $posstr.'C ';
if($a_player_base['1b'])
	$posstr = $posstr.'1B ';
if($a_player_base['2b'])
	$posstr = $posstr.'2B ';
if($a_player_base['ss'])
	$posstr = $posstr.'SS ';
if($a_player_base['3b'])
	$posstr = $posstr.'3B ';
if($a_player_base['of'])
	$posstr = $posstr.'OF ';
if($a_player_base['dh'])
	$posstr = $posstr.'DH ';
*/
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
.style20 {	font-size: 16px;
	font-weight: bold;
}
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
    <span class="pageTitle">球隊賽程</span>
    <p class="dottedLine">&nbsp;</p>
    球隊本季的賽程表
</div>  
<p class="line">&nbsp;</p>

<br />

<div id="headerSection" class="noborder">
    <div class="left">    
        <div class="pageTitle"><img src="images/teamicon/<?php echo $teamid;?>.gif" alt="" width="32" height="32" border="1" /><span class="style20"><?php echo $teamname;?></span></div>
  </div>
    <div class="right" style="margin-top: 5px">
    
       <form name="form1" method="post" action="">
	  <input type="hidden" name="action" value="1">
        <label>
        <select name="select">
            <option value="%" selected="selected">選擇球隊</option>
            <option value="1">Tigers</option>
            <option value="2">Dragons</option>
            <option value="3">BayStars</option>
            <option value="4">Swallows</option>
            <option value="5">Giants</option>
            <option value="6">Carps</option>
            <option value="7">Marines</option>
            <option value="8">Hawks</option>
            <option value="9">Lions</option>
            <option value="10">Buffaloe</option>
            <option value="11">Fighters</option>
            <option value="12">Eagles</option>
        </select>
          <input type="submit" name="Submit" value="查詢" />
         </label>
      </form>
        </noscript>
    </div>        
        
    <br class="cboth" />
</div>
<br />
<div class="tcenter">
<table class="w80 tableTitle v12" style="margin: 5px auto">
	<tr>
        <td class="title">所有賽程</td>

        <td class="titleLink"><a href="res_team.php?teamid=<?php echo $teamid;?>">球隊首頁</a></td>
	</tr>
</table>
<table class="margin_center w80 data v12">
	<tr>
		<th class="tleft">日期</th>
		<th class="tleft">對手</th>
		<th class="tleft">比數</th>

	</tr>
    
<?php
for($i=0;$i<$a_schedule['count'];$i++)
{
?>
	<?php
    if($i%2)
	{
	?>
    	<TR class="altrow">
     <?php
	 }
	 else
	 {
	 ?>
		<TR class="text10">
      <?php
	  }
	  ?>    
    <TD class="text10"><span class="style18"><?php echo $a_schedule[$i]['datetime'];?></span></TD>
  <TD class="text10"><?php echo $a_schedule[$i]['team_name'];?></TD>
  <TD class="text10"><?php echo $a_schedule[$i]['score'];?></TD>
<?php
}
?>  

</table>
<?php include(dirname(__FILE__)."/down.php");?>

</body>
</html>