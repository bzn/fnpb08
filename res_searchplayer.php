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
if(empty($_POST['view'])) $_POST['view'] = 1;
//取得目前的現金
$str = "SELECT * FROM myteam_data WHERE id='".$_SESSION['myteamid0801']."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$cash = $SQLObj0->GetData('CASH');
}
//取得賣出球員將會得到的現金
$sellcash = 0;
//計算出可以購買球員的現金
$nowcash = $cash + $sellcash;
if($nowcash != 0)
	$nowcash = ShowPrice1($nowcash);

//守備位置的下拉選項//
$SelectPos  = '<select name="pos" size="1">
               <option value="">守備位置</option>';
foreach ($BASEDATA['POS'] as $key => $val)
{
    ($key == $_POST['pos'] ) ? $selected = 'selected' : $selected = '' ;
    $SelectPos .= '<option '.$selected.' value="'.$key.'">'.$val.'</option>';
}
$SelectPos .= '</select>';
//球隊下拉//
$ArrayTeam  = DB2Array($SQLObj0, 'team_data', 'id', 'name');
$ArrayTeam[0] = '所有球隊';
$SelectTeam = Array2Select($ArrayTeam, 'team', $_POST['team'], true);
//搜尋條件//
$tmpstr = '';
if(empty($_POST['pos'])) $pos = 'p';
else $pos = $_POST['pos'];
if(empty($_POST['orderby'])) $orderby = 'price';
else $orderby = $_POST['orderby'];
if(!empty($_POST['team']))
{
    $tmpstr .= ' AND C.id=\''.$_POST['team'].'\' ';
}
//排序//
switch ($_POST['view'])
{
    case 1 :
        $array_order = array(
            'price' => '價錢',
            'points' => '積分'
        );
	   //今年成績//
	   if(IsSeasonStart())
	   		$order_string = 'ORDER BY D.'.$orderby.' DESC';
	   	else 
	   		$order_string = 'ORDER BY A.'.$orderby.' DESC';
        break;
    case 2 :
        $array_order = array(
            'price' => '價錢'
        );
	   //2006年成績//
	   $order_string = 'ORDER BY A.price DESC';
        break;
    default :
        $array_order = array(
            'price' => '價錢',
            'points' => '積分'
        );
	   //今年成績//
	   $order_string = 'ORDER BY D.'.$orderby.' DESC';
        break;
}
//抓取所有比數，用LinkAll的話，會把資料丟入陣列。用這樣取的話就比較乾淨。//
$str = "SELECT COUNT(*) 
        FROM player_base_data AS A LEFT JOIN
        team_index AS B ON A.id=B.player_id LEFT JOIN
        team_data AS C ON B.team_id=C.id LEFT JOIN 
        player_record_".THISYEAR." D ON A.id=D.player_id 
        WHERE active=1 AND A.".$pos."=1 ".$tmpstr.$order_string;
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext()) $RowCount = $SQLObj0->GetData('COUNT(*)');

//分頁函式//
$RowsPerPage = 20;
$MyPage = new page($RowCount, $RowsPerPage);
$MyPage->GoPage($_POST['page']);

$str = "SELECT A.* 
        FROM player_base_data AS A LEFT JOIN
        team_index AS B ON A.id=B.player_id LEFT JOIN
        team_data AS C ON B.team_id=C.id LEFT JOIN 
        player_record_".THISYEAR." D ON A.id=D.player_id 
        WHERE active=1 AND A.".$pos."=1 ".$tmpstr.$order_string."
		LIMIT ".$MyPage->RowStart.",".$RowsPerPage.";";

$SQLObj0->RunSQL($str);
$playercount = $SQLObj0->LinkAll();
$a_id       = $SQLObj0->GetData('ID');
for($i = 0 ; $i < $playercount ; $i++)
{
	$a_player_base[$i] = GetPlayerBaseData($SQLObj0,$a_id[$i]);
	switch ($_POST['view'])
	{
	    case 1 :
    	   //今年成績//
    	   $a_player_365[$i]  = GetPlayerDataByPeri($SQLObj0,$a_id[$i],365);
	        break;
	    case 2 :
    	   //去年成績//
    	   $a_player_365[$i]  = GetPlayerDataByYear($SQLObj0,$a_id[$i],THISYEAR-1);
	        break;
        default :
    	   //今年成績//
    	   $a_player_365[$i]  = GetPlayerDataByPeri($SQLObj0,$a_id[$i],365);
            break;
	}
	if(!IsForzen($SQLObj0,$a_id[$i]) && !IsHave($SQLObj0,$a_id[$i]))
		$a_player_365[$i]['price'] = "<a href='trade.php?addid=".$a_player_365[$i]['id']."'>".ShowPrice2($a_player_365[$i]['price'])."</a>";
	else
		$a_player_365[$i]['price'] = ShowPrice2($a_player_365[$i]['price']);
}
//產生換頁的語法//
$MyPage->genPageHtml(3);
$pageTableUp = '
<table width="770" style="font-size:12px;" style="margin:2 0 0 0px;" align="center">
<tr>
    <td align="left">共<font color="red">'.$MyPage->TotalRows.'</font>筆</td>
    <td align="center">
    '.(($_POST['view'] == 2) ? (gmdate("Y") - 1) : '<a href="'.$_SERVER['PHP_SELF'].'?view=2">'.(gmdate("Y") - 1).'年</a>'  ).'
     | 
    '.(($_POST['view'] == 1) ? (gmdate("Y")) : '<a href="'.$_SERVER['PHP_SELF'].'?view=1">'.(gmdate("Y")).'年</a>'  ).'
    </td>
    <td align="right">
    '.$MyPage->PageSelectStr.'
    </td>
</tr>
</table>';
$pageTableDown = '
<table width="770" style="font-size:12px;" style="margin:0px;" align="center">
<tr>
    <td align="left"></td>
    <td align="right">
    '.$MyPage->PageLinkStr.'
    </td>
</tr>
</table>';
/*********************************************************************************************
HTML
*********************************************************************************************/
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
<link rel="stylesheet" href="css/fantasygames.css" type="text/css">
<link rel="stylesheet" href="css/style2007.css" type="text/css">
<link rel="stylesheet" href="css/style.css" type="text/css">	
<link rel="stylesheet" href="css/top.css" type="text/css">
<LINK href="css/css.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="/js/Page.js"></script>
<script language="javascript">
//OnMouse table change backgroundColor
function OMOver(OMO){OMO.style.backgroundColor='#<?php echo COLOR1;?>';}
function OMOut(OMO){OMO.style.backgroundColor='';}
</script>
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
<div id="container" style="OVERFLOW : auto;v-align:top;text-align:center;">
<center>
  <table width="770" border="0" align="center">
    <tr>
      <td><?php
include(dirname(__FILE__)."/include/head.inc.php");
?></td>
    </tr>
  </table>
  <table width="770" border="0" cellpadding="0" cellspacing="0" align="center">
    <tr>
      <td colspan="4" class="style18"><span class="style20"><?php echo $teamname;?></span></td>
      <td class="style18" valign="middle" align="left">
        <b>您有 $ <font color="red"><?php echo $nowcash?></font> 可以購買球員</b>
      </td>
      <td class="style18"><div align="right">
        <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
          搜尋條件
          <input type="hidden" name="action" value="1">
          <input type="hidden" name="view" value="<?php echo $_POST['view']?>">
          <label>
          隊伍：
          <?php echo $SelectTeam ?>
          守備位置：
          <?php echo $SelectPos ?>
          排序依據：
          <?php
          echo Array2Select($array_order,'orderby',$_POST['orderby']);
          ?>
          <!--
          <select name="orderby">
            <option value="price">價錢</option>
            <option value="points">積分</option>
            <option value="avg_points">平均</option>
            </select>
            //-->
            <input type="submit" name="Submit" class="class_btn" value="查詢" />
            </label>
  </table>
<?php
echo $pageTableUp;
//投手表格
if($pos === 'p')
{
	?>
  <table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="margin:0px;">
    <tr>
      <td colspan="20" bgcolor="#<?php echo COLOR2;?>" class="style18 style17">投手紀錄</td>
    </tr>
    <tr>
      <td bgcolor="#E5E5E5" class="style18"><div align="left">選手</div></td>
      <td bgcolor="#E5E5E5" class="style18">球隊</td>
      <td bgcolor="#E5E5E5" class="style18">位置</td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">G</div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">W</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">L</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">S</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">IP</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">H</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">HR</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">TBBS</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">K</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">WHIP</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">R</div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">ER</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">ERA</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">最新</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">總分</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">平均</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">價錢</div>
      </div></td>
    </tr>
    <?php
	for($i=0;$i<$playercount;$i++)
	{
	?>
	    <tr bgcolor="#FFFFFF" onMouseOver="OMOver(this);" onMouseOut="OMOut(this);">
	      <td class="style18"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player_365[$i]['id'];?>"><?php echo $a_player_base[$i]['name_2'];?></a></td>
	      <td class="style18"><a href="res_team.php?teamid=<?php echo $a_player_base[$i]['teamid'];?>"><?php echo $a_player_base[$i]['teamname_2'];?></a></td>
	      <td class="style18"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player_365[$i]['id'];?>"><?php echo $a_player_base[$i]['posstr'];?></a></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['g'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col1'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col2'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col3'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col4'].".".$a_player_365[$i]['col5'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col6'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col7'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col8'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col9'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['whip'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col10'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col11'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['era'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['yes_p'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['tol_p'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['avg_p'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['price'];?></div></td>
	    </tr>
	    <?php
	
	}
}
else if(!$err)
{
?>
  </table>
 
  <table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
      <td colspan="20" bgcolor="#<?php echo COLOR2;?>" class="style18 style17">野手紀錄</td>
    </tr>
    <tr>
      <td bgcolor="#E5E5E5" class="style18"><div align="left">選手</div></td>
      <td bgcolor="#E5E5E5" class="style18">球隊</td>
      <td bgcolor="#E5E5E5" class="style18">位置</td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">G</div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">AB</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">R</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">H</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">2B</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">3B</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">HR</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">RBI</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">SB</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">BB</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">SO</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">SLG</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">AVG</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">最新</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">總分</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">平均</div>
      </div></td>
      <td bgcolor="#E5E5E5" class="style18"><div align="right">
        <div align="right">價錢</div>
      </div></td>
    </tr>
    <?php
	for($i=0;$i<$playercount;$i++)
	{
	?>
	    <tr bgcolor="#FFFFFF" onMouseOver="OMOver(this);" onMouseOut="OMOut(this);">
	      <td class="style18"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player_365[$i]['id'];?>"><?php echo $a_player_base[$i]['name_2'];?></a></td>
	      <td class="style18"><a href="res_team.php?teamid=<?php echo $a_player_base[$i]['teamid'];?>"><?php echo $a_player_base[$i]['teamname_2'];?></a></td>
	      <td class="style18"><a href="res_playerdata.php?view=1&playerid=<?php echo $a_player_365[$i]['id'];?>"><?php echo $a_player_base[$i]['posstr'];?></a></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['g'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col1'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col2'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col3'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col4'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col5'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col6'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col7'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col8'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col9'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['col10'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['slg'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['avg'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['yes_p'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['tol_p'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['avg_p'];?></div></td>
	      <td class="style18"><div align="right"><?php echo $a_player_365[$i]['price'];?></div></td>
	    </tr>
	    <?php
	}
}
?>
  </table>
<?php
//換頁按鈕//
echo $pageTableDown;
?>  
  <span class="style18">
  </span><span class="style18">
</span> </div>

<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>