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
$a_player_base = GetPlayerBaseData($SQLObj0,$playerid);
$a_schedule = GetSchedule7($SQLObj0,$a_player_base['teamid']);
//防守位置字串
$posstr = '';
$ishave = IsHave($SQLObj0,$playerid);
if($a_player_base['p'])
{
	if($ishave)
		$posstr = $posstr.'P ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=P'>P</a> ";
}
if($a_player_base['c'])
{
	if($ishave)
		$posstr = $posstr.'C ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=C'>C</a> ";
}
if($a_player_base['1b'])
{
	if($ishave)
		$posstr = $posstr.'1B ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=1B'>1B</a> ";
}
if($a_player_base['2b'])
{
	if($ishave)
		$posstr = $posstr.'2B ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=2B'>2B</a> ";
}
if($a_player_base['ss'])
{
	if($ishave)
		$posstr = $posstr.'SS ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=SS'>SS</a> ";
}
if($a_player_base['3b'])
{
	if($ishave)
		$posstr = $posstr.'3B ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=3B'>3B</a> ";
}
if($a_player_base['of'])
{
	if($ishave)
		$posstr = $posstr.'OF ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=OF'>OF</a> ";
}
if($a_player_base['dh'])
{
	if($ishave)
		$posstr = $posstr.'DH ';
	else
		$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=DH'>DH</a> ";
}
$price = GetPlayerPrice($SQLObj0,$playerid);

if($view == 1)
{
	//取得期間成績
	$a_player_1 = GetPlayerDataByPeri($SQLObj0,$playerid,1);
	$a_player_7 = GetPlayerDataByPeri($SQLObj0,$playerid,7);
	$a_player_15 = GetPlayerDataByPeri($SQLObj0,$playerid,15);
	$a_player_30 = GetPlayerDataByPeri($SQLObj0,$playerid,30);
	$a_player_365 = GetPlayerDataByPeri($SQLObj0,$playerid,365);
	$a_player_2006 = GetPlayerDataByYear($SQLObj0,$playerid,2006);
	$a_player_2007 = GetPlayerDataByYear($SQLObj0,$playerid,2007);
	
	$str = "SELECT * FROM player_record_log WHERE player_id = ".$playerid." ORDER BY `datetime` DESC LIMIT 16";
	$SQLObj0->RunSQL($str);
	$logcount = $SQLObj0->LinkAll();
	//echo $logcount;
	if($logcount)
	{
		$a_player_log['datetime'] = $SQLObj0->GetData('DATETIME');
		$a_player_log['g'] = $SQLObj0->GetData('G');
		for($j=1;$j<12;$j++)
			$a_player_log['col'.$j] = $SQLObj0->GetData('COL'.$j);
		$a_player_log['pricemove'] = $SQLObj0->GetData('PRICEMOVE');
		$count = count($a_player_log['g']);
		$isp = IsPicher($SQLObj0,$playerid);
		for($i=0;$i<$count;$i++)
		{
			//當日積分
			if($isp)
			{
				//echo $a_player_log['col1'][$i];
				$a_player_log['point'][$i] = $a_player_log['col1'][$i]*30-$a_player_log['col2'][$i]*15+$a_player_log['col3'][$i]*30+$a_player_log['col4'][$i]*15+$a_player_log['col5'][$i]*5-$a_player_log['col6'][$i]*5-$a_player_log['col8'][$i]*3+$a_player_log['col9'][$i]*3-$a_player_log['col11'][$i]*10;
				$tempip = $a_player_log['col5'][$i] - $a_player_log['col5'][$i]%3;
				$a_player_log['col5'][$i]-=$tempip;
				$a_player_log['col4'][$i]+=$tempip/3;
			}
			else 
				$a_player_log['point'][$i] = ($a_player_log['col1'][$i]-$a_player_log['col3'][$i])*(-2)+$a_player_log['col2'][$i]*5+$a_player_log['col3'][$i]*5+$a_player_log['col4'][$i]*5+$a_player_log['col5'][$i]*10+$a_player_log['col6'][$i]*15+$a_player_log['col7'][$i]*5+$a_player_log['col8'][$i]*10+$a_player_log['col9'][$i]*3-$a_player_log['col10'][$i];
			//當日價格
			//echo $a_player_log['datetime'][$i]."<BR>";
			$a_player_log['price'][$i] = GetPlayerPriceByDatetime($SQLObj0,$playerid,$a_player_log['datetime'][$i]);
		}
	} 
}
else if ($view == 2)
{
	$str = "SELECT * FROM player_record_log WHERE player_id = ".$playerid." ORDER BY `datetime` DESC";
	$SQLObj0->RunSQL($str);
	$logcount = $SQLObj0->LinkAll();
	//echo $logcount;
	if($logcount)
	{
		$a_player_log['datetime'] = $SQLObj0->GetData('DATETIME');
		$a_player_log['g'] = $SQLObj0->GetData('G');
		for($j=1;$j<12;$j++)
			$a_player_log['col'.$j] = $SQLObj0->GetData('COL'.$j);
		$a_player_log['pricemove'] = $SQLObj0->GetData('PRICEMOVE');
		$count = count($a_player_log['g']);
		$isp = IsPicher($SQLObj0,$playerid);
		for($i=0;$i<$count;$i++)
		{
			//當日積分
			if($isp)
			{
				//echo $a_player_log['col1'][$i];
				$a_player_log['point'][$i] = $a_player_log['col1'][$i]*30-$a_player_log['col2'][$i]*15+$a_player_log['col3'][$i]*30+$a_player_log['col4'][$i]*15+$a_player_log['col5'][$i]*5-$a_player_log['col6'][$i]*5-$a_player_log['col8'][$i]*3+$a_player_log['col9'][$i]*3-$a_player_log['col11'][$i]*10;
				$tempip = $a_player_log['col5'][$i] - $a_player_log['col5'][$i]%3;
				$a_player_log['col5'][$i]-=$tempip;
				$a_player_log['col4'][$i]+=$tempip/3;
			}
			else 
				$a_player_log['point'][$i] = ($a_player_log['col1'][$i]-$a_player_log['col3'][$i])*(-2)+$a_player_log['col2'][$i]*5+$a_player_log['col3'][$i]*5+$a_player_log['col4'][$i]*5+$a_player_log['col5'][$i]*10+$a_player_log['col6'][$i]*15+$a_player_log['col7'][$i]*5+$a_player_log['col8'][$i]*10+$a_player_log['col9'][$i]*3-$a_player_log['col10'][$i];
			//當日價格
			//echo $a_player_log['datetime'][$i]."<BR>";
			$a_player_log['price'][$i] = GetPlayerPriceByDatetime($SQLObj0,$playerid,$a_player_log['datetime'][$i]);
		}
	} 
}
var_dump($a_schedule);
exit;
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
<div id="headerSection" class="noborder" style="margin-bottom: 10px">
 
<div class="left">    
    <div class="pageTitle" style="margin-top: 5px"><span class="pageTitle"><?php echo $a_player_base['name_2']." ".$a_player_base['no'];?></span><span class="v10">&nbsp;<span class="style18"><?php echo"( ".$posstr." )";?></span> |&nbsp;球隊: <a href="res_team.php?teamid=<?php echo $a_player_base['teamid'];?>"><?php echo $a_player_base['teamname'];?></a> | </span><span class="v10"><?php 
//賣出標籤
if(IsForzen($SQLObj0,$playerid))
	$price = "凍結 $".ShowPrice1($price);
elseif(IsHave($SQLObj0,$playerid))
	$price = "<a href='trade.php?delid=".$playerid."'>賣出 ".ShowPrice1($price)."</a>";
else 
	$price = "<a href='trade.php?addid=".$playerid."'>買進 ".ShowPrice1($price)."</a>";
echo $price;
?></div>
<div class="lh26">
            觀看:
            <?php
			if($view == 2)
				echo "<a href='res_playerdata.php?view=1&playerid=".$playerid."'>";?>
            球員資料
            <?php
   			if($view == 2)
				echo "</a>";?>
            |
            <?php
			if($view == 1)
				echo "<a href='res_playerdata.php?view=2&playerid=".$playerid."'>";?>
            本季明細
            <?php
   			if($view == 1)
				echo "</a>";?>          
    </div>
        
  </div>
    <div class="right">
    
                             
            <a href="res_team.php?teamid=<?php echo $a_player_base['teamid'];?>"><span class="style18"><img src="images/teamicon/<?php echo $a_player_base['teamid'];?>.gif" width="32" height="32" border="1" /></span></a>    </div>                
  <br class="cboth" />
</div>

<?php
if($view == 1)
{
?>
<div class="left" style="width: 300px">
    <table class="data v12">
        <tr class="neutral">
          <td class="tleft">基本資料</td>
        </tr>
        <tr>
            <td style="background-color:#EEEEEE; padding: 5px; padding-left: 10px;" class="lh16">
                 
                        <!--<span class="b">Height:</span> 6'5"<br />
                        <span class="b">Weight:</span> 255lbs<br />-->

                        <span class="b">出生:</span> <?php echo $a_player_base['birth'];?><br />
                        <span class="b">打擊: </span><?php echo  $a_player_base['bat'];?><br />
                      <span class="b">投球:</span> <?php echo  $a_player_base['pitch'];?><br />

                    
                
                
                <!-- <br /> -->
                
                            
            </td>
        </tr>
    </table>    
   
    
    <br />
    
    <table class="data border v12" style="border-bottom: 3px solid #DDD">
        <tr>
            <th class="heading_group tleft" colspan="3">
                <div class="left">最近15日價乾變動</div>

                <div class="right"><a href='res_playerdata.php?view=2&playerid=<?php echo $playerid;?>'>觀看所有</a></div>
            </th>
        </tr>
        <tr class="neutral">
            <td class="tleft w50">日期</th>
            <td class="tleft w25">價錢</th>
          <td class="tright w25">價錢</th>變動

        </tr>
        <?php
		for($i=0;$i<15;$i++)
		{
        	if($i%2)
			{
				?><tr class="even"> <?php
			}
			else
			{
				?><tr class="odd"> <?php
			}?>                
              <td><?php echo substr($a_player_log['datetime'][$i],5,5);?></td>
              <td><?php echo ShowPrice1($a_player_log['price'][$i]);?></td>
              <td class="tright"><?php echo ShowPrice1($a_player_log['price'][$i]-$a_player_log['price'][$i+1]);?></td></tr>
      	<?php }?>
    
    </table>
    
    <br />
	<br />

<br />
       
</div>
<div id="playerRight" class="right" style="width: 470px;">
  <table class="w50 tableTitle v12">
	<tr>
        <td class="title">賽程</td>
	</tr>
</table>
<table class="tright data v12" style="border-bottom: 3px solid #DDD;">
    <tr class="tcenter">
    	<th class="border"><span class="style18"><?php echo $a_schedule[0]['datetime'];?></span></th>
   	  <th class="border"><span class="style18"><?php echo $a_schedule[1]['datetime'];?></span></th>
   	  <th class="border"><span class="style18"><?php echo $a_schedule[2]['datetime'];?></span></th>
   	  <th class="border"><span class="style18"><?php echo $a_schedule[3]['datetime'];?></span></th>
   	  <th class="border"><span class="style18"><?php echo $a_schedule[4]['datetime'];?></span></th>
   	  <th class="border"><span class="style18"><?php echo $a_schedule[5]['datetime'];?></span></th>
   	  <th class="border"><span class="style18"><?php echo $a_schedule[6]['datetime'];?></span></th>    
    </tr>

	<tr class="odd tcenter">
    
<?php
	for($i=0;$i<7;$i++)
	{
			if(!empty($a_schedule[$i]['team_name'])) {
			?>
			<td class='even border'><a href="res_team.php?teamid=<?php echo $a_schedule[$i]['teamid'];?>">				            <?php echo $a_schedule[0]['team_name'];?></a>
            <?php 
			}
			else 
				echo "<td>";            
           echo "</td>";
	}
	?>
	</tr>
</table>     <br />
    
    <table class="tableTitle  v12">
    	<tr>
            <td class="title">紀錄</td>
            <!-- <td class="titleLink"><a href="player.html?player_id=6559&view=game_log">Game Log</a></td> -->
    	</tr>

    </table>
    
    <?php
	//投手
    if($a_player_base['p'])
	{?>
<table class="tright data w100 v12" style="border-bottom: 3px solid #DDD">
        <tr class="neutral">
            <th class="tleft border">&nbsp;</th>
    
            <th>G</th>
            <th>IP</th>

            <th>W</th>
            <th>L</th>
            <th>Sv</th>
            <th>K</th>
            <th>TBBs</th>
            <th>ERA</th>

            <th class="border">WHIP</th>  
                       
            <th>積分</th>
            <th class="border">平均</th>
    	    <!-- <th>Price &Delta;</th> -->
        </tr>
        <tr class="odd">
              <td class="tleft border">本季</td>
              <td><?php echo $a_player_365['g'];?></td>
              <td><?php echo $a_player_365['col4'].".".$a_player_365['col5'];?></td>
              <td><?php echo $a_player_365['col1'];?></td>
              <td><?php echo $a_player_365['col2'];?></td>
              <td><?php echo $a_player_365['col3'];?></td>
              <td><?php echo $a_player_365['col9'];?></td><td><?php echo $a_player_365['col8'];?></td>
              <td><?php echo $a_player_365['era'];?></td>
              <td class="border"><?php echo $a_player_365['whip'];?></td>
              <td><?php echo $a_player_365['tol_p'];?></td>
              <td><?php echo $a_player_365['avg_p'];?></td>
        </tr>
        
        <tr class="even">
        <td class="tleft border">昨天</td>
        <td><?php echo $a_player_1['g'];?></td>
              <td><?php echo $a_player_1['col4'].".".$a_player_1['col5'];?></td>
              <td><?php echo $a_player_1['col1'];?></td>
              <td><?php echo $a_player_1['col2'];?></td>
              <td><?php echo $a_player_1['col3'];?></td>
              <td><?php echo $a_player_1['col9'];?></td><td><?php echo $a_player_1['col8'];?></td>
              <td><?php echo $a_player_1['era'];?></td>
              <td class="border"><?php echo $a_player_1['whip'];?></td>
              <td><?php echo $a_player_1['tol_p'];?></td>
              <td><?php echo $a_player_1['avg_p'];?></td>
          </tr>
          </tr>
        
        <tr class="odd">
          <td class="tleft border">7天</td>         
          <td><?php echo $a_player_7['g'];?></td>
              <td><?php echo $a_player_7['col4'].".".$a_player_7['col5'];?></td>
              <td><?php echo $a_player_7['col1'];?></td>
              <td><?php echo $a_player_7['col2'];?></td>
              <td><?php echo $a_player_7['col3'];?></td>
              <td><?php echo $a_player_7['col9'];?></td><td><?php echo $a_player_7['col8'];?></td>
              <td><?php echo $a_player_7['era'];?></td>
              <td class="border"><?php echo $a_player_7['whip'];?></td>
              <td><?php echo $a_player_7['tol_p'];?></td>
              <td><?php echo $a_player_7['avg_p'];?></td>
          </tr>
          
          <tr class="even">
            <td class="tleft border">15天</td>
            
            <td><?php echo $a_player_15['g'];?></td>
              <td><?php echo $a_player_15['col4'].".".$a_player_15['col5'];?></td>
              <td><?php echo $a_player_15['col1'];?></td>
              <td><?php echo $a_player_15['col2'];?></td>
              <td><?php echo $a_player_15['col3'];?></td>
              <td><?php echo $a_player_15['col9'];?></td><td><?php echo $a_player_15['col8'];?></td>
              <td><?php echo $a_player_15['era'];?></td>
              <td class="border"><?php echo $a_player_15['whip'];?></td>
              <td><?php echo $a_player_15['tol_p'];?></td>
              <td><?php echo $a_player_15['avg_p'];?></td>
              </tr>
                  
                  <tr class="odd">
                  <td class="tleft border">30天</td>
                  
                  <td><?php echo $a_player_30['g'];?></td>
              <td><?php echo $a_player_30['col4'].".".$a_player_30['col5'];?></td>
              <td><?php echo $a_player_30['col1'];?></td>
              <td><?php echo $a_player_30['col2'];?></td>
              <td><?php echo $a_player_30['col3'];?></td>
              <td><?php echo $a_player_30['col9'];?></td><td><?php echo $a_player_30['col8'];?></td>
              <td><?php echo $a_player_30['era'];?></td>
              <td class="border"><?php echo $a_player_30['whip'];?></td>
              <td><?php echo $a_player_30['tol_p'];?></td>
              <td><?php echo $a_player_30['avg_p'];?></td>
              </tr>
    </table>    
    <?php
	}
	else
	{
		//野手
	?>
        <table class="tright data w100 v12" style="border-bottom: 3px solid #DDD">
        <tr class="neutral">
            <th class="tleft border">&nbsp;</th>
    
            <th>GP</th>
            <th>AB</th>
            <th>R</th>
            <th>HR</th>

            <th>RBI</th>
            <th>SB</th>
            <th>AVG</th>
            <th>OBP</th>
            <th>SLG</th>
            <th class="border">OPS</th>        
                       
            <th>TSNP</th>

            <th class="border">/G</th>
    	    <!-- <th>Price &Delta;</th> -->
        </tr>
            <tr class="odd"><td class="tleft border">本季</td>
            <td><?php echo $a_player_365['g'];?></td>
            <td><?php echo $a_player_365['col1'];?></td>
            <td><?php echo $a_player_365['col2'];?></td>
            <td><?php echo $a_player_365['col6'];?></td>
            <td><?php echo $a_player_365['col7'];?></td>
            <td><?php echo $a_player_365['col8'];?></td>
            <td><?php echo $a_player_365['avg'];?></td>
            <td>&nbsp;</td>
            <td><?php echo $a_player_365['slg'];?></td>
            <td class="border"></td><td><?php echo $a_player_365['tol_p'];?></td>
            <td><?php echo $a_player_365['avg_p'];?></td>
            </tr>
            <tr class="even"><td class="tleft border">昨天</td>
             <td><?php echo $a_player_1['g'];?></td>
            <td><?php echo $a_player_1['col1'];?></td>
            <td><?php echo $a_player_1['col2'];?></td>
            <td><?php echo $a_player_1['col6'];?></td>
            <td><?php echo $a_player_1['col7'];?></td>
            <td><?php echo $a_player_1['col8'];?></td>
            <td><?php echo $a_player_1['avg'];?></td>
            <td>&nbsp;</td>
            <td><?php echo $a_player_1['slg'];?></td>
            <td class="border"></td><td><?php echo $a_player_1['tol_p'];?></td>
            <td><?php echo $a_player_1['avg_p'];?></td>
            </tr>
          <tr class="odd"><td class="tleft border">7天</td>
             <td><?php echo $a_player_7['g'];?></td>
            <td><?php echo $a_player_7['col1'];?></td>
            <td><?php echo $a_player_7['col2'];?></td>
            <td><?php echo $a_player_7['col6'];?></td>
            <td><?php echo $a_player_7['col7'];?></td>
            <td><?php echo $a_player_7['col8'];?></td>
            <td><?php echo $a_player_7['avg'];?></td>
            <td>&nbsp;</td>
            <td><?php echo $a_player_7['slg'];?></td>
            <td class="border"></td><td><?php echo $a_player_7['tol_p'];?></td>
            <td><?php echo $a_player_7['avg_p'];?></td>
          </tr>
          <tr class="even"><td class="tleft border">15天</td> 
            <td><?php echo $a_player_15['g'];?></td>
            <td><?php echo $a_player_15['col1'];?></td>
            <td><?php echo $a_player_15['col2'];?></td>
            <td><?php echo $a_player_15['col6'];?></td>
            <td><?php echo $a_player_15['col7'];?></td>
            <td><?php echo $a_player_15['col8'];?></td>
            <td><?php echo $a_player_15['avg'];?></td>
            <td>&nbsp;</td>
            <td><?php echo $a_player_15['slg'];?></td>
            <td class="border"></td><td><?php echo $a_player_15['tol_p'];?></td>
            <td><?php echo $a_player_15['avg_p'];?></td>
            </tr>
            <tr class="odd"><td class="tleft border">30天</td>
             <td><?php echo $a_player_30['g'];?></td>
            <td><?php echo $a_player_30['col1'];?></td>
            <td><?php echo $a_player_30['col2'];?></td>
            <td><?php echo $a_player_30['col6'];?></td>
            <td><?php echo $a_player_30['col7'];?></td>
            <td><?php echo $a_player_30['col8'];?></td>
            <td><?php echo $a_player_30['avg'];?></td>
            <td>&nbsp;</td>
            <td><?php echo $a_player_30['slg'];?></td>
            <td class="border"></td><td><?php echo $a_player_30['tol_p'];?></td>
            <td><?php echo $a_player_30['avg_p'];?></td>
            </tr>

    </table>   
    
    <?php } ?>
    
<br />
    <table class="tableTitle v12">
    	<tr>
    <td class="title">最近5日明細</td>
            <td class="titleLink"><a href='res_playerdata.php?view=2&playerid=<?php echo $playerid;?>'>觀看所有</a></td>
    	</tr>
    </table>
	<?php
	if($a_player_base['p'])
	{
	?>
    <table class="tright data w100 v12" style="border-bottom: 3px solid #DDD">
        <tr class="neutral">
            <th class="tleft border">Date</th>
    
            <th>IP</th>
            <th>W</th>
            <th>L</th>
            <th>Sv</th>

            <th>K</th>
            <th>TBBs</th>
            <th>ER</th>
            <th class="border">H</th>
                       
            <th>積分</th>
            <th class="border">價錢</th>

    	    <!-- <th>Price &Delta;</th> -->
        </tr>
            <?php
        for($i=0;$i<5;$i++)
		{
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
			}?>
            <td class="tleft border"><?php echo substr($a_player_log['datetime'][$i],5,5);?></td><td><?php echo $a_player_log['col4'][$i].".".$a_player_log['col5'][$i];?></td>
      <td><?php echo $a_player_log['col1'][$i];?></td>
      <td><?php echo $a_player_log['col2'][$i];?></td>
      <td><?php echo $a_player_log['col3'][$i];?></td>
      <td><?php echo $a_player_log['col9'][$i];?></td>
      <td><?php echo $a_player_log['col8'][$i];?></td>
      <td><?php echo $a_player_log['col11'][$i];?></td>
      <td><?php echo $a_player_log['col6'][$i];?></td>
      <td><?php echo $a_player_log['point'][$i];?></td>
      <td class="border"><?php echo ShowPrice1($a_player_log['price'][$i]);?></td>
      </tr>
      <?php
	  }
	  ?>

    </table>  
    <?php 
	}
	else
	{
	?>
        <table class="tright data w100 v12" style="border-bottom: 3px solid #DDD">
        <tr class="neutral">
            <th class="tleft border">Date</th>
    
            <th>AB</th>
	    <th>H</th>
            <th>R</th>
            <th>HR</th>

            <th>RBI</th>
            <th>SB</th>
            <th>K</th>
	    <th class="border">TBBs</th>
                       
            <th>積分</th>
            <th class="border">價錢</th>

    	    <!-- <th>Price &Delta;</th> -->
        </tr>
        <?php
        for($i=0;$i<5;$i++)
		{
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
            <td class="tleft border"><?php echo substr($a_player_log['datetime'][$i],5,5);?></td>
            <td><?php echo $a_player_log['col1'][$i];?></td>
            <td><?php echo $a_player_log['col3'][$i];?></td>
            <td><?php echo $a_player_log['col2'][$i];?></td>
            <td><?php echo $a_player_log['col6'][$i];?></td>
            <td><?php echo $a_player_log['col7'][$i];?></td>
            <td><?php echo $a_player_log['col8'][$i];?></td>
            <td><?php echo $a_player_log['col10'][$i];?></td>
            <td><?php echo $a_player_log['col9'][$i];?></td>
            <td><?php echo $a_player_log['point'][$i];?></td>
            <td class="border"><?php echo ShowPrice1($a_player_log['price'][$i]);?></td>
            </tr>
            <?php
		}
		?>
    </table>
    <?php
	}
	?>  
<br />    
    <table class="tableTitle v12">
    	<tr>
            <td class="title">年度紀錄</td>
            <td class="titleLink">&nbsp;</td>
   	  </tr>
    </table>
    <?php
	if($a_player_base['p'])
	{
	?>
    <table class="tright data w100 v12" style="border-bottom: 3px solid #DDD">

        <tr>
            <th class="tleft">&nbsp;</th>
            <th>G</th>
            <th>IP</th>
            <th>W</th>

            <th>L</th>
            <th>Sv</th>
            <th>K</th>
            <th>TBBs</th>
            <th>ERA</th>
            <th class="border">WHIP</th>  
          
            <th>TSNP</th>

            <th>/G</th>
        </tr>
            <tr class="odd">
              <td class="tleft">2007</td><td><?php echo $a_player_2007['g'];?></td>
            <td><?php echo $a_player_2007['col4'].".".$a_player_2007['col5'];?></td><td><?php echo $a_player_2007['col1'];?></td><td><?php echo $a_player_2007['col2'];?></td><td><?php echo $a_player_2007['col3'];?></td><td><?php echo $a_player_2007['col9'];?></td><td><?php echo $a_player_2007['col8'];?></td><td><?php echo $a_player_2007['era'];?></td><td class="border"><?php echo $a_player_2007['whip'];?></td><td><?php echo $a_player_2007['tol_p'];?></td><td><?php echo $a_player_2007['avg_p'];?></td>
            </tr>
            
            <tr class="even">
              <td class="tleft">2006</td><td><?php echo $a_player_2006['g'];?></td>
            <td><?php echo $a_player_2006['col4'].".".$a_player_2006['col5'];?></td><td><?php echo $a_player_2006['col1'];?></td><td><?php echo $a_player_2006['col2'];?></td><td><?php echo $a_player_2006['col3'];?></td><td><?php echo $a_player_2006['col9'];?></td><td><?php echo $a_player_2006['col8'];?></td><td><?php echo $a_player_2006['era'];?></td><td class="border"><?php echo $a_player_2006['whip'];?></td><td><?php echo $a_player_2006['tol_p'];?></td><td><?php echo $a_player_2006['avg_p'];?></td></tr>
    </table>
    
<?php
	}
	else
	{
	?>
    <table class="tright data w100 v12" style="border-bottom: 3px solid #DDD">

        <tr>
            <th class="tleft">&nbsp;</th>
            <th>GP</th>
            <th>AB</th>
            <th>R</th>
            <th>HR</th>

            <th>RBI</th>
            <th>SB</th>
            <th>AVG</th>
            <th>OBP</th>
            <th>SLG</th>
            <th class="border">OPS</th>        
          
            <th>TSNP</th>

            <th>/G</th>
        </tr>
            <tr class="odd">
              <td class="tleft">2007</td><td><?php echo $a_player_2007['g'];?></td><td><?php echo $a_player_2007['col1'];?></td><td><?php echo $a_player_2007['col2'];?></td><td><?php echo $a_player_2007['col6'];?></td><td><?php echo $a_player_2007['col7'];?></td><td><?php echo $a_player_2007['col8'];?></td><td><?php echo $a_player_2007['avg'];?></td><td>&nbsp;</td>
                <td><?php echo $a_player_2007['slg'];?></td><td class="border">&nbsp;</td><td><?php echo $a_player_2007['tol_p'];?></td><td><?php echo $a_player_2007['avg_p'];?></td>
                </tr><tr class="even">
                <td class="tleft">2006</td><td><?php echo $a_player_2006['g'];?></td><td><?php echo $a_player_2006['col1'];?></td><td><?php echo $a_player_2006['col2'];?></td><td><?php echo $a_player_2006['col6'];?></td><td><?php echo $a_player_2006['col7'];?></td><td><?php echo $a_player_2006['col8'];?></td><td><?php echo $a_player_2006['avg'];?></td><td>&nbsp;</td>
                <td><?php echo $a_player_2006['slg'];?></td><td class="border">&nbsp;</td><td><?php echo $a_player_2006['tol_p'];?></td><td><?php echo $a_player_2006['avg_p'];?></td></tr>
    </table>
  <?php
	}
	?>
    
<br />
    
        
        
    <br class="cboth" />
    
</div>
<?php
}
else
{
	//投手
    if($a_player_base['p'])
	{
		?>
		<table class="infotable tright">
		<tr>
			<th class="heading_group tleft" colspan="19">Game Log</th>
		</tr>
		<tr>
			<th align="left">&nbsp;</th>
			<th>IP</th>
			<th>W</th>
	
			<th>L</th>
			<th>S</th>
			<th>K</th>
			<th>H</th>
			<th>TBBs</th>
			<th>ER</th>
	
			<th>ERA</th>
			<th>WHIP</th>
			<th>TSNP</th>
			<th>Price</th>
		</tr>
		<tr align="right">
        <?php
	if($logcount)
	{
		for($i=0;$i<$logcount;$i++)
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
			<td class="tleft"><?php echo substr($a_player_log['datetime'][$i],5,5);?></td>
			<td class="tleft"><?php echo $a_player_log['col4'][$i].".".$a_player_log['col5'][$i];?></td><td class=""><?php echo $a_player_log['col1'][$i];?></td>
			<td class=""><?php echo $a_player_log['col2'][$i];?></td>
			<td class=""><?php echo $a_player_log['col3'][$i];?></td>
			<td class=""><?php echo $a_player_log['col9'][$i];?></td><td class=""><?php echo $a_player_log['col6'][$i];?></td>
			<td class=""><?php echo $a_player_log['col8'][$i];?></td>
			<td class=""><?php echo $a_player_log['col10'][$i];?></td>
			<td class=""><?php echo $a_player_log['col11'][$i];?></td>
			<td class=""></td><td class=""><?php echo $a_player_log['point'][$i];?></td>
			<td class=""><?php echo ShowPrice1($a_player_log['price'][$i]);?></td>
			</tr><tr class="even">
	
		</tr>
        <?php
		}
		}
	?>
	</table>
    <?php
	}
	else
	{
?>
<table class="infotable tright">
	<tr>
		<th class="heading_group tleft" colspan="19">Game Log</th>
	</tr>
    <tr>
        <th>&nbsp;</th>
        <th>AB</th>
        <th>R</th>

        <th>H</th>
        <th>2B</th>
        <th>3B</th>
        <th>HR</th>
        <th>RBI</th>
        <th>TBBS</th>

        <th>SO</th>
        <th>SB</th>
        <th>CS</th>
        <th>BA</th>
        <th>SLG</th>
        <th>OBP</th>

        <th>TSNP</th>
        <th>Price</th>
    </tr>
    <tr align="right">
    <?php
	if($logcount)
	{
		for($i=0;$i<$logcount;$i++)
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
      <td class=" tleft"><?php echo substr($a_player_log['datetime'][$i],5,5);?></td>
        <td class=" tleft"><?php echo $a_player_log['col1'][$i];?></td>
      <td class=""><?php echo $a_player_log['col2'][$i];?></td>
      <td class=""><?php echo $a_player_log['col3'][$i];?></td>
        <td class=""><?php echo $a_player_log['col4'][$i];?></td>
        <td class=""><?php echo $a_player_log['col5'][$i];?>        </td>
      <td class=""><?php echo $a_player_log['col6'][$i];?></td>
      <td class=""><?php echo $a_player_log['col7'][$i];?></td>
      <td class=""><?php echo $a_player_log['col9'][$i];?></td>
      <td class=""><?php echo $a_player_log['col10'][$i];?></td>
        <td class=""><?php echo $a_player_log['col8'][$i];?></td>
        <td class=""></td><td class=""></td><td class=""></td><td class=""></td><td class=""><?php echo $a_player_log['point'][$i];?></td>
        <td class=""><?php echo ShowPrice1($a_player_log['price'][$i]);?></td>
    </tr>
	<?php
		}
	}
	?>
</table>

<?php
	}
}
?>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>