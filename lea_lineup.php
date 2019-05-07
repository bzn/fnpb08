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

//2007年資料
$view = 2;

//取得昨日的roster
$str = "SELECT * FROM myteam_score_log WHERE teamid='".$teamid."' ORDER BY `datetime` DESC";
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
			$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],365);
		elseif ($view == 2)
			$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],1);	
		elseif ($view == 3)
			$a_player[$i] = GetPlayerDataByYear($SQLObj0,$a_player[$i]['id'],2006);	
		
		//3/24
		//$a_player[$i] = GetPlayerDataByPeri($SQLObj0,$a_player[$i]['id'],365);
		//如果這個位置沒有選手
		if(!$a_player[$i]['id'])
		{
			//顯示購買標籤
			//$a_player_base[$i]['name_2'] = "<a href='res_team.php?teamid=1'>購買</a>";
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
			$a_player[$i]['price'] = $a_player[$i]['price'];
		}
	}
	$money += $cash;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fantasy NPB!!</title>
<LINK href="css/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:visited {color: #0000CC;}
a:link {color: #0000CC;}
a{text-decoration:none ; } 
a:hover {text-decoration:underline ; }

.style17 {color: #FFFFFF}
.style18 {font-size: 12px}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
.style20 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<div id="container">
<form id="form1" name="form1" method="post" action="">
<input type="hidden" name="action" value="1">
  <table width="770" border="0" align="center">
    <tr>
      <td><?php
include(dirname(__FILE__)."/include/head.inc.php");
?></td>
    </tr>
  </table>
  <br />
<table width="768" border="0" align="center">
  <tr>
    <td><span class="style20"><?php echo $myteamname;?></span></td>
  </tr>
</table>
<table width="768" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#<?php echo COLOR2;?>">
  <tr>
    <td bgcolor="#<?php echo COLOR2;?>"><span class="style17">隊伍資訊</span></td>
  </tr>
</table>
<table width="768" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#<?php echo COLOR3;?>">
    <tr>
      <td colspan="6"></td>
    </tr>
    
    <tr>
      <td width="60" bgcolor="#<?php echo COLOR3;?>">玩家名稱</td>
      <td width="190" bgcolor="#<?php echo COLOR3;?>"><?php echo $_SESSION['nickname'];?></td>
      <td width="62" bgcolor="#<?php echo COLOR3;?>">球隊總價值</td>
      <td width="199" bgcolor="#<?php echo COLOR3;?>">$ <?php echo $money;?></td>
      <td width="82" bgcolor="#<?php echo COLOR3;?>">世界積分排名</td>
      <td width="149" bgcolor="#<?php echo COLOR3;?>"></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>">投手剩餘交易次數</td>
      <td bgcolor="#<?php echo COLOR3;?>"><?php echo $trade_1;?></td>
      <td bgcolor="#<?php echo COLOR3;?>">剩下現金</td>
      <td bgcolor="#<?php echo COLOR3;?>">$<?php echo $cash;?></td>
      <td bgcolor="#<?php echo COLOR3;?>">聯盟積分排名</td>
      <td bgcolor="#<?php echo COLOR3;?>"></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>">打者剩餘交易次數</td>
      <td bgcolor="#<?php echo COLOR3;?>"><?php echo $trade_2;?></td>
      <td bgcolor="#<?php echo COLOR3;?>">昨日積分</td>
      <td bgcolor="#<?php echo COLOR3;?>"></td>
      <td bgcolor="#<?php echo COLOR3;?>">世界金錢排名</td>
      <td bgcolor="#<?php echo COLOR3;?>"></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>">&nbsp;</td>
      <td bgcolor="#<?php echo COLOR3;?>">&nbsp;</td>
      <td bgcolor="#<?php echo COLOR3;?>">總積分</td>
      <td bgcolor="#<?php echo COLOR3;?>"></td>
      <td bgcolor="#<?php echo COLOR3;?>">聯盟金錢排名</td>
      <td bgcolor="#<?php echo COLOR3;?>">&nbsp;</td>
    </tr>
  </table>
  <br />
  <?php 
 if(IsRosterFull($SQLObj0,$_SESSION['myteam_id']))
 {
 	?>
 	每個守備位置都必須要有球員,系統才會開始計分
 	<?php
 }
 ?>
  <br />
  <table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
      <td colspan="21" bgcolor="#FFFFFF">| 2007年 |</td>
    </tr>
    <tr>
      <td colspan="4" bgcolor="#000000"><span class="style17">選手資訊</span></td>
      <td colspan="12" bgcolor="#000000"><span class="style17">紀錄</span></td>
      <td colspan="3" bgcolor="#000000"><span class="style17">積分</span></td>
      <td colspan="2" bgcolor="#000000"><span class="style17">價錢</span></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">選手名</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">下次對手</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">登板</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">勝</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">敗</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">救援</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">局數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">被安</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">被本</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">責失</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">WHIP</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">防率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="center">P</div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[0]['name_2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[0]['teamid'];?>"><?php echo $a_player_base[0]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[0]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['g'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col4'].".".$a_player[0]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['col11'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['whip'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['era'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[0]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="center">P</div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[1]['id'];?>"><?php echo $a_player_base[1]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[1]['teamid'];?>"><?php echo $a_player_base[1]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[1]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['g'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col4'].".".$a_player[1]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['col11'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['whip'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['era'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[1]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="center">P</div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[2]['id'];?>"><?php echo $a_player_base[2]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[2]['teamid'];?>"><?php echo $a_player_base[2]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[2]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['g'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col4'].".".$a_player[2]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['col11'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['whip'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['era'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[2]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="center">P</div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[3]['id'];?>"><?php echo $a_player_base[3]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[3]['teamid'];?>"><?php echo $a_player_base[3]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[3]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['g'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col4'].".".$a_player[3]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['col11'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['whip'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['era'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[3]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><div align="center">P</div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[4]['id'];?>"><?php echo $a_player_base[4]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[4]['teamid'];?>"><?php echo $a_player_base[4]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[4]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['g'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col4'].".".$a_player[4]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['col11'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['whip'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['era'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[4]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">捕手</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center"></div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">打數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">得分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">安打</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">二壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">三壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">本壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">打點</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">盜壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">長打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
        <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">
        <label> </label>
        <label></label>
        <label></label>
        <label></label>
        <label></label>
        <label></label>
        <label></label>
        <label></label>
        <label></label>
        <label></label>
        
          <div align="center">
            <select name="select0" id="select0">
              <?php 
          if($a_player_base[5]['c']) echo "<option selected value='5'>C</option>";
          if($a_player_base[5]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[5]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[5]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[5]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[5]['of']) echo "<option value='10'>OF</option>";
		  if($a_player_base[5]['dh']) echo "<option value='13'>DH</option>";
          ?>
            </select>
          </div>          <label>        </label>        </td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[5]['id'];?>"><?php echo $a_player_base[5]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[5]['teamid'];?>"><?php echo $a_player_base[5]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[5]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[5]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">一壘</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center"></div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">得分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">安打</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">二壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">本壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打點</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">盜壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">長打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF">
          
            <div align="center">
                <select name="select1" id="select1">
                  <?php 
          if($a_player_base[6]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[6]['1b']) echo "<option selected value='6'>1B</option>";
          if($a_player_base[6]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[6]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[6]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[6]['of']) echo "<option value='10'>OF</option>";
		  if($a_player_base[6]['dh']) echo "<option value='13'>DH</option>";
          ?>         
                </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[6]['id'];?>"><?php echo $a_player_base[6]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[6]['teamid'];?>"><?php echo $a_player_base[6]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[6]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[6]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">二壘</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center"></div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">得分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">安打</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">二壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">本壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打點</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">盜壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">長打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
          
          <div align="center">
              <select name="select2" id="select2">
                <?php 
          if($a_player_base[7]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[7]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[7]['2b']) echo "<option selected value='7'>2B</option>";
          if($a_player_base[7]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[7]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[7]['of']) echo "<option value='10'>OF</option>";
		  if($a_player_base[7]['dh']) echo "<option value='13'>DH</option>";
          ?>
              </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[7]['id'];?>"><?php echo $a_player_base[7]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[7]['teamid'];?>"><?php echo $a_player_base[7]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[7]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[7]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">游擊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center"></div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">得分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">安打</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">二壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">本壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打點</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">盜壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">長打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
          
          <div align="center">
              <select name="select3" id="select3">
                <?php 
          if($a_player_base[8]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[8]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[8]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[8]['ss']) echo "<option selected value='8'>SS</option>";
          if($a_player_base[8]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[8]['of']) echo "<option value='10'>OF</option>";
		  if($a_player_base[8]['dh']) echo "<option value='13'>DH</option>";
          ?>
              </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[8]['id'];?>"><?php echo $a_player_base[8]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[8]['teamid'];?>"><?php echo $a_player_base[8]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[8]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[8]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">三壘</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center"></div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">得分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">安打</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">二壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">本壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打點</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">盜壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">長打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
          
          <div align="center">
              <select name="select4" id="select4">
                <?php 
          if($a_player_base[9]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[9]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[9]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[9]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[9]['3b']) echo "<option selected value='9'>3B</option>";
          if($a_player_base[9]['of']) echo "<option value='10'>OF</option>";
		  if($a_player_base[9]['dh']) echo "<option value='13'>DH</option>";
          ?>
              </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[9]['id'];?>"><?php echo $a_player_base[9]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[9]['teamid'];?>"><?php echo $a_player_base[9]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[9]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[9]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">外野</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center"></div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">得分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">安打</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">二壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">本壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打點</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">盜壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">長打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
          
          <div align="center">
              <select name="select5" id="select5">
                <?php 
          if($a_player_base[10]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[10]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[10]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[10]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[10]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[10]['of']) echo "<option selected value='10'>OF</option>";
		  if($a_player_base[10]['dh']) echo "<option value='13'>DH</option>";
          ?>
              </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[10]['id'];?>"><?php echo $a_player_base[10]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[10]['teamid'];?>"><?php echo $a_player_base[10]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[10]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[10]['price'];?></div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
          
          <div align="center">
              <select name="select6" id="select6">
                <?php 
          if($a_player_base[11]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[11]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[11]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[11]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[11]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[11]['of']) echo "<option selected value='10'>OF</option>";
		  if($a_player_base[11]['dh']) echo "<option value='13'>DH</option>";
          ?>
              </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[11]['id'];?>"><?php echo $a_player_base[11]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[11]['teamid'];?>"><?php echo $a_player_base[11]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[11]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[11]['price'];?></div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
          
          <div align="center">
              <select name="select7" id="select7">
                <?php 
          if($a_player_base[12]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[12]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[12]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[12]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[12]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[12]['of']) echo "<option selected value='10'>OF</option>";
		  if($a_player_base[12]['dh']) echo "<option value='13'>DH</option>";
          ?>
              </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player[12]['id'];?>"><?php echo $a_player_base[12]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[12]['teamid'];?>"><?php echo $a_player_base[12]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[12]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[12]['price'];?></div></td>
    </tr>
    <tr>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">位置</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">DH</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center">球隊</div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="center"></div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打數</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">得分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">安打</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">二壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">本壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打點</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">盜壘</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">四死</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">三振</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">長打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">打率</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">昨日</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">總分</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">平均</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">漲跌</div>
      </div></td>
      <td bgcolor="#<?php echo COLOR3;?>"><div align="right">
          <div align="right">賣出</div>
      </div></td>
    </tr>
    <tr>
      <td align="center" bgcolor="#FFFFFF">
          
          <div align="center">
              <select name="select8" id="select8">
                <?php 
          if($a_player_base[13]['c']) echo "<option value='5'>C</option>";
          if($a_player_base[13]['1b']) echo "<option value='6'>1B</option>";
          if($a_player_base[13]['2b']) echo "<option value='7'>2B</option>";
          if($a_player_base[13]['ss']) echo "<option value='8'>SS</option>";
          if($a_player_base[13]['3b']) echo "<option value='9'>3B</option>";
          if($a_player_base[13]['of']) echo "<option value='10'>OF</option>";
		  if($a_player_base[13]['dh']) echo "<option selected value='13'>DH</option>";
          ?>
              </select>
          </div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_playerdata.php?view=1&view=1&playerid=<?php echo $a_player[13]['id'];?>"><?php echo $a_player_base[13]['name_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><a href="res_team.php?teamid=<?php echo $a_player_base[13]['teamid'];?>"><?php echo $a_player_base[13]['teamname_2'];?></a></div></td>
      <td bgcolor="#FFFFFF"><div align="center"><?php echo $a_player_base[13]['schedule'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col1'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col2'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col3'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col4'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col5'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col6'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col7'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col8'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col9'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['col10'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['slg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['avg'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['yes_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['tol_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['avg_p'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['pricemove'];?></div></td>
      <td bgcolor="#FFFFFF"><div align="right"><?php echo $a_player[13]['price'];?></div></td>
    </tr>
    <tr>
      <td colspan="21" align="center" bgcolor="#FFFFFF"><label>
        <div align="left">
          <input type="submit" name="Submit" value="交換守備位置">
          </div>
      </label></td>
    </tr>
  </table>
</form>
<br />
</div>
</body>
</html>
