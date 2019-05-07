<?php
/*********************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
*********************************************************************************************/

/*********************************************************************************************
SESSION
*********************************************************************************************/
if ($_COOKIE['PHPSESSID'])	session_id($_COOKIE['PHPSESSID']);
session_start();
header("Cache-control: private");
header("Content-type: text/html; charset=UTF-8");

/*********************************************************************************************
INCLUDE
*********************************************************************************************/
include_once("check.php");
include_once("connect.php");

/*********************************************************************************************
ACTION
*********************************************************************************************/

/*********************************************************************************************
BASIC SETTINGS
*********************************************************************************************/
//取得最新的資料
$str = "SELECT * FROM log_pricemove ORDER BY `datetime` DESC";
$SQLObj0->RunSQL($str);
$SQLObj0->LinkNext();
$datetime = $SQLObj0->GetData('DATETIME');
$date = substr($datetime,0,10);
$mm   = substr($datetime,5,2);
$dd   = substr($datetime,8,2);

/*********************************************************************************************
SELECT FROM DB
*********************************************************************************************/
//搜尋條件//
$tmpstr = '';
if($_POST['teamname'])
{
    $tmpstr .= ' AND A.name LIKE \'%'.$_POST['teamname'].'%\' OR C.nickname LIKE \'%'.$_POST['teamname'].'%\' ';
}
//從資料庫撈資料//
$sqlstr = 'SELECT COUNT(*) 
           FROM '.$ini_array['system']['dbname'].'.myteam_data AS A LEFT JOIN 
           '.$ini_array['system']['dbname'].'.myteam_index AS B ON A.id=B.myteam_id LEFT JOIN 
           '.$ini_array['system']['dbpublic'].'.user_data AS C ON B.user_id=C.id 
           WHERE 1 '.$tmpstr;
$SQLObj0->RunSQL($sqlstr);
if($SQLObj0->LinkNext()) $RowCount = $SQLObj0->GetData('COUNT(*)');
//分頁函式//
$RowsPerPage = 20;
$MyPage = new page($RowCount, $RowsPerPage);
$MyPage->GoPage($_POST['page']);
if($MyPage->TotalRows > 0)
{
    $list = '';
    $sqlstr = '
        SELECT A.id,C.nickname,A.name,A.points,A.money
        FROM '.$ini_array['system']['dbname'].'.myteam_data AS A LEFT JOIN 
        '.$ini_array['system']['dbname'].'.myteam_index AS B ON A.id=B.myteam_id LEFT JOIN 
        '.$ini_array['system']['dbpublic'].'.user_data AS C ON B.user_id=C.id 
        WHERE 1 '.$tmpstr.'
        ORDER BY A.points DESC
        LIMIT '.$MyPage->RowStart.','.$RowsPerPage.';';
    $SQLObj0->RunSQL($sqlstr);
    $nrows = $SQLObj0->LinkAll();
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        //取得排名//
        $rank = GetPointRank($SQLObj1, $row['id']);
        if($rank <= 0) $rank = ' - ';
        //排名升降//
        $last_p_rank = GetLastPointRank($SQLObj1, $row['id']);
        
        $userid = GetUserIDByMyTeamID($SQLObj1,$row['id']);
        /*
        if($rank > $last_p_rank && $last_p_rank != 0)
        {
        	$rank_up_down = '<img src="images/up.gif">'.($rank - $last_p_rank);
        }
        else if($rank < $last_p_rank)
        {
        	$rank_up_down = '<img src="images/down.gif">'.($last_p_rank - $rank);
        }
        else
        {
            $rank_up_down = '<img src="images/up.gif">-';
        }
        */
        $mouse['over'] = 'onMouseOver="this.style.backgroundColor=\'#'.COLOR3.'\';"';
        $mouse['out']  = 'onMouseOut="this.style.backgroundColor=\'#FFFFFF\';"';
        $list .= '
            <tr class="row-white" '.$mouse['over'].' '.$mouse['out'].'>
                <td><center>'.$rank.'</td>
                <td><center>'.$rank_up_down.'</td>
                <td><center>'.GetIcon24($userid).'</td>
                <td><a href="res_roster.php?myteamid='.$row['id'].'&mm='.$mm.'&dd='.$dd.'">'.$row['name'].'</a></td>
                <td>'.$row['nickname'].'</td>
                <td align="right">'.number_format($row['money']*1000).'</td>
                <td align="right">'.number_format($row['points']).'</td>
            </tr>';
    }
}
$MyPage->genPageHtml(3);
$pageTableUp = '
<table width="100%" class="class_table">
<tr>
    <td align="left">共<font color="red">'.$MyPage->TotalRows.'</font>筆</td>
    <td align="right">
    '.$MyPage->PageSelectStr.'
    </td>
</tr>
</table>';
$pageTableDown = '
<table width="100%" class="class_table">
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
$htmlobj    = new html();
$title      = $ini_array['html']['title'];
$meta       = $ini_array['html']['meta'];
$css        = '
<LINK href="css/css.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/fantasygames.css" type="text/css">
	<link rel="stylesheet" href="css/style2007.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">	
	<link rel="stylesheet" href="css/top.css" type="text/css">
';	
$javascript = '
<script language="javascript" type="text/javascript" src="js/MenuSwitch.js"></script>
<script language="javascript" type="text/javascript" src="js/Page.js"></script>';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<form name="form1" action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" id="delete" name="delete" value="0">
<input type="hidden" id="delete_serno" name="delete_serno" value="">
<div align="left" style="margin:0,0,40,0;">
<table width="100%" cellspacing="0" cellpadding="0" class="class_table">
<tr>
    <td align="right">
    <input type="text" id="teamname" name="teamname" value="'.$_POST['teamname'].'">
    <input type="submit" class="class_btn" value="查 詢">
    </td>
</tr>
</table>
'.$pageTableUp.'
<table width="100%" cellspacing="1" cellpadding="2" class="class_table" bgcolor="silver">
<tr class="row-title">
    <th width="15%" colspan="2">排名</th>
    <th width="10%">隊徽</th>
    <th align="left" width="20%">隊伍名稱</th>
    <th align="left" width="20%">玩家</th>
    <th align="right" width="20%">資產</th>
    <th align="right" width="15%">本季積分</th>
</tr>
'.$list.'
</table>
'.$pageTableDown.'
</form>
</div>';
/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("list.tpl.php");
include(dirname(__FILE__)."/down.php");
?>