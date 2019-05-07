<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");

	//取得最新的資料
	$str = "SELECT * FROM log_pricemove ORDER BY `datetime` DESC";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	$datetime = $SQLObj0->GetData('DATETIME');
	//echo $datetime."<BR>";
	$date = substr($datetime,0,10);
	$mm = substr($datetime,5,2);
	$dd = substr($datetime,8,2);
	//echo $mm."<BR>";
	//echo $dd."<BR>";
	//投手積分排行
	$str = "SELECT * FROM player_record_log WHERE pitcher=1 AND `datetime`>='".$date." 00:00:00' ORDER BY points DESC LIMIT 10";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkAll();
	$a_p_id = $SQLObj0->GetData('PLAYER_ID');
	$a_p_points = $SQLObj0->GetData('POINTS');
	//打者積分排行
	$str = "SELECT * FROM player_record_log WHERE pitcher=0 AND `datetime`>='".$date." 00:00:00' ORDER BY points DESC LIMIT 10";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkAll();
	$a_h_id = $SQLObj0->GetData('PLAYER_ID');
	$a_h_points = $SQLObj0->GetData('POINTS');
	//玩家積分排行
	$str = "SELECT * FROM myteam_score_log WHERE `datetime`>='".$date." 00:00:00' ORDER BY points DESC LIMIT 10";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkAll();
	$a_t_id = $SQLObj0->GetData('TEAMID');
	$a_t_points = $SQLObj0->GetData('POINTS');
	$a_t_tol_points = $SQLObj0->GetData('TOL_POINTS');
	
	for($i=0;$i<10;$i++)
	{
		$a_pitcher[$i] = GetPlayerDataByPeri($SQLObj0,$a_p_id[$i],1);
	}
	for($i=0;$i<15;$i++)
	{
		$a_hitter[$i] = GetPlayerDataByPeri($SQLObj0,$a_h_id[$i],1);
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
    <span class="pageTitle">昨日最佳表現</span>
    <p class="dottedLine">&nbsp;</p>
    以下是 <?php echo $date;?> 的最佳表現
</div>  
<p class="line">&nbsp;</p>

<br />
<div class="v12 b lh26">
單日玩家積分排行</div>
<div class="bgbox">
<table class="data">
    <tr>
        <th colspan="4" class="tleft border">隊伍資訊</th>
		<th colspan="2">積分
</td>	</tr>
	<tr class="neutral">

		<td class="tleft">排名</td>
		<td class="tleft">隊徽</td>
		<td class="tleft">隊伍名稱</td>
	  <td class="tleft border"><span class="tleft">玩家名稱</span></td>
	  <td class="tleft">本季積分</td>
		<td class="tleft">單日積分</td>
     </tr>
     <?php
     if(IsSeasonStart())
     {
	 for($i=0;$i<10;$i++)
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
			
			<?php
			$str = "SELECT * FROM myteam_index WHERE myteam_id='".$a_t_id[$i]."'";
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			$userid = $SQLObj0->GetData('USER_ID');
			?>
			
            <td><?php echo ($i+1);?></td>
            <td><a href="res_roster.php?myteamid=<?php echo $a_t_id[$i];?>&mm=<?php echo $mm;?>&dd=<?php echo $dd;?>"><?php echo GetIcon24($userid);?></a></td>
    		<td class="tleft"><a href="res_roster.php?myteamid=<?php echo $a_t_id[$i];?>&mm=<?php echo $mm;?>&dd=<?php echo $dd;?>"><?php echo GetMyteamName($SQLObj0,$a_t_id[$i]);?></a></td>
            
       <td class="border"><?php echo GetNickname($SQLObj0,$userid);?></td>
            <td><?php echo $a_t_tol_points[$i];?></td>
   			<td><?php echo $a_t_points[$i];?></td>
    </tr>
    <?php
	}
    }
	?> </table>

</div>
<br />
    
<div class="v12 b lh26">單日投手積分排行</div>
<table class="data tright">
    <tr>
      <th class="tleft" colspan="15">選手資訊</th>
    </tr>
    <tr class="neutral">
            
                                                                                        <td id="abbrev" class="tleft first "><!-- <span class="header_link" onClick="submitresearch('abbrev')"> --><!-- </span> -->
                                                                                        <span class=" ">選手名稱</span></td>
                                                                                       <td id="short_name" class=" "><!-- <span class="header_link" onClick="submitresearch('short_name')"> -->
                                                                                       <span class="tleft first ">位置</span><!-- </span> --></td>

                                                                                       <td id="team_name_short" class=" "><!-- <span class="header_link" onClick="submitresearch('team_name_short')"> -->球隊<!-- </span> --></td>
                                                                                       <td id="wins" class=" "><!-- <span class="header_link" onClick="submitresearch('wins')"> -->W<!-- </span> --></td>
                                                                                       <td id="losses" class=" "><!-- <span class="header_link" onClick="submitresearch('losses')"> -->L<!-- </span> --></td>
                                                                                       <td id="saves" class=" "><!-- <span class="header_link" onClick="submitresearch('saves')"> -->S<!-- </span> --></td>
                                                                                       <td id="struckout" class=" "><!-- <span class="header_link" onClick="submitresearch('struckout')"> -->K<!-- </span> --></td>
                                                                                       <td id="era" class=" "><!-- <span class="header_link" onClick="submitresearch('era')"> -->ERA<!-- </span> --></td>

                                                                                       <td id="whip" class=" "><!-- <span class="header_link" onClick="submitresearch('whip')"> -->WHIP<!-- </span> --></td>
                                                                                       <td id="last_swp" class=" "><!-- <span class="header_link" onClick="submitresearch('last_swp')"> -->
                                                                                       <span class="tleft">單日積分</span>                                                                                         <!-- </span> --></td>
      <td id="frozen" class=" "><!-- <span class="header_link" onClick="submitresearch('frozen')"> -->買入<!-- </span> --></td>
  </tr>
	     <?php
	 for($i=0;$i<10;$i++)
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
            <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_p_id[$i];?>"><?php echo GetPlayerName2($SQLObj0,$a_p_id[$i]);?></a></td>
            <td><a href="res_playerdata.php?view=1&playerid=<?php echo $a_p_id[$i];?>"><?php echo GetPlayerPos($SQLObj0,$a_p_id[$i]);?></a></td>
    <td><a href="res_team.php?teamid=<?php echo GetTeamIDByPlayerID($SQLObj0,$a_p_id[$i]);?>"><?php echo GetTeamNameByPlayerID($SQLObj0,$a_p_id[$i]);?></a><a href="team_page.html?team_id=25"></a></td>
    <td><?php echo $a_pitcher[$i]['col1'];?></td>
    <td><?php echo $a_pitcher[$i]['col2'];?></td>
    <td><?php echo $a_pitcher[$i]['col3'];?></td>
    <td><?php echo $a_pitcher[$i]['col9'];?></td>
    <td><?php echo $a_pitcher[$i]['col13'];?></td>
    <td><?php echo $a_pitcher[$i]['col12'];?></td>
    <td><?php echo $a_p_points[$i];?></td>
    <td><a href="trade.php?addid=<?php echo $a_p_id[$i];?>"><?php echo ShowPrice1(GetPlayerPrice($SQLObj0,$a_p_id[$i]));?></a></td>
    </tr>
    <?php
	}
	?>
</table>
<div class="v12 b lh26">單日投手積分排行</div>
<table class="data tright">
<tr>
  <th class="tleft" colspan="15">選手資訊</th>
</tr>

    <tr class="neutral">
      <td id="abbrev" class="tleft first "><!-- <span class="header_link" onClick="submitresearch('abbrev')"> -->
          <!-- </span> -->
          <span class=" ">選手名稱</span></td>
      <td id="short_name" class=" "><!-- <span class="header_link" onClick="submitresearch('short_name')"> -->
          <span class="tleft first ">位置</span>
        <!-- </span> --></td>
      <td id="team_name_short" class=" "><!-- <span class="header_link" onClick="submitresearch('team_name_short')"> -->
        球隊
          <!-- </span> --></td>
            
                                                                                       <td id="at_bats" class=" "><!-- <span class="header_link" onClick="submitresearch('at_bats')"> -->AB<!-- </span> --></td>
                                                                                       <td id="hits" class=" "><!-- <span class="header_link" onClick="submitresearch('hits')"> -->
                                                                                       Runs<!-- </span> --></td>

      <td id="homeruns" class=" "><!-- <span class="header_link" onClick="submitresearch('homeruns')"> -->
      Hits<!-- </span> --></td>
      <td id="rbis" class=" "><!-- <span class="header_link" onClick="submitresearch('rbis')"> -->
      HR<!-- </span> --></td>
                                                                                       <td id="runs" class=" "><!-- <span class="header_link" onClick="submitresearch('runs')"> --><!-- </span> -->
                                                                                       RBI</td>
      <td id="stolen_bases" class=" "><!-- <span class="header_link" onClick="submitresearch('stolen_bases')"> -->SB<!-- </span> --></td>
                                                                                       <td id="last_swp" class=" "><!-- <span class="header_link" onClick="submitresearch('last_swp')"> -->
                                                                                           <span class="tleft">單日積分</span>
                                                                                           <!-- </span> --></td>
                                                                                       <td id="frozen" class=" "><!-- <span class="header_link" onClick="submitresearch('frozen')"> -->
                                                                                         買入
                                                                                           <!-- </span> --></td>
    </tr>
	
    <?php
	 for($i=0;$i<10;$i++)
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
            <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_h_id[$i];?>"><?php echo GetPlayerName2($SQLObj0,$a_h_id[$i]);?></a></td><td><a href="res_playerdata.php?view=1&playerid=<?php echo $a_h_id[$i];?>"><?php echo GetPlayerPos($SQLObj0,$a_h_id[$i]);?></a></td><td><a href="res_team.php?teamid=<?php echo GetTeamIDByPlayerID($SQLObj0,$a_h_id[$i]);?>"><?php echo GetTeamNameByPlayerID($SQLObj0,$a_h_id[$i]);?></a><a href="team_page.html?team_id=27"></a></td>
      <td><?php echo $a_hitter[$i]['col1'];?></td>
      <td><?php echo $a_hitter[$i]['col2'];?></td>
      <td><?php echo $a_hitter[$i]['col3'];?></td>
      <td><?php echo $a_hitter[$i]['col6'];?></td>
      <td><?php echo $a_hitter[$i]['col7'];?></td>
      <td><?php echo $a_hitter[$i]['col8'];?></td>
      <td><?php echo $a_h_points[$i];?></td><td><a href="trade.php?addid=<?php echo $a_h_id[$i];?>"><?php echo ShowPrice1(GetPlayerPrice($SQLObj0,$a_h_id[$i]));?></a></td></tr>
      <?php
	  }
	 ?>

</table>
<?php include(dirname(__FILE__)."/down.php");?>


</body>
</html>