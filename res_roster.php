<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
//測試初始數據====================
//$_SESSION['loginid'] = 1;
//$_SESSION['name'] = '布魯斯';
//$_SESSION['nickname'] = "布魯斯爆炸";
//==============================
include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/npb.class.php");
$str = "SELECT * FROM myteam_index WHERE myteam_id='".$myteamid."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$userid = $SQLObj0->GetData('USER_ID');
}

if(!empty($userid))
{
	$str = "SELECT * FROM ".$ini_array['system']['dbpublic'].".user_data WHERE id=".$userid;
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$nickname = $SQLObj0->GetData('NICKNAME');
	}
}

$str = "SELECT * FROM myteam_data WHERE id='".$myteamid."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$myteamname = $SQLObj0->GetData('NAME');
}
$yy = 2008;
$date = $yy."-".sprintf("%02d",$mm)."-".sprintf("%02d",$dd);

//避免看到今天的名單
$str = "SELECT * FROM log_pricemove WHERE `datetime` >='".$date." 00:00:00'";
//echo $str;
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	//echo "OH!";
	$isok = TRUE;
}
else
{ 
	//echo "NO!";
	$isok = FALSE;
}

if(IsSeasonStart() && $isok)
{
	//echo "OK";
	$str = "SELECT * FROM myteam_score_log WHERE teamid='".$myteamid."' AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 24:00:00'";
	//echo $str;
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$cash = $SQLObj0->GetData('CASH');
		$trade_1 = $SQLObj0->GetData('TRADE_1');
		$trade_2 = $SQLObj0->GetData('TRADE_2');
		$a_player[0]['id'] = $SQLObj0->GetData('P1');
		$a_player[1]['id'] = $SQLObj0->GetData('P2');
		$a_player[2]['id'] = $SQLObj0->GetData('P3');
		$a_player[3]['id'] = $SQLObj0->GetData('P4');
		$a_player[4]['id'] = $SQLObj0->GetData('P5');
		$a_player[5]['id'] = $SQLObj0->GetData('C');
		$a_player[6]['id'] = $SQLObj0->GetData('1B');
		$a_player[7]['id'] = $SQLObj0->GetData('2B');
		$a_player[8]['id'] = $SQLObj0->GetData('SS');
		$a_player[9]['id'] = $SQLObj0->GetData('3B');
		$a_player[10]['id'] = $SQLObj0->GetData('OF1');
		$a_player[11]['id'] = $SQLObj0->GetData('OF2');
		$a_player[12]['id'] = $SQLObj0->GetData('OF3');
		$a_player[13]['id'] = $SQLObj0->GetData('DH');
		//取得紀錄
		for($i=0;$i<14;$i++)
		{
			$a_player_base[$i] = GetPlayerBaseData($SQLObj0,$a_player[$i]['id']);
			
			$a_player[$i] = GetPlayerDataByDate($SQLObj0,$a_player[$i]['id'],$date);
			
			//如果這個位置沒有選手
			if(!$a_player[$i]['id'])
			{
				//顯示購買標籤
				$a_player_base[$i]['name_2'] = "-";
			}
			else 
			{
				$a_player_base[$i]['name_2'] = "<a href='res_playerdata.php?view=1&playerid=".$a_player[$i]['id']."'>".$a_player_base[$i]['name_2']."</a>";
			}
			//計算球隊資產
			$money += $a_player[$i]['price'];
			//增加賣出標籤
			if($a_player[$i]['price'] !== "-" && !IsForzen($SQLObj0,$a_player[$i]['id']))
			{
				$a_player[$i]['price'] = ShowPrice2($a_player[$i]['price']);
				//$a_player[$i]['price'] = "<a href='trade.php?delid=".$a_player[$i]['id']."'>".$a_player[$i]['price']."</a>";				
			}
			//金錢標準表示
				if(intval($a_player[$i]['pricemove']))
					$a_player[$i]['pricemove'] = $a_player[$i]['pricemove']."0,000";
		}
		$money += $cash;
	}
	//訂正
	$str = "SELECT * FROM myteam_data WHERE id=$myteamid";
	$SQLObj0->RunSQL($str);
	if($nrows = $SQLObj0->LinkNext())
	{
		$money = $SQLObj0->GetData('MONEY');
	}
	$money = ShowPrice1($money);
	$cash = ShowPrice1($cash);
	
	//取得userid
	$userid = GetUserIDByMyTeamID($SQLObj0,$myteamid);
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
.style20 {	font-size: 16px;
	font-weight: bold;
}
.style22 {font-size: 12px}
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
  
<div id="headerSection" style="padding: 0px;">
  <p><span class="style20"><?php echo $myteamname;?> </span><span class="style22">(<a href="myteam_scorelog.php?myteamid=<?php echo $myteamid;?>">歷史積分</a>)</span></p>
  <p>
  </p>
<table class="v12 w100" cellspacing="0" cellpadding="0">
      <col width="auto">
      <col width="10">
      <col width="300">
      <tr> </tr>
      <tr>
        <td class="vtop"><div class="v12 tleft" style="margin-bottom: 5px">隊伍資訊</div>
            <div class="tcenter">
              <!-- IE Center -->
              <table class="listing margin_center v12" cellspacing="0" cellpadding="0" style="border-bottom: none">
                <tr>
                  <td><span class="b">總積分: </span><?php echo GetTeamPoints($SQLObj0,$myteamid);?></td>
                  <td><span class="b">總資產: </span><?php echo $money;?></td>
                </tr>
                <tr>
                  <td><span class="b">分區排名: </span><?php echo "第 ".GetTeamLeaRank($SQLObj0,$myteamid)." 名 共 ".GetLeaCountByMyteamID($SQLObj0,$myteamid)." 隊";?></td>
                  <td><span class="b">資產排名: </span>
                  <?php 
	  $teamcount = GetTeamCount($SQLObj0);
	  $m_rank = GetMoneyRank($SQLObj0,$myteamid);
	  $last_m_rank = GetLastMoneyRank($SQLObj0,$myteamid);
	  echo "第 ".$m_rank." 名 共 ".$teamcount." 隊";
	  ?></td>
                </tr>
                <tr>
                  <td><span class="b">積分總排名:</span>
                  <?php 
	  
	  $p_rank = GetPointRank($SQLObj0,$myteamid);
	  $last_p_rank = GetLastPointRank($SQLObj0,$myteamid);
	  echo "第 ".$p_rank." 名 共 ".$teamcount." 隊";
	  ?></td>
                  <td class="vtop"><span class="b">剩下現金: </span><?php echo $cash;?></td>
                </tr>
                <tr>
                  <td><span class="b">投手交易次數:</span> <?php echo $trade_1;?></td>
                  <td><span class="b">打者交易次數:</span> <?php echo $trade_2;?></td>
                </tr>
              </table>
              <div class="cboth" style="border-bottom: 3px solid #DDD">&nbsp;</div>
              <br class="cboth" />
          </div></td>
        <td>&nbsp;</td>
        <td class="vtop"><div class="v12 tleft">玩家資訊</div>
            <table class="w100 v12 mar3" cellspacing="0" cellpadding="5">
              <col width="100">
              <col width="auto">
              <tr>
                <td class="vtop tcenter" style="background-color: #DEDEDE"><!-- bluezhin pix圖-->
                    <?php echo GetIcon48($userid);?> </td>
                <td class="vtop" style="background-color: #EEE"><!-- bluezhin 描述-->
                  玩家: <?php echo $nickname;?> <BR>
                  榮譽: <?php
                        $honor = GetHonor($SQLObj0,$userid);
                        for($i=0;$i<$honor;$i++)
                        echo "<img src=images/star.gif>";
                        ?> </td>
              </tr>
            </table>
          <!--Google Ad 1 //-->
          <div style="v-align:top;text-align:center;">
				<center>
                 <script type="text/javascript"><!--
				google_ad_client = "pub-9317450467103032";
				/* 234x60, 已建立 2008/2/17 */
				google_ad_slot = "5579207315";
				google_ad_width = 234;
				google_ad_height = 60;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script> 
			</div>
        </td>
      </tr>
    </table>
    <br class="cboth" />
</div>




<table class="tableTitle">
    <tr>
        <td class="title">球隊陣容</td>
        <td class="titleLink">
    </tr>
</table>
	  <table class="tright data">

          <tr class="neutral">
	    
                </tr>
 
        
    	
</table>
<table class="v12 data tright">
          <tr class="tcenter">
              <th class="v12" colspan="4">選手資訊</th>
                <th class="v12 border" colspan="8">紀錄</th>
                <th class="v12 border" colspan="3">積分</th>
                <th class="v12" colspan="2">價錢</th>                                                
           </tr>
   
               <tr class="neutral">
                          
                    <td class="tleft first">位置</td>
                         <td class="tleft">投手</td>
                         <td class="tleft">隊伍</td>

                        <td class="border">下次對手</td>
                         <td class="tleft">IP</td>
                         <td class="tleft">W</td>
                         <td class="tleft">L</td>
                         <td class="tleft">S</td>
                         <td class="tleft">K</td>
                         <td class="tleft">TBBS</td>
                         <td class="tleft">ERA</td>
                        <td class="border">WHIP</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">平均</td>

                         <td class="tleft">漲跌</td>
                         <!--<td class="tleft"></td>-->
                         <td class="tleft">賣出</td>
                </tr>          
                    <tr class="odd"><td class="tleft border">
                    <select name="6559" class="v9 mar0 pad0"><option value="1" class="v10" selected="selected">P</option></select></td><td class="tleft"><a href="player.html?player_id=6559"><?php echo $a_player_base[0]['name_2'];?></a>  </td>
          <td><a href="res_team.php?teamid=<?php echo $a_player_base[0]['teamid'];?>"><?php echo $a_player_base[0]['teamname_2'];?></a><a href="team_page.html?team_id=16"></a></td>
          <td class="border"><?php echo $a_player_base[0]['schedule'];?>
          <td class="tleft"><?php echo $a_player[0]['col4'].".".$a_player[0]['col5'];?></td>
          <td class="tleft"><?php echo $a_player[0]['col1'];?></td>
          <td class="tleft"><?php echo $a_player[0]['col2'];?></td>
          <td class="tleft"><?php echo $a_player[0]['col3'];?></td>
          <td class="tleft"><?php echo $a_player[0]['col9'];?></td>
          <td class="tleft"><?php echo $a_player[0]['col8'];?></td>
          <td class="tleft"><?php echo $a_player[0]['era'];?></td>
          <td class="border"><?php echo $a_player[0]['whip'];?>
          <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[0]['id']);?></td>
          <td class="tleft"><?php echo $allpoints[0];?></td>
          <td class="border"><?php echo $a_player[0]['avg_p'];?>
          <td class="tleft"><?php echo $a_player[0]['pricemove'];?></td><td class="tright"><?php echo $a_player[0]['price'];?></td>
          </tr><tr class="even"><td class="tleft border">
                    <select name="7205" class="v9 mar0 pad0"><option value="1" class="v10" selected="selected">P</option></select></td>
            <td class="tleft"><a href="player.html?player_id=6559"><?php echo $a_player_base[1]['name_2'];?></a> </td>
            <td><a href="res_team.php?teamid=<?php echo $a_player_base[1]['teamid'];?>"><?php echo $a_player_base[1]['teamname_2'];?></a><a href="team_page.html?team_id=16"></a></td>
            <td class="border"><?php echo $a_player_base[1]['schedule'];?>
            <td class="tleft"><?php echo $a_player[1]['col4'].".".$a_player[1]['col5'];?></td>
            <td class="tleft"><?php echo $a_player[1]['col1'];?></td>
            <td class="tleft"><?php echo $a_player[1]['col2'];?></td>
            <td class="tleft"><?php echo $a_player[1]['col3'];?></td>
            <td class="tleft"><?php echo $a_player[1]['col9'];?></td>
            <td class="tleft"><?php echo $a_player[1]['col8'];?></td>
            <td class="tleft"><?php echo $a_player[1]['era'];?></td>
            <td class="border"><?php echo $a_player[1]['whip'];?>
            <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[1]['id']);?></td>
            <td class="tleft"><?php echo $allpoints[1];?></td>
            <td class="border"><?php echo $a_player[1]['avg_p'];?>
            <td class="tleft"><?php echo $a_player[1]['pricemove'];?></td>
            <td class="tright"><?php echo $a_player[1]['price'];?></td>
          </tr><tr class="odd"><td class="tleft border">
            <select name="7906" class="v9 mar0 pad0"><option value="1" class="v10" selected="selected">P</option></select></td>
            <td class="tleft"><a href="player.html?player_id=6559"><?php echo $a_player_base[2]['name_2'];?></a> </td>
            <td><a href="res_team.php?teamid=<?php echo $a_player_base[2]['teamid'];?>"><?php echo $a_player_base[2]['teamname_2'];?></a><a href="team_page.html?team_id=16"></a></td>
            <td class="border"><?php echo $a_player_base[2]['schedule'];?>
            <td class="tleft"><?php echo $a_player[2]['col4'].".".$a_player[2]['col5'];?></td>
            <td class="tleft"><?php echo $a_player[2]['col1'];?></td>
            <td class="tleft"><?php echo $a_player[2]['col2'];?></td>
            <td class="tleft"><?php echo $a_player[2]['col3'];?></td>
            <td class="tleft"><?php echo $a_player[2]['col9'];?></td>
            <td class="tleft"><?php echo $a_player[2]['col8'];?></td>
            <td class="tleft"><?php echo $a_player[2]['era'];?></td>
            <td class="border"><?php echo $a_player[2]['whip'];?>
            <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[2]['id']);?></td>
            <td class="tleft"><?php echo $allpoints[2];?></td>
            <td class="border"><?php echo $a_player[2]['avg_p'];?>
            <td class="tleft"><?php echo $a_player[2]['pricemove'];?></td>
            <td class="tright"><?php echo $a_player[2]['price'];?></td>
          </tr><tr class="even"><td class="tleft border">
            <select name="7151" class="v9 mar0 pad0"><option value="1" class="v10" selected="selected">P</option></select></td>
            <td class="tleft"><a href="player.html?player_id=6559"><?php echo $a_player_base[3]['name_2'];?></a> </td>
            <td><a href="res_team.php?teamid=<?php echo $a_player_base[3]['teamid'];?>"><?php echo $a_player_base[3]['teamname_2'];?></a><a href="team_page.html?team_id=16"></a></td>
            <td class="border"><?php echo $a_player_base[3]['schedule'];?>
            <td class="tleft"><?php echo $a_player[3]['col4'].".".$a_player[3]['col5'];?></td>
            <td class="tleft"><?php echo $a_player[3]['col1'];?></td>
            <td class="tleft"><?php echo $a_player[3]['col2'];?></td>
            <td class="tleft"><?php echo $a_player[3]['col3'];?></td>
            <td class="tleft"><?php echo $a_player[3]['col9'];?></td>
            <td class="tleft"><?php echo $a_player[3]['col8'];?></td>
            <td class="tleft"><?php echo $a_player[3]['era'];?></td>
            <td class="border"><?php echo $a_player[3]['whip'];?>
            <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[3]['id']);?></td>
            <td class="tleft"><?php echo $allpoints[3];?></td>
            <td class="border"><?php echo $a_player[3]['avg_p'];?>
            <td class="tleft"><?php echo $a_player[3]['pricemove'];?></td>
            <td class="tright"><?php echo $a_player[3]['price'];?></td>
          </tr><tr class="odd"><td class="tleft border">
            <select name="7779" class="v9 mar0 pad0"><option value="1" class="v10" selected="selected">P</option></select></td>
            <td class="tleft"><a href="player.html?player_id=6559"><?php echo $a_player_base[4]['name_2'];?></a> </td>
            <td><a href="res_team.php?teamid=<?php echo $a_player_base[4]['teamid'];?>"><?php echo $a_player_base[4]['teamname_2'];?></a><a href="team_page.html?team_id=16"></a></td>
            <td class="border"><?php echo $a_player_base[4]['schedule'];?>
            <td class="tleft"><?php echo $a_player[4]['col4'].".".$a_player[4]['col5'];?></td>
            <td class="tleft"><?php echo $a_player[4]['col1'];?></td>
            <td class="tleft"><?php echo $a_player[4]['col2'];?></td>
            <td class="tleft"><?php echo $a_player[4]['col3'];?></td>
            <td class="tleft"><?php echo $a_player[4]['col9'];?></td>
            <td class="tleft"><?php echo $a_player[4]['col8'];?></td>
            <td class="tleft"><?php echo $a_player[4]['era'];?></td>
            <td class="border"><?php echo $a_player[4]['whip'];?>
            <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[4]['id']);?></td>
            <td class="tleft"><?php echo $allpoints[4];?></td>
            <td class="border"><?php echo $a_player[4]['avg_p'];?>
            <td class="tleft"><?php echo $a_player[4]['pricemove'];?></td>
            <td class="tright"><?php echo $a_player[4]['price'];?></td>
          </tr>

                           
            
<tr class="neutral">

<td class="tleft first">Pos</td>
                         <td class="tleft">捕手</td>
                         <td class="tleft">隊伍</td>
                        <td class="border">下次對手</td>
                         <td class="tleft">GP</td>

                         <td class="tleft">AB</td>
                         <td class="tleft">Runs</td>
                         <td class="tleft">HR</td>
                         <td class="tleft">RBI</td>
                         <td class="tleft">SB</td>
                         <td class="tleft">BA</td>
                        <td class="border">SLG</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">平均</td>
                         <td class="tleft">最新</td>
                         <td class="tleft">賣出</td>
</tr>          
<tr class="odd"><td class="tleft border">

<select name="select0" id="select0" class="v9 mar0 pad0">
              <?php 
          if($a_player_base[5]['c']) echo "<option selected class='v10' value='5'>C</option>";
          if($a_player_base[5]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[5]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[5]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[5]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[5]['of']) echo "<option class='v10' value='10'>OF</option>";
		  if($a_player_base[5]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
            </select>

</td><td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[5]['id'];?>"><?php echo $a_player_base[5]['name_2'];?></a></td><td><a href="res_team.php?teamid=<?php echo $a_player_base[5]['teamid'];?>"><?php echo $a_player_base[5]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td><td class="border"><?php echo $a_player_base[5]['schedule'];?>
<td class="tleft"><?php echo $a_player[5]['g']?></td><td class="tleft"><?php echo $a_player[5]['col1'];?></td><td class="tleft"><?php echo $a_player[5]['col2'];?></td><td class="tleft"><?php echo $a_player[5]['col6'];?></td><td class="tleft"><?php echo $a_player[5]['col7'];?></td><td class="tleft"><?php echo $a_player[5]['col8'];?></td><td class="tleft"><?php echo $a_player[5]['avg'];?></td><td class="border"><?php echo $a_player[5]['slg'];?>
<td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[5]['id']);?></td><td class="tleft"><?php echo $allpoints[5];?></td><td class="border"><?php echo $a_player[5]['avg_p'];?>
<td class="tleft"><?php echo $a_player[5]['pricemove'];?></td><td class="tright"><?php echo $a_player[5]['price'];?></td></tr>



<tr class="neutral">

<td class="tleft first">Pos</td>
                         <td class="tleft">一壘手</td>
                         <td class="tleft">隊伍</td>
                        <td class="border">下次對手</td>
                         <td class="tleft">GP</td>

                         <td class="tleft">AB</td>
                         <td class="tleft">Runs</td>
                         <td class="tleft">HR</td>
                         <td class="tleft">RBI</td>
                         <td class="tleft">SB</td>
                         <td class="tleft">BA</td>
                        <td class="border">SLG</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">每場</td>
                         <td class="tleft">最新</td>
                         <td class="tleft">賣出</td>
</tr>          
<tr class="odd"><td class="tleft border"><select name="select" id="select" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[6]['c']) echo "<option  class='v10' value='5'>C</option>";
          if($a_player_base[6]['1b']) echo "<option selected class='v10' value='6'>1B</option>";
          if($a_player_base[6]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[6]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[6]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[6]['of']) echo "<option class='v10' value='10'>OF</option>";
		  if($a_player_base[6]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[6]['id'];?>"><?php echo $a_player_base[6]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[6]['teamid'];?>"><?php echo $a_player_base[6]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[6]['schedule'];?>
  <td class="tleft"><?php echo $a_player[6]['g']?></td>
  <td class="tleft"><?php echo $a_player[6]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[6]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[6]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[6]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[6]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[6]['avg'];?></td>
  <td class="border"><?php echo $a_player[6]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[6]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[6];?></td>
  <td class="border"><?php echo $a_player[6]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[6]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[6]['price'];?></td>
</tr>



<tr class="neutral">

<td class="tleft first">Pos</td>
                         <td class="tleft">二壘手</td>
                         <td class="tleft">隊伍</td>
                        <td class="border">下次對手</td>
                         <td class="tleft">GP</td>

                         <td class="tleft">AB</td>
                         <td class="tleft">Runs</td>
                         <td class="tleft">HR</td>
                         <td class="tleft">RBI</td>
                         <td class="tleft">SB</td>
                         <td class="tleft">BA</td>
                        <td class="border">SLG</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">每場</td>
                         <td class="tleft">最新</td>
                         <td class="tleft">賣出</td>
</tr>          
<tr class="odd"><td class="tleft border"><select name="select2" id="select2" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[7]['c']) echo "<option  class='v10' value='5'>C</option>";
          if($a_player_base[7]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[7]['2b']) echo "<option selected class='v10' value='7'>2B</option>";
          if($a_player_base[7]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[7]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[7]['of']) echo "<option class='v10' value='10'>OF</option>";
		  if($a_player_base[7]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[7]['id'];?>"><?php echo $a_player_base[7]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[7]['teamid'];?>"><?php echo $a_player_base[7]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[7]['schedule'];?>
  <td class="tleft"><?php echo $a_player[7]['g']?></td>
  <td class="tleft"><?php echo $a_player[7]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[7]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[7]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[7]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[7]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[7]['avg'];?></td>
  <td class="border"><?php echo $a_player[7]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[7]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[7];?></td>
  <td class="border"><?php echo $a_player[7]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[7]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[7]['price'];?></td>
</tr>



<tr class="neutral">

<td class="tleft first">Pos</td>
                         <td class="tleft">游擊手</td>
                         <td class="tleft">隊伍</td>
                        <td class="border">下次對手</td>
                         <td class="tleft">GP</td>

                         <td class="tleft">AB</td>
                         <td class="tleft">Runs</td>
                         <td class="tleft">HR</td>
                         <td class="tleft">RBI</td>
                         <td class="tleft">SB</td>
                         <td class="tleft">BA</td>
                        <td class="border">SLG</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">每場</td>
                         <td class="tleft">最新</td>
                         <td class="tleft">賣出</td>
</tr>          
<tr class="odd"><td class="tleft border"><select name="select3" id="select3" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[8]['c']) echo "<option class='v10' value='5'>C</option>";
          if($a_player_base[8]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[8]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[8]['ss']) echo "<option selected class='v10' value='8'>SS</option>";
          if($a_player_base[8]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[8]['of']) echo "<option class='v10' value='10'>OF</option>";
		  if($a_player_base[8]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[8]['id'];?>"><?php echo $a_player_base[8]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[8]['teamid'];?>"><?php echo $a_player_base[8]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[8]['schedule'];?>
  <td class="tleft"><?php echo $a_player[8]['g']?></td>
  <td class="tleft"><?php echo $a_player[8]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[8]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[8]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[8]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[8]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[8]['avg'];?></td>
  <td class="border"><?php echo $a_player[8]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[8]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[8];?></td>
  <td class="border"><?php echo $a_player[8]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[8]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[8]['price'];?></td>
</tr>



<tr class="neutral">

<td class="tleft first">Pos</td>
                         <td class="tleft">三壘手</td>
                        <td class="tleft">隊伍</td>
                        <td class="border">下次對手</td>
                         <td class="tleft">GP</td>

                         <td class="tleft">AB</td>
                         <td class="tleft">Runs</td>
                         <td class="tleft">HR</td>
                         <td class="tleft">RBI</td>
                         <td class="tleft">SB</td>
                         <td class="tleft">BA</td>
                        <td class="border">SLG</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">每場</td>
                         <td class="tleft">最新</td>
                         <td class="tleft">賣出</td>
</tr>          
<tr class="odd"><td class="tleft border"><select name="select4" id="select4" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[9]['c']) echo "<option class='v10' value='5'>C</option>";
          if($a_player_base[9]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[9]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[9]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[9]['3b']) echo "<option selected class='v10' value='9'>3B</option>";
          if($a_player_base[9]['of']) echo "<option class='v10' value='10'>OF</option>";
		  if($a_player_base[9]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[9]['id'];?>"><?php echo $a_player_base[9]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[9]['teamid'];?>"><?php echo $a_player_base[9]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[9]['schedule'];?>
  <td class="tleft"><?php echo $a_player[9]['g']?></td>
  <td class="tleft"><?php echo $a_player[9]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[9]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[9]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[9]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[9]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[9]['avg'];?></td>
  <td class="border"><?php echo $a_player[9]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[9]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[9];?></td>
  <td class="border"><?php echo $a_player[9]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[9]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[9]['price'];?></td>
</tr>



<tr class="neutral">

<td class="tleft first">Pos</td>
                         <td class="tleft">外野手</td>
                         <td class="tleft">隊伍</td>
                        <td class="border">下次對手</td>
                         <td class="tleft">GP</td>

                         <td class="tleft">AB</td>
                         <td class="tleft">Runs</td>
                         <td class="tleft">HR</td>
                         <td class="tleft">RBI</td>
                         <td class="tleft">SB</td>
                         <td class="tleft">BA</td>
                        <td class="border">SLG</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">每場</td>
                         <td class="tleft">最新</td>
                         <td class="tleft">賣出</td>
</tr>          
<tr class="odd"><td class="tleft border"><select name="select5" id="select5" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[10]['c']) echo "<option class='v10' value='5'>C</option>";
          if($a_player_base[10]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[10]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[10]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[10]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[10]['of']) echo "<option selected class='v10' value='10'>OF</option>";
		  if($a_player_base[10]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[10]['id'];?>"><?php echo $a_player_base[10]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[10]['teamid'];?>"><?php echo $a_player_base[10]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[10]['schedule'];?>
  <td class="tleft"><?php echo $a_player[10]['g']?></td>
  <td class="tleft"><?php echo $a_player[10]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[10]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[10]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[10]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[10]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[10]['avg'];?></td>
  <td class="border"><?php echo $a_player[10]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[10]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[10];?></td>
  <td class="border"><?php echo $a_player[10]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[10]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[10]['price'];?></td>
</tr><tr class="even"><td class="tleft border"><select name="select6" id="select6" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[11]['c']) echo "<option class='v10' value='5'>C</option>";
          if($a_player_base[11]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[11]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[11]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[11]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[11]['of']) echo "<option selected class='v10' value='10'>OF</option>";
		  if($a_player_base[11]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[11]['id'];?>"><?php echo $a_player_base[11]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[11]['teamid'];?>"><?php echo $a_player_base[11]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[11]['schedule'];?>
  <td class="tleft"><?php echo $a_player[11]['g']?></td>
  <td class="tleft"><?php echo $a_player[11]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[11]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[11]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[11]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[11]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[11]['avg'];?></td>
  <td class="border"><?php echo $a_player[11]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[11]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[11];?></td>
  <td class="border"><?php echo $a_player[11]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[11]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[11]['price'];?></td>
</tr><tr class="odd"><td class="tleft border"><select name="select7" id="select7" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[12]['c']) echo "<option class='v10' value='5'>C</option>";
          if($a_player_base[12]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[12]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[12]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[12]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[12]['of']) echo "<option selected class='v10' value='10'>OF</option>";
		  if($a_player_base[12]['dh']) echo "<option class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[12]['id'];?>"><?php echo $a_player_base[12]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[12]['teamid'];?>"><?php echo $a_player_base[12]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[12]['schedule'];?>
  <td class="tleft"><?php echo $a_player[12]['g']?></td>
  <td class="tleft"><?php echo $a_player[12]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[12]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[12]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[12]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[12]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[12]['avg'];?></td>
  <td class="border"><?php echo $a_player[12]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[12]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[12];?></td>
  <td class="border"><?php echo $a_player[12]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[12]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[12]['price'];?></td>
</tr>



<tr class="neutral">

<td class="tleft first">Pos</td>
                         <td class="tleft">DH</td>
                         <td class="tleft">隊伍</td>
                        <td class="border">下次對手</td>
                         <td class="tleft">GP</td>

                         <td class="tleft">AB</td>
                         <td class="tleft">Runs</td>
                         <td class="tleft">HR</td>
                         <td class="tleft">RBI</td>
                         <td class="tleft">SB</td>
                         <td class="tleft">BA</td>
                        <td class="border">SLG</td>
                        
                         <td class="tleft">最新</td>
                         <td class="tleft">總分</td>
                        <td class="border">每場</td>
                         <td class="tleft">最新</td>
                         <td class="tleft">賣出</td>
</tr>          
<tr class="odd"><td class="tleft border"><select name="select8" id="select8" class="v9 mar0 pad0">
  <?php 
          if($a_player_base[13]['c']) echo "<option class='v10' value='5'>C</option>";
          if($a_player_base[13]['1b']) echo "<option class='v10' value='6'>1B</option>";
          if($a_player_base[13]['2b']) echo "<option class='v10' value='7'>2B</option>";
          if($a_player_base[13]['ss']) echo "<option class='v10' value='8'>SS</option>";
          if($a_player_base[13]['3b']) echo "<option class='v10' value='9'>3B</option>";
          if($a_player_base[13]['of']) echo "<option class='v10' value='10'>OF</option>";
		  if($a_player_base[13]['dh']) echo "<option selected class='v10' value='13'>DH</option>";
          ?>
</select></td>
  <td class="tleft"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[13]['id'];?>"><?php echo $a_player_base[13]['name_2'];?></a></td>
  <td><a href="res_team.php?teamid=<?php echo $a_player_base[13]['teamid'];?>"><?php echo $a_player_base[13]['teamname_2'];?></a><a href="team_page.html?team_id=5"></a></td>
  <td class="border"><?php echo $a_player_base[13]['schedule'];?>
  <td class="tleft"><?php echo $a_player[13]['g']?></td>
  <td class="tleft"><?php echo $a_player[13]['col1'];?></td>
  <td class="tleft"><?php echo $a_player[13]['col2'];?></td>
  <td class="tleft"><?php echo $a_player[13]['col6'];?></td>
  <td class="tleft"><?php echo $a_player[13]['col7'];?></td>
  <td class="tleft"><?php echo $a_player[13]['col8'];?></td>
  <td class="tleft"><?php echo $a_player[13]['avg'];?></td>
  <td class="border"><?php echo $a_player[13]['slg'];?>
  <td class="tleft"><?php echo GetPlayerLastPoints($SQLObj0,$a_player[13]['id']);?></td>
  <td class="tleft"><?php echo $allpoints[13];?></td>
  <td class="border"><?php echo $a_player[13]['avg_p'];?>
  <td class="tleft"><?php echo $a_player[13]['pricemove'];?></td>
  <td class="tright"><?php echo $a_player[13]['price'];?></td>
</tr>
 </table>

<?php include(dirname(__FILE__)."/down.php");?>

</body>
</html>