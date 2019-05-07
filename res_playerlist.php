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
include_once("connect.php");

/*********************************************************************************************
BASIC SETTINGS
*********************************************************************************************/
if($_GET) $_POST = $_GET;

/*********************************************************************************************
SELECT FROM DB
*********************************************************************************************/
$tmpstr = '';
//球員類別(投手or打者)//
if($_POST['plyertype'])
{
    switch ($_POST['plyertype'])
    {
        case 'P' :
            $tmpstr .= ' AND A.p = 1 ';
            break;
        case 'H' :
            $tmpstr .= ' AND A.p = 0 ';
            break;
    }
}
//日期區間//
if($_POST['peri'])
{
    $Peri = $_POST['peri'];
}
else 
{
    $Peri = 1;
}
//排序//
if($_POST['orderby'])
{
    $tmpstr .= ' ORDER BY '.$_POST['orderby'];
}
$sqlstr = 'SELECT COUNT(*) FROM '.$ini_array['system']['dbname'].'.player_base_data AS A LEFT JOIN
          '.$ini_array['system']['dbname'].'.player_record_2008 AS B ON A.id=B.id 
          WHERE 1 '.$tmpstr.'';
$SQLObj0->RunSQL($sqlstr);
if($SQLObj0->LinkNext()) $RowCount = $SQLObj1->GetData('COUNT(*)');
//分頁函式//
$PARAM['RowsPerPage'] = 25;
$MyPage = new page($RowCount, $PARAM['RowsPerPage']);
$MyPage->GoPage($page);
if($MyPage->TotalRows > 0)
{
    $list = '';
    $sqlstr = '
    SELECT * FROM '.$ini_array['system']['dbname'].'.player_base_data AS A LEFT JOIN
    '.$ini_array['system']['dbname'].'.player_record_2008 AS B ON A.id=B.id 
    WHERE 1 '.$tmpstr.' 
    LIMIT '.$MyPage->RowStart.','.$PARAM['RowsPerPage'].';';
    $SQLObj0->RunSQL($sqlstr);
    $nrows = $SQLObj0->LinkAll();
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        //取得期間成績//
        $PlayerRecord = GetPlayerDataByPeri($SQLObj1, $row['id'], $Peri);
    }
}

/*********************************************************************************************
HTML
*********************************************************************************************/
$htmlobj    = new html();
$title      = $ini_array['html']['title'];
$meta       = $ini_array['html']['meta'];
$css        = '
<LINK href="css/css.css" rel="stylesheet" type="text/css">';
$javascript = '';
$htmlobj->settext($title, $meta, $css, $javascript);

/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("list.tpl.php");
?>