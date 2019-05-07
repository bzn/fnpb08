<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
if($_POST['action'] == 1)
{
	//echo $_POST['select'];
	?>
	<script language="javascript">
	//轉址
	self.location.href="res_team.php?teamid=<?php echo $_POST['select'];?>";
	</script>
	<?php
	//header("res_team.php?teamid=".$_POST['select']);
}
//測試初始數據====================
//$_SESSION['loginid'] = 1;
//$_SESSION['myteamid'] = 1;
//$_SESSION['nickname'] = "布魯斯爆炸";
//last,career,log
//$tab = 'career';
//$playerid = 218;
//echo $playerid;
//==============================
include_once(dirname(__FILE__)."/connect.php");
$str = "SELECT * FROM team_data WHERE id = ".$teamid."";
$SQLObj0->RunSQL($str);
$SQLObj0->LinkNext();
$teamname = $SQLObj0->GetData('NAME');

$str = "SELECT * FROM team_index WHERE team_id = ".$teamid."";
$SQLObj0->RunSQL($str);
$playercount = $SQLObj0->LinkAll();
$a_playerid = $SQLObj0->GetData('PLAYER_ID');

$a_schedule = GetSchedule10($SQLObj0,$teamid);

$p=0;
$h=0;
for($i=0;$i<$playercount;$i++)
{
	$player_base = GetPlayerBaseData($SQLObj0,$a_playerid[$i]);
	if($player_base['p'])
	{
		$a_pitcher_base[$p] = $player_base;
		//3/24
		$a_pitcher_365[$p] = GetPlayerDataByPeri($SQLObj0,$a_playerid[$i],365);
		//$a_pitcher_365[$p] = GetPlayerDataByYear($SQLObj0,$a_playerid[$i],2006);
		if(!IsForzen($SQLObj0,$a_pitcher_365[$p]['id']) && !IsHave($SQLObj0,$a_pitcher_365[$p]['id']))
			$a_pitcher_365[$p]['price'] = "<a href='trade.php?addid=".$a_pitcher_365[$p]['id']."'>".ShowPrice2($a_pitcher_365[$p]['price'])."</a>";
		else
			$a_pitcher_365[$p]['price'] = ShowPrice2($a_pitcher_365[$p]['price']);
		$p++;
	}
	else 
	{
		$a_hitter_base[$h] = $player_base;
		//3/24
		$a_hitter_365[$h] = GetPlayerDataByPeri($SQLObj0,$a_playerid[$i],365);
		//$a_hitter_365[$h] = GetPlayerDataByYear($SQLObj0,$a_playerid[$i],2006);
		if(!IsForzen($SQLObj0,$a_hitter_365[$h]['id']) && !IsHave($SQLObj0,$a_hitter_365[$h]['id']))
			$a_hitter_365[$h]['price'] = "<a href='trade.php?addid=".$a_hitter_365[$h]['id']."'>".ShowPrice2($a_hitter_365[$h]['price'])."</a>";
		else 
			$a_hitter_365[$h]['price'] = ShowPrice2($a_hitter_365[$h]['price']);
		$h++;
	}
}

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

<div id="headerSection" class="noborder">
    <div class="left">    
        <div class="pageTitle">       
            <img src="images/teamicon/<?php echo $teamid;?>.gif" width="32" height="32" border="1" />     
            <?php echo $teamname;?>
        </div>
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
    </div>        
        
    <br class="cboth" />
</div>
<br />
      
<table class="tableTitle v12">
	<tr>
        <td class="title">最近賽程</td>

        <td class="titleLink">(<a href="res_teamschedule.php?teamid=<?php echo $teamid;?>">全部賽程</a>)</td>
	</tr>
</table>
<table class="tright data v12" style="border-bottom: 3px solid #DDD;">
    <tr class="tcenter">
<?php 
for($i=0;$i<10;$i++)
{
?>
<th class="border"><span style="font-weight: bold"><?php echo $a_schedule[$i]['datetime'];?></span></th>
<?php
}
?>
</tr>
<tr class="odd tcenter" style="height: 40px">
<?php 
for($i=0;$i<10;$i++)
{
?>
<td><a href="res_team.php?teamid=<?php echo $a_schedule[$i]['teamid'];?>"><?php echo $a_schedule[$i]['team_name'];?></a></td>
<?php
}
?>
</tr>
</table>    
    
<br />
<br />
<table class="nowrap data cboth tright v12"  onClick="rollstick(event)" onMouseover="rollto(event, 'dcdcdc')" onMouseout="rollback(event, 'ffffff')">
    <tr class="tcenter">
            <!-- <th class="border" colspan="1">&nbsp;</th> -->
              
                		              <th class="border" colspan="2">球員資訊</th>
				        		              <th class="border" colspan="8">紀錄</th>
				        		              <th class="border" colspan="3">積分</th>

				        		              <th colspan="3">價錢</th>
				                  </tr>
   
    
     	<tr class="neutral">

        <td class=" tleft first ">投手</td>
       <td class="  border">位置</td>
       <td class="  ">		  		       IP		  		   </td>
       <td class="  ">		  		       W		  		   </td>
       <td class="  ">		  		       L		  		   </td>
       <td class="  ">		  		       S		  		   </td>
       <td class="  ">		  		       K		  		   </td>
       <td class="  ">		  		       BB		  		   </td>
       <td class="  ">		  		       ERA		  		   </td>
       <td class="  border">		  		       WHIP		  		   </td>
       <td class="  ">最新</td>
       <td class="  ">總積分</td>
       <td class="  border">平均</td>
       <td class="  ">價錢變動</td>
<td class="  ">買入</td>
</tr>     
<?php
for($i=0;$i<$p;$i++)
{
?>
<?php
	if($i%2)
	{
	?>
		    <tr class="even">
    <?php
	}
	else
	{
	?>
             <tr class="odd">                   
     <?php
	 }
	 ?>
                    <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_pitcher_365[$i]['id'];?>"><?php echo $a_pitcher_base[$i]['name_2'];?></a><a href="player.html?player_id=6223"></a></td>
                    <td class="border"><a href="team_page.html?team_id=16"><?php echo $a_pitcher_base[$i]['posstr'];?></a></td>
                    <td><?php echo $a_pitcher_365[$i]['col4'].".".$a_pitcher_365[$i]['col5'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['col1'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['col2'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['col3'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['col9'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['col8'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['era'];?></td>
                    <td class="border"><?php echo $a_pitcher_365[$i]['whip'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['yes_p'];?></td>
                    <td><?php echo $a_pitcher_365[$i]['tol_p'];?></td>
                    <td class="border"><?php echo $a_pitcher_365[$i]['avg_p'];?></td>
                    <td><?php echo ShowPriceMove($a_pitcher_365[$i]['pricemove']);?></td>
                    <td><?php echo $a_pitcher_365[$i]['price'];?> </td>
                </tr>
<?php
}                
?>    
     	<tr class="neutral">
        
                                                                                        <td class=" tleft first ">野手</td>
                                                                                       <td class="  border">位置</td>
                                                                                       <td class="  ">		  		       GP		  		   </td>
          <td class="  ">		  		       AB		  		   </td>
          <td class="  ">		  		       Runs		  		   </td>
          <td class="  ">		  		       HR		  		   </td>
          <td class="  ">		  		       RBI		  		   </td>
          <td class="  ">		  		       SB		  		   </td>
          <td class="  ">		  		       BA		  		   </td>
                                                                                       <td class="  border">SLG</td>
                                                                                       <td class="  ">最新</td>
                                                                                       <td class="  ">總積分</td>
                                                                                       <td class="  border">平均</td>
                                                                                       <td class="  ">價錢變動</td>

                                                   		                    <td class="  ">買入</td>
   </tr>     
<?php
for($i=0;$i<$h;$i++)
{
?>   
         <?php
	if($i%2)
	{
	?>
		    <tr class="even">
    <?php
	}
	else
	{
	?>
             <tr class="odd">                   
     <?php
	 }
	 ?>
     <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_hitter_365[$i]['id'];?>"><?php echo $a_hitter_base[$i]['name_2'];?></a></td><td class="border"><a href="team_page.html?team_id=16"><?php echo $a_hitter_base[$i]['posstr'];?></a></td><td><?php echo $a_hitter_365[$i]['g'];?></td><td><?php echo $a_hitter_365[$i]['col1'];?></td><td><?php echo $a_hitter_365[$i]['col2'];?></td><td><?php echo $a_hitter_365[$i]['col6'];?></td><td><?php echo $a_hitter_365[$i]['col7'];?></td><td><?php echo $a_hitter_365[$i]['col8'];?></td><td><?php echo $a_hitter_365[$i]['avg'];?></td><td class="border"><?php echo $a_hitter_365[$i]['slg'];?></td><td><?php echo $a_hitter_365[$i]['yes_p'];?></td><td><?php echo $a_hitter_365[$i]['tol_p'];?></td><td class="border"><?php echo $a_hitter_365[$i]['avg_p'];?></td><td><span class="border"><?php echo ShowPriceMove($a_hitter_365[$i]['pricemove']);?></span></td><td><?php echo $a_hitter_365[$i]['price'];?>                            
    </td></tr>
<?php
}
?>
</table>

<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>