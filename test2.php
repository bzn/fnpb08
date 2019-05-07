<?php
echo "hi";
exit;
?>
<?php
extract($_POST);
extract($_GET);
//測試初始數據====================
$_SESSION['charid'] = 1;
$_SESSION['myteamid'] = 1;
$_SESSION['nickname'] = "布魯斯爆炸";
//last,career,log
//$tab = 'career';
//$playerid = 218;
//echo $playerid;
//==============================
//include_once(dirname(__FILE__)."/connect.php");
$a_player_base = GetPlayerBaseData($SQLObj0,$playerid);
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

if($view == 1)
{
	//取得期間成績
	$a_player_1 = GetPlayerDataByPeri($SQLObj0,$playerid,1);
	$a_player_7 = GetPlayerDataByPeri($SQLObj0,$playerid,7);
	$a_player_15 = GetPlayerDataByPeri($SQLObj0,$playerid,15);
	$a_player_30 = GetPlayerDataByPeri($SQLObj0,$playerid,30);
	$a_player_365 = GetPlayerDataByPeri($SQLObj0,$playerid,365);
	$a_player_2006 = GetPlayerDataByYear($SQLObj0,$playerid,2006);
}
else if ($view == 2)
{
	$str = "SELECT * FROM player_record_log WHERE player_id = ".$playerid."";
	$SQLObj0->RunSQL($str);
	$logcount = $SQLObj0->LinkAll();
	//echo $logcount;
	if($logcount)
	{
			$a_player_log['datetime'] = $SQLObj0->GetData('DATETIME');
			$a_player_log['g'] = $SQLObj0->GetData('G');
			for($j=1;$j<12;$j++)
				$a_player_log['col'.$j] = $SQLObj0->GetData('COL'.$j);
	} 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fantasy NPB!!</title>
</head>

<body>
<style type="text/css">
<!--
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
<table width="768" border="0" align="center">
  <tr>
    <td colspan="5" class="style18"><span class="style20"><?echo $a_player_base['name_2']." ".$a_player_base['no'];?></span><?echo"( ".$posstr." - ".$a_player_base['teamname']." )";?></td>
    <td class="style18"><div align="right">賣出 $30.00M</div></td>
  </tr>
</table>
<table width="768" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td colspan="3" bgcolor="#9DACBF" class="style18"><span class="style17">球員資訊</span></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><img src="images/teamicon/<?echo $a_player_base['teamid'];?>.gif" width="82" height="82" /></td>
    <td valign="top" bgcolor="#CCCCCC" class="style18"><?echo substr($a_player_base['birth'],0,4)."年";?> <br />
        <?echo intval(substr($a_player_base['birth'],5,2))."月".intval(substr($a_player_base['birth'],8,2))."日生";?> <br />
        <br />
        <?if($a_player_base['pitch']==='R') echo "右"; elseif($a_player_base['pitch']==='L') echo "左"; else echo "兩";?>
      投
      <?if($a_player_base['bat']==='R') echo "右"; elseif($a_player_base['pitch']==='L') echo "左"; else echo "兩";?>
      打</td>
    <td align="center" valign="middle" bgcolor="#FFFFFF" class="style18"><table width="570" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
      <tbody>
        <tr>
          <th width="80" bgcolor="#E5E5E5" class="style18">Sun, 1/28</th>
          <th width="80" bgcolor="#E5E5E5" class="style18">Mon, 1/29</th>
          <th width="80" bgcolor="#E5E5E5" class="style18">Tue, 1/30</th>
          <th width="80" bgcolor="#E5E5E5" class="style18">Wed, 1/31</th>
          <th width="80" bgcolor="#E5E5E5" class="style18">Thu, 2/1</th>
          <th width="80" bgcolor="#E5E5E5" class="style18">Fri, 2/2</th>
          <th width="80" bgcolor="#E5E5E5" class="style18">Sat, 2/3</th>
        </tr>
        <tr>
          <td bgcolor="#FFFFFF" class="style18"> 
            <div align="center"></div></td>
          <td bgcolor="#FFFFFF" class="style18"><div>
            <div align="center"><a href="team_page.html?team_id=26">@   UTA</a><br />
              (29-15)</div>
          </div></td>
          <td bgcolor="#FFFFFF" class="style18"> 
            <div align="center"></div></td>
          <td bgcolor="#FFFFFF" class="style18"><div>
            <div align="center"><a href="team_page.html?team_id=8">DET</a><br />
              (24-17)</div>
          </div></td>
          <td bgcolor="#FFFFFF" class="style18"> 
            <div align="center"></div></td>
          <td bgcolor="#FFFFFF" class="style18"><div>
            <div align="center"><a href="team_page.html?team_id=19">@   ORL</a><br />
              (23-21)</div>
          </div></td>
          <td bgcolor="#FFFFFF" class="style18"> 
            <div align="center"></div></td>
        </tr>
      </tbody>
    </table></td>
  </tr>
</table>
<span class="style18"><br />
</span>
<table width="770" border="0" align="center">
  <tr>
    <td><span class="style18">| <a href="res_playerdata.php?view=1&amp;playerid=<?echo $playerid;?>">統計數據</a> | <a href="res_playerdata.php?view=2&amp;playerid=<?echo $playerid;?>">本季明細</a> | </span></td>
  </tr>
</table>
<?php
//投手表格
if($a_player_base['p'])
{
	if($view == 1)
	{
	?>
<table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td colspan="18" bgcolor="#9DACBF" class="style18 style17">紀錄</td>
  </tr>
  <tr>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right"></div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">試合</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">勝</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">敗</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">救援</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">局數</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">被安</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">被本</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">四死</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三振</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">WHIP</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">失分</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">責失分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">防率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">昨日</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">績分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">平均</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">漲跌</div>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">本季</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col4'].".".$a_player_365['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['whip'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col11'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['era'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">昨天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col4'].".".$a_player_1['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['whip'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col11'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['era'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">7天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col4'].".".$a_player_7['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['whip'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col11'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['era'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">15天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col4'].".".$a_player_15['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['whip'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col11'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['era'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">30天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col4'].".".$a_player_30['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['whip'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col11'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['era'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['pricemove'];?></div></td>
  </tr>
</table>
<br />
<table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td colspan="16" bgcolor="#9DACBF" class="style18 style17">生涯紀錄</td>
  </tr>
  <tr>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right"></div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">試合</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">勝</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">敗</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">救援</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">局數</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">被安</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">被本</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">四死</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三振</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">WHIP</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">失分</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">責失分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">防率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">積分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">平均</div>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">2006</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['g'];?> </div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col4'].".".$a_player_2006['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['whip'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col11'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['era'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['avg_p'];?></div></td>
  </tr>
</table>
<?php
	}
	else if($view == 2)
	{
	?>
<table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td colspan="17" bgcolor="#9DACBF" class="style18 style17">紀錄</td>
  </tr>
  <tr>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right"></div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">對手</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">比數</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">勝</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">敗</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">救援</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">局數</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">被安</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">被本</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">四死</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三振</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">WHIP</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">失分</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">責失分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">防率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">積分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">價錢</div></td>
  </tr>
  <?php
if($logcount)
{
	for($i=0;$i<$logcount;$i++)
	{
?>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo substr($a_player_log['datetime'][$i],0,10);?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col1'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col2'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col3'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col4'][$i].".".$a_player_log[$i]['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col6'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col7'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col8'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col9'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col10'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">100</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">60</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">3.37</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">160</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">0.12M</div>
        <div align="right"></div></td>
  </tr>
  <?php
	}
}
?>
</table>
<?php
	}
}
else 
{
	//野手表格
	if($view == 1)
	{
	?>
<table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td colspan="18" bgcolor="#9DACBF" class="style18 style17">紀錄</td>
  </tr>
  <tr>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right"></div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">試合</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打數</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">得分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">安打</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">二壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">本壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打點</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">盜壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">四死</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三振</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">長打率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打擊率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">昨日</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">績分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">平均</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">漲跌</div>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">本季</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col4'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_365['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['slg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['avg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">昨天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col4'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['slg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['avg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_1['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">7天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col4'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['slg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['avg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_7['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">15天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col4'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['slg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['avg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_15['pricemove'];?></div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">30天</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col4'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['slg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['avg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['yes_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['avg_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_30['pricemove'];?></div></td>
  </tr>
</table>
<br />
<table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td colspan="16" bgcolor="#9DACBF" class="style18 style17">生涯紀錄</td>
  </tr>
  <tr>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right"></div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">試合</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打數</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">得分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">安打</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">二壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">本壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打點</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">盜壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">四死</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三振</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">長打率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打擊率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">積分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">平均</div>
    </div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">2006</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['g'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col1'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col2'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col3'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col4'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col5'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col6'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col7'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col8'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col9'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['col10'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['slg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['avg'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['tol_p'];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_2006['avg_p'];?></div></td>
  </tr>
</table>
<?php
	}
	else if($view == 2)
	{
	?>
<table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td colspan="17" bgcolor="#9DACBF" class="style18 style17">紀錄</td>
  </tr>
  <tr>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right"></div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">對手</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">比數</div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打數</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">得分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">安打</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">二壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">本壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打點</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">盜壘</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">四死</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">三振</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">長打率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">打擊率</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">
      <div align="right">積分</div>
    </div></td>
    <td bgcolor="#E5E5E5" class="style18"><div align="right">價錢</div></td>
  </tr>
  <?php
if($logcount)
{
	for($i=0;$i<$logcount;$i++)
	{
?>
  <tr>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo substr($a_player_log['datetime'][$i],0,10);?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col1'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col2'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col3'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col4'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col5'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col6'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col7'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col8'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col9'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right"><?echo $a_player_log['col10'][$i];?></div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">60</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">3.37</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">160</div></td>
    <td bgcolor="#FFFFFF" class="style18"><div align="right">0.12M</div>
        <div align="right"></div></td>
  </tr>
  <? 
	}
}
?>
</table>
<?php
	}
}
?>
<span class="style18"><br />
</span><span class="style18"><br />
</span>
</body>
</html>
