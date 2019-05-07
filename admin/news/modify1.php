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
if($_POST['action'])
{
    switch ($_POST['action'])
    {
        case ADD :
            $sqlstr = '
            INSERT INTO '.$ini_array['system']['dbname'].'.news_data (title, content, createtime) 
            VALUES(\''.$_POST['title'].'\',\''.$_POST['content'].'\',NOW());
            ';
            $SQLObj1->RunSQL($sqlstr);
            //成功後清單要更新，但是不能用Reload，因為會重複刪除的動作。//
            $js = '
            parent.listFrame1.document.form1.submit();
            ';
            $Log->save($dir, '新增新聞 ['.$_POST['title'].']');
            break;
        case MODIFY :
            $sqlstr = 'SELECT * FROM '.$ini_array['system']['dbname'].'.news_data 
                       WHERE 1 AND id=\''.$_POST['id'].'\'';
            $SQLObj1->RunSQL($sqlstr);
            if($SQLObj1->LinkNext())
            {
                //比對修改前後的資料//
                $arraykey    = array_keys($_SESSION['ORIGIN']);
                $arraydiff   = array_diff_assoc($_POST, $_SESSION['ORIGIN']);
                $arraymodify = array();
                $logstring   = '';
                foreach($arraydiff as $key => $value)
                {
                    if(in_array($key, $arraykey))
                    {
                        $arraymodify[] = '`'.$key.'`=\''.$_POST[$key].'\'';
                        $logstring    .= '['.$_SESSION['ORIGIN'][$key].']=>['.$_POST[$key].']';
                    }
                }
                //串成SQL字串//
                $stringmodify = implode(",", $arraymodify);
                //判斷是否需要修改//
                if(!empty($stringmodify))
                {
                    $sqlstr = '
                    UPDATE '.$ini_array['system']['dbname'].'.news_data 
                    SET '.$stringmodify.' 
                    WHERE 1 AND id=\''.$_POST['id'].'\'
                    ';
                    $SQLObj1->RunSQL($sqlstr);
                    //成功後清單要更新，但是不能用Reload，因為會重複刪除的動作。//
                    $js = '
                    parent.listFrame1.document.form1.submit();
                    ';
                    $Log->save($dir, '修改新聞 '.$logstring);
                }
            }
            break;
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
if(count($_GET)) $_SESSION['select']['id'] = $_GET['id'];
//從資料庫撈資料//
$sqlstr = 'SELECT * FROM '.$ini_array['system']['dbname'].'.news_data 
           WHERE 1 AND id=\''.$_SESSION['select']['id'].'\'';
$SQLObj0->RunSQL($sqlstr);
if($SQLObj0->LinkNext())
{
    $row  = $SQLObj0->GetData1(0);
    $_SESSION['ORIGIN'] = $row;
    $func = MODIFY;
    $readonly = 'readonly';
}
else 
{
    $row  = $_POST;
    $func = ADD;
    $readonly = '';
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
<script type="text/javascript" language="javascript" src="../../js/MySubmit.js"></script>
<script language="javascript">
<!--
function checkform(frm, action)
{
    if(frm.title.value == "")
    {
        alert(\'主旨不可空白!!\');
        return false;
    }
    if(frm.content.text == "")
    {
        alert(\'內容不可空白!!\');
        return false;
    }
    return true;
}
//-->
</script>
';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<form name="form1" action="'.$_SERVER['PHP_SELF'].'" method="POST" onkeyup="EnterToSubmit(this.btn);">
<div style="margin:4px;" align="center">
    <input type="hidden" name="action" value="0">
    <input type="hidden" name="id" value="'.$row['id'].'">
    <table width="98%" cellspacing="2" cellpadding="2" class="class_table">
        <tr>
            <th width="20%" class="row-title">主旨</th>
            <td width="80%" class="row-white">
                <input id="title" '.$readonly.' type="text" name="title" size="20" maxlength="30" value="'.$row['title'].'">
            </td>
        </tr>
        <tr>
            <th width="20%" class="row-title">內容</th>
            <td width="80%" class="row-white">
                <textarea id="content" name="content" style="width:100%;" rows="6">'.$row['content'].'</textarea>
            </td>
        </tr>
    </table>';
if( $func == ADD || $func == MODIFY )
{
    $html .= '
    <table width="98%" border="0">
        <tr><td align="right">
        <input type="button" value="儲 存" id="btn" name="btn" class="class_btn" onClick="MySubmit(this.form,'.$func.');">
        </td></tr>
    </table>';
}
$html .= '
</div>
</form>
';
/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("../../include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("modify.tpl.php");
?>