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
include_once("../../connect.php");

/*********************************************************************************************
SELECT FROM DB
*********************************************************************************************/
//從資料庫撈資料//
$sqlstr = 'SELECT COUNT(*) FROM '.$ini_array['system']['dbname'].'.news_data';
$SQLObj0->RunSQL($sqlstr);
if($SQLObj0->LinkNext()) $RowCount = $SQLObj0->GetData('COUNT(*)');
//分頁函式//
$RowsPerPage = 20;
$MyPage = new page($RowCount, $RowsPerPage);
$MyPage->GoPage($page);
if($MyPage->TotalRows > 0)
{
    $list = '';
    $sqlstr = '
        SELECT * FROM '.$ini_array['system']['dbname'].'.news_data 
        WHERE 1 ORDER BY createtime DESC 
        LIMIT '.$MyPage->RowStart.','.$RowsPerPage.';';
    $SQLObj0->RunSQL($sqlstr);
    $nrows = $SQLObj0->LinkAll();
    for($i = 0 ; $i < $nrows ; $i++)
    {
        $row = $SQLObj0->GetData1($i);
        $list .= '
            <tr>
                <td>'.$row['title'].'</td>
                <td>'.$row['content'].'</td>
                <td></td>
            </tr>';
    }
}

/*********************************************************************************************
HTML
*********************************************************************************************/
$htmlobj    = new html();
$title      = $ini_array['html']['title'];
$meta       = $ini_array['html']['meta'];
$css        = '
<LINK href="/css/css.css" rel="stylesheet" type="text/css">';
$javascript = '
<script language="javascript" type="text/javascript" src="/js/prototype/prototype.js"></script>
';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<table width="98%" cellspacing="1" cellpadding="2" class="class_table" bgcolor="silver">
<tr class="row-title">
    <th>主旨</th><th>內容</th><th></th>
</tr>
</table>';
/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("../../include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("modify.tpl.php");
?>