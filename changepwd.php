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
BASIC SETTINGS
*********************************************************************************************/


/*********************************************************************************************
ACTION
*********************************************************************************************/
if($_POST['action'])
{
    switch ($_POST['action'])
    {
        case MODIFY :
            if($_SESSION['ORIGIN1']['password'] != $_POST['old_pass'])
            {
                $js = 'alert(\'舊密碼不符合!!\');';
                break;
            }
            else 
            {
                $_POST['password'] = $_POST['new_pass'];
            }
            $arraykey    = array_keys($_SESSION['ORIGIN1']);
            $arraydiff   = array_diff_assoc($_POST, $_SESSION['ORIGIN1']);
            $arraymodify = array();
            $logstring   = '';
            foreach($arraydiff as $key => $value)
            {
                if(in_array($key, $arraykey))
                {
                    if($key == 'password')
                    {
                        $arraymodify[] = '`'.$key.'`=\''.md5_encrypt($_POST[$key],$ini_array['system']['md5']).'\'';
                    }
                    else
                    {
                        $arraymodify[] = '`'.$key.'`=\''.$_POST[$key].'\'';
                    }
                    $logstring    .= '['.$_SESSION['ORIGIN1'][$key].']=>['.$_POST[$key].']';
                }
            }
            $stringmodify = implode(",", $arraymodify);
            if(!empty($stringmodify))
            {
                $sqlstr = 'UPDATE '.$ini_array['system']['dbpublic'].'.user_data SET '.$stringmodify.' WHERE id=\''.$_SESSION['loginid'].'\'';
                $SQLObj0->RunSQL($sqlstr);
                //成功後清單要更新，但是不能用Reload，因為會重複刪除的動作。//
                $js = '
                    alert(\'修改密碼成功，需要重新登入系統!!\');
                    top.location.href = \'/logout.php\';
                ';
                $Log->save($dir, '修改密碼 ');
            }
            break;
    }
}

if(!empty($js))
{
    echo '
        <SCRIPT language="javascript">
        <!--
        '.$js.'
        //-->
        </SCRIPT>
    ';
}

/*********************************************************************************************
SELECT FROM DB
*********************************************************************************************/
$sqlstr = 'SELECT password FROM '.$ini_array['system']['dbpublic'].'.user_data WHERE 1 AND id=\''.$_SESSION['loginid'].'\'';
$SQLObj0->RunSQL($sqlstr);
if($SQLObj0->LinkNext())
{
    $row = $SQLObj0->GetData1(0);
    $row['password'] = md5_decrypt($row['password'], $ini_array['system']['md5']);
    $_SESSION['ORIGIN1'] = $row;
    $func = MODIFY;
}

/*********************************************************************************************
HTML
*********************************************************************************************/
$htmlobj    = new html();
$title      = $ini_array['html']['title'];
$meta       = $ini_array['html']['meta'];
$css        = '
<LINK href="css/css.css" rel="stylesheet" type="text/css">';
$javascript = '
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-252630-3";
urchinTracker();
</script>
<script language="javascript" type="text/javascript" src="js/prototype/prototype.js"></script>
<script language="javascript" type="text/javascript" src="js/MySubmit.js"></script>
<script language="javascript" type="text/javascript">
<!--
function checkform(frm, action)
{
    var error  = false;
    var errmsg = "";
    var pattern  = /^[a-zA-Z0-9]+$/;
    if($("new_pass").value == "" || $("new_pass1").value == "" || $("old_pass").value == "")
    {
        errmsg += "欄位皆不可空白!!\n";
        error   = true;
    }
    if($("new_pass").value != $("new_pass1").value)
    {
        errmsg += "新密碼與確認新密碼不符合!!\n";
        error   = true;
    }
    if(!pattern.test($("new_pass").value) || !pattern.test($("new_pass").value))
    {
        errmsg += "密碼不可含有特殊字元及空白!!\n";
        error   = true;
    }
    if(error)
    {
        alert(errmsg);
        return false;
    }
    else
    {
        return true;
    }
}
window.onload = function()
{
    $("old_pass").focus();
}
//-->
</script>';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<div>
<form name="form1" action="'.$_SERVER['PHP_SELF'].'" method="POST" onkeyup="EnterToSubmit(this.btn);">
<input type="hidden" name="action" value="0">
<input type="hidden" name="serno" value="'.$row['serno'].'">
<div style="margin:4px;">
    <table width="350" cellspacing="2" cellpadding="2" class="class_table">
        <tr class="row-title"><th colspan="2">密碼修改</th></tr>
        <tr>
            <th width="20%" class="row-title">舊密碼</th>
            <td class="row-white"><input type="password" id="old_pass" name="old_pass" value="" size="12" maxlength="12"></td>
        </tr>
        <tr>
            <th width="20%" class="row-title">新密碼</th>
            <td class="row-white"><input type="password" id="new_pass" name="new_pass" value="" size="12" maxlength="12"></td>
        </tr>
        <tr>
            <th width="20%" class="row-title">確認新密碼</th>
            <td class="row-white"><input type="password" id="new_pass1" name="new_pass1" value="" size="12" maxlength="12"></td>
        </tr>
        <tr><td align="center" colspan="2">
        <input type="button" value="修 改" id="btn" name="btn" class="class_btn" onClick="MySubmit(this.form,'.$func.');">
        </td></tr>
    </table>
</div>
</form>
</div>
';

/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
$HideLoginWindow = 1;
include_once("include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("register.tpl.php");
?>