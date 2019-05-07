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
/*
//先取得球隊id
$str = "SELECT * FROM myteam_index WHERE user_id=".$_SESSION['loginid'];

$SQLObj0->RunSQL($str);
//如果沒有隊伍則轉址到新增隊伍
if(!$SQLObj0->LinkNext())
{
	?>
	<script language="javascript">
	//轉址
	self.location.href='myteam_addteam.php';
	</script>
	<?php
}
else 
	$testid = $SQLObj0->GetData('myteam_id');
*/

$testid = 199;

//紀錄時間避免不活耀
$gmnow = gmdate("Y-m-d H:i:s",gmmktime(gmdate("H")+8,gmdate("i"),gmdate("s"),gmdate("m"),gmdate("d"),gmdate("Y")));	
$sqlstr = "UPDATE `mumutoys_npb0801`.`myteam_data` SET `lastlogin`='".$gmnow."' 
	       WHERE 1 AND `id`='".$testid."'";
$SQLObj0->RunSQL($sqlstr);
                    	
if($_POST['action'] == 1)
{
	$MyTeamObj = new MyTeamObj();
	$MyTeamObj->GetData($SQLObj0,$testid);
	$j=0;
	//將球員移動到temp
	for($i=0;$i<9;$i++)
	{
		echo $MyTeamObj->pos[($i+5)]."<BR>";
		echo $_POST['select'.$i]."<BR>";
		if($_POST['select'.$i] && $_POST['select'.$i]!=($i+5) && ($i+5)!=10)
		{
			echo $i."->".$_POST['select'.$i]."<BR>";
			$a_changepos[$j]['id'] = $MyTeamObj->pos[($i+5)];
			$a_changepos[$j]['pos'] = $_POST['select'.$i];
			$MyTeamObj->pos[($i+5)] = 0;
			$j++;
		}
		else if($_POST['select'.$i] && ($i+5)>=10 && ($i+5)<=12 && $_POST['select'.$i]!=10)
		{
			//如果是外野手
			echo $i."外->野".$_POST['select'.$i]."<BR>";
			$a_changepos[$j]['id'] = $MyTeamObj->pos[($i+5)];
			$a_changepos[$j]['pos'] = $_POST['select'.$i];
			$MyTeamObj->pos[($i+5)] = 0;
			$j++;
		}
	}
	exit;
	//從temp加入球員
	$all_ok = TRUE;
	for($i=0;$i<$j;$i++)
	{
		if($MyTeamObj->pos[$a_changepos[$i]['pos']] == 0)
		{
			//echo $a_changepos[$i]['pos']."<BR>";
			$MyTeamObj->pos[$a_changepos[$i]['pos']] = $a_changepos[$i]['id'];
		}
		else if($a_changepos[$i]['pos'] == 10)
		{
			//如果是外野手
			if($MyTeamObj->pos[11] == 0)
			{
				$MyTeamObj->pos[11] = $a_changepos[$i]['id'];
			}
			else if($MyTeamObj->pos[12] == 0)
			{
				$MyTeamObj->pos[12] = $a_changepos[$i]['id'];
			}
			else 
			{
				$all_ok = FALSE;
				break;
			}
		}
		else 
		{
			$all_ok = FALSE;
			break;
		}
	}
	
	if($all_ok)
	{
		$MyTeamObj->Sort($SQLObj0);
		$MyTeamObj->UpdateDB($SQLObj0);
	}
	else 
	{
		?>
		<script language="javascript">
		alert("交換位置錯誤");
		</script>
		<?php
	}
}
$str = "SELECT * FROM myteam_data WHERE id='".$testid."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$myteamname = $SQLObj0->GetData('NAME');
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
		
		if($view == 1)
			$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],2008);
		elseif ($view == 2)
			$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],1);	
		elseif ($view == 3)
			$a_player[$i] = GetPlayerDataByYear($SQLObj0,$a_player[$i]['id'],2007);
		elseif ($view == 7)
			$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],7);		
		elseif ($view == 15)
			$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],15);	
		elseif ($view == 30)
			$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],30);	
		
		//如果這個位置沒有選手
		if(!$a_player[$i]['id'])
		{
			if($i < 5)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=p&orderby=price'>購買</a>";
			else if($i == 5)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=c&orderby=price'>購買</a>";
			else if($i == 6)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=1b&orderby=price'>購買</a>";
			else if($i == 7)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=2b&orderby=price'>購買</a>";
			else if($i == 8)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=ss&orderby=price'>購買</a>";
			else if($i == 9)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=3b&orderby=price'>購買</a>";
			else if($i >= 10 && $i <= 12)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=of&orderby=price'>購買</a>";
			else if($i == 13)
				$a_player_base[$i]['name_2'] = "<a href='res_searchplayer.php?pos=dh&orderby=price'>購買</a>";
			//顯示購買標籤
			//$a_player_base[$i]['name_2'] = "<a href='res_team.php?teamid=1'>購買</a>";
		}
		else 
		{
			$a_player_base[$i]['name_2'] = "<a href='res_playerdata.php?view=1&playerid=".$a_player[$i]['id']."'>".$a_player_base[$i]['name_2']."</a>";
		}
		//計算球隊資產
		$money += $a_player[$i]['price'];
		//echo $a_player[$i]['pricemove'];

		//增加賣出標籤
		if($a_player[$i]['price'] !== "-" && !IsForzen($SQLObj0,$a_player[$i]['id']))
		{
			$a_player[$i]['price'] = ShowPrice2($a_player[$i]['price']);
			$a_player[$i]['price'] = "<a href='trade.php?delid=".$a_player[$i]['id']."'>".$a_player[$i]['price']."</a>";
			//$a_player[$i]['pricemove'] = GetPriceMove($SQLObj0,$$a_player[$i]['id']);
			if($a_player[$i]['pricemove'] != 0)
				$a_player[$i]['pricemove'] = $a_player[$i]['pricemove']."0,000";
			/*
			if($a_player[$i]['pricemove'])
				$a_player[$i]['pricemove'] = $a_player[$i]['pricemove']."0,000";
			*/
		}
		else if($a_player[$i]['price'] !== "-")
		{
			$a_player[$i]['price'] = ShowPrice2($a_player[$i]['price']);
			//$a_player[$i]['pricemove'] = GetPriceMove($SQLObj0,$$a_player[$i]['id']);
			if($a_player[$i]['pricemove'] != 0)
				$a_player[$i]['pricemove'] = $a_player[$i]['pricemove']."0,000";
		}

	}
	$money += $cash;
}
$money = ShowPrice1($money);
$cash = ShowPrice1($cash);

for($i=0;$i<14;$i++)
{
	$allpoints[$i] = GetPlayerAllPoints($SQLObj0,$a_player[$i]['id']);
	$g = GetPlayerG($SQLObj0,$a_player[$i]['id']);
	if($g !=0)
		$a_player[$i]['avg_p'] = number_format($allpoints[$i] / GetPlayerG($SQLObj0,$a_player[$i]['id']),1);
	else 
		$a_player[$i]['avg_p'] = 0;
}

$str = "SELECT * FROM myteam_score_log WHERE teamid='".$testid."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$lastmoney = $SQLObj0->GetData("PRICEMOVE");
	$lastpoints = $SQLObj0->GetData("POINTS");
	if($lastmoney > 0)
	{
		$lastmoneystr = "<img src='images/up.gif'>".$lastmoney;	
	}
	else if($lastmoney < 0)
	{
		$lastmoneystr = "<img src='images/down.gif'>".(-$lastmoney);	
	}
	else 
	{
		$lastmoneystr = "-";
	}
	
	if($lastpoints > 0)
	{
		$$lastpointsstr = "<img src='images/up.gif'>".$lastpoints;	
	}
	else if($lastpoints < 0)
	{
		$$lastpointsstr = "<img src='images/down.gif'>".(-$lastpoints);	
	}
	else 
	{
		$lastpointsstr = "-";
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Fantasy NPB!!</title>
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
        <td>
        <?php
            include(dirname(__FILE__)."/include/head.inc.php");
        ?>
        </td>
    </tr>
</table>

<div id="headerSection" style="padding: 0px;">
    <span class="pageTitle">
    
    <?php echo $myteamname;?>
    
    </span>
    <br /><br />
        
    <table class="v12 w100" cellspacing="0" cellpadding="0">
        <col width="auto">
        <col width="10">
        <col width="300">
        <tr>
        </tr>
        <tr>
            <td class="vtop">
                <div class="v12 tleft" style="margin-bottom: 5px">隊伍資訊</div>
                
	                <div class="tcenter"> <!-- IE Center -->
	                    <table class="listing margin_center v12" cellspacing="0" cellpadding="0" style="border-bottom: none">
	                            
	                            <tr>
	                            <td><span class="b">總積分:</span> <?php echo GetTeamPoints($SQLObj0,$testid);?></td>
	                            <td><span class="b">總資產:</span> <?php echo $money;?></td>
	                            </tr>
	                            <tr><td><span class="b">分區排名:</span> <?php echo "第 ".GetTeamLeaRank($SQLObj0,$testid)." 名 共 ".GetLeaCount($SQLObj0,$_SESSION['leaid'])." 隊";?></td>
	                            <td><span class="b">資產排名: </span>
	                              <?php 
	  //$teamcount = GetTeamCount($SQLObj0);
	  $teamcount = GetTeamCount($SQLObj0);
	  $m_rank = GetMoneyRank($SQLObj0,$testid);
	  $last_m_rank = GetLastMoneyRank($SQLObj0,$testid);
	  echo "第 ".$m_rank." 名";
	  
	  echo " 共 ".$teamcount." 隊";
	  ?></td>
	                            </tr>
	                            <tr><td><span class="b">積分總排名:</span>
	                              <?php 
	  $p_rank = GetPointRank($SQLObj0,$testid);
	  $last_p_rank = GetLastPointRank($SQLObj0,$testid);
	  echo "第 ".$p_rank." 名 ";

	  
	  echo " 共 ".$teamcount." 隊";
	  ?></td>
	                            <td class="vtop"><span class="b">剩下現金: </span><?php echo $cash;?></td>
	                            </tr>
	                            <tr><td><span class="b">投手交易次數: </span><?php echo $trade_1;?></td>
	                            <td><span class="b">打者交易次數: </span><?php echo $trade_2;?></td>
	                            </tr>
	                    </table>
	
	                 	<div class="cboth" style="border-bottom: 3px solid #DDD">&nbsp;</div>                
	                    <br class="cboth" />
                 	</div>
            </td>
            <td>&nbsp;</td>
            <td class="vtop">
                <div class="v12 tleft">玩家資訊</div>
                
                <table class="w100 v12 mar3" cellspacing="0" cellpadding="5">
                    <col width="100">
                    <col width="auto">
                    <tr>
                        <td class="vtop tcenter" style="background-color: #DEDEDE">
            
						<!-- bluezhin pix圖-->
						<?php echo GetIcon48($_SESSION['loginid']);?>
						
                        </td>
                        
                        
                        
                        <td class="vtop" style="background-color: #EEE">
                        <!-- bluezhin 描述-->
                        玩家: <?php echo $_SESSION['USERDATA']['nickname'];?><BR><BR>
                        榮譽: 
                        <?php
                        $honor = GetHonor($SQLObj0,$_SESSION['loginid']);
                        for($i=0;$i<$honor;$i++)
                        echo "<img src=images/star.gif>";
                        ?>
                      </td>
                    </tr>
                </table>
				<!--Google Ad 1 //-->    
            </td>    
        </tr>
    </table>
    <br class="cboth" />
</div>
<div style="v-align:top;text-align:center;">
<center>
<!--Google Ad //-->  
<script type="text/javascript"><!--
google_ad_client = "pub-9317450467103032";
/* myteam_lineup728x90, 已建立 2008/3/11 */
google_ad_slot = "6982867434";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<table class="v12 tableTitle">
    <tr>
        <td class="title">球隊陣容</td>
    </tr>
</table>
<div class="bgbox">
    
    <div class="v12 pad5">
        <div>
            <span>觀看:</span>
                                  
<!--            <span class="b">Main</span>
                              |  -->    
               
                                           
            <?php if($view != 1) echo "<a href='myteam_lineup.php?view=1'>";?>2008<?php if($view != 1) echo "</a>";?>
                              |      
               
                                           
            <?php if($view != 3) echo "<a href='myteam_lineup.php?view=3'>";?>2007<?php if($view != 3) echo "</a>";?>
                              |      
               
                                           
            <?php if($view != 2) echo "<a href='myteam_lineup.php?view=2'>";?>最新<?php if($view != 2) echo "</a>";?>
                              |      
               
                                           
            <?php if($view != 7) echo "<a href='myteam_lineup.php?view=7'>";?>最近7日<?php if($view != 7) echo "</a>";?>
                              |      
               
                                           
            <?php if($view != 15) echo "<a href='myteam_lineup.php?view=15'>";?>最近15日<?php if($view != 15) echo "</a>";?>
                              |      
               
                                           
            <?php if($view != 30) echo "<a href='myteam_lineup.php?view=30'>";?>最近30日<?php if($view != 30) echo "</a>";?>

            
                            </div>
           </div>
            <form id="form1" name="form1" method="post" action="" class="inline">
        <input type="hidden" name="hiddenString" />
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
                    <select name="select0" class="v9 mar0 pad0"><option value="1" class="v10" selected="selected">P</option></select></td><td class="tleft"><a href="player.html?player_id=6559"><?php echo $a_player_base[0]['name_2'];?></a>  </td>
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
    <div class="tright" style="margin: 5px 0px">

		<input type="submit" name="Submit" value="交換守備位置" class="mar5 v12"/>
        <input type="hidden" name="action" value="1" />
    </form>
        </div>
</div>

                             
    
<br />

<br>

<?php include(dirname(__FILE__)."/down.php");?>

</body>
</html>