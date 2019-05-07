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
ACTION
*********************************************************************************************/
if($_POST['delete'])
{
    if($_POST['delete_serno'])
    {
        $sqlstr = 'SELECT * FROM '.$ini_array['system']['dbname'].'.news_data WHERE id = \''.$_POST['delete_serno'].'\'';
        $SQLObj1->RunSQL($sqlstr);
        if($SQLObj1->LinkNext())
        {
        	$row    = $SQLObj1->GetData1(0);
            $sqlstr = 'DELETE FROM '.$ini_array['system']['dbname'].'.news_data WHERE id = \''.$_POST['delete_serno'].'\'';
            $SQLObj1->RunSQL($sqlstr);
            //$js = 'alert(\'刪除成功!!\');';
            $Log->save($dir, '刪除新聞 ['.$row['title'].']');
        }
    }
}

if(!empty($js))
{
    print '
    <script language="javascript">
    <!--
    '.$js.'
    //-->
    </script>
    ';
}

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
        $mouse['over'] = 'onMouseOver="this.style.textDecoration=\'underline\';this.style.cursor=\'hand\';"';
        $mouse['out']  = 'onMouseOut="this.style.textDecoration=\'none\';"';
        $list .= '
            <tr class="row-white">
                <td>'.$row['title'].'</td>
                <td>'.$row['content'].'</td>
                <td><center>
                    <span '.$mouse['over'].' '.$mouse['out'].' onClick="GoUrlModify(\''.$row['id'].'\')">修改</span> 
                    <span '.$mouse['over'].' '.$mouse['out'].' onClick="DeleteFromList(\''.$row['id'].'\');">刪除</span>
                </td>
            </tr>';
    }
}
$MyPage->genPageHtml(3);
$pageTable = '
<table width="98%" class="class_table">
<tr>
    <td align="left">共<font color="red">'.$MyPage->TotalRows.'</font>筆</td>
    <td align="right">
    '.$MyPage->PageLinkStr.$MyPage->PageSelectStr.'
    <input type="button" value="新  增" class="class_btn" onClick="GoUrl(\'modify1.php?add=1\',parent.modifyFrame1);">
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
<LINK href="/css/css.css" rel="stylesheet" type="text/css">';
$javascript = '
<script language="javascript" type="text/javascript" src="/js/prototype/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="../../js/GoUrl.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function GoUrlModify(id)
{
    GoUrl(\'modify1.php?id=\' + encodeURI(id), parent.modifyFrame1);
}
function DeleteFromList(id)
{
    if(!confirm(\'確定刪除此筆資料!?\')) return;
    $(\'delete\').value       = 1;
    $(\'delete_serno\').value = id;
    window.document.form1.submit();
}
//-->
</script>
';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<form name="form1" action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" id="delete" name="delete" value="0">
<input type="hidden" id="delete_serno" name="delete_serno" value="">
<div align="left">
'.$pageTable.'
<table width="98%" cellspacing="1" cellpadding="2" class="class_table" bgcolor="silver">
<tr class="row-title">
    <th>主旨</th><th>內容</th><th></th>
</tr>
'.$list.'
</table>
</form>
<div>';
/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("../../include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("modify.tpl.php");
?>