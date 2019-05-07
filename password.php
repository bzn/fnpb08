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
ACTION
*********************************************************************************************/
if (!empty ($_POST['account']))
{
    $sqlstr = 'SELECT email,password FROM user_data WHERE 1 AND account=\''.$_POST['account'].'\'';
    $SQLObj0->RunSQL($sqlstr);
    if($SQLObj0->LinkNext())
    {
        $email    = $SQLObj0->GetData('email');
        $password = $SQLObj0->GetData('password');
        $password = md5_decrypt($password,$ini_array['system']['md5']);
        
        $body   = "<a href=\"npb.ohdada.com\">NPB OH!DADA</a>\r\n<br/>";
        $body  .= "YOUR ACCOUNT IS : <font color=\"red\">".$_POST['account']."</font>\r\n<br/>";
        $body  .= "YOU PASSWORD IS : <font color=\"red\">".$password."</font>";
        
        $headers = "From: npb@ohdada.com \r\n";
        $headers.= "Content-Type: text/html; charset=UTF-8 ";
        $headers .= "MIME-Version: 1.0 ";
        mail ($email, "NPB BY OH!DADA", $body, $headers);
        
        $js = 'alert(\'您的密碼已經寄到:'.$email.'\');';
    }
}


if(!empty($js))
{
    echo '
    <script language="javascript" type="text/javascript">
    <!--
    '.$js.'
    //-->
    </script>
    ';
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
<script language="javascript" type="text/javascript">
<!--
window.onload = function()
{
    form1.account.focus();
}
function CheckAccount()
{
    var account = document.getElementById("account").value;
    if(account != "")
    {
        return true;
    }
    else
    {
        alert(\'帳號不可空白!!\');
        return false;
    }
}
//-->
</script>
';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<div align="center">
<table border="0" cellpadding="2" cellspacing="1">
<form name="form1" action="'.$_SERVER['PHP_SELF'].'" method="POST" onsubmit="return CheckAccount();">
<tr>
    <th class="row-title">帳號</th>
    <td>
        <input type="text" id="account" name="account">
        <input class="class_btn" type="submit" value="送出"><br>
    </td>
</tr>
</table>
<span style="color:'.COLOR_ORANGERED.';">發出的Mail有可能被當作是垃圾信，如果沒收到密碼的Mail請檢查一下信箱的垃圾郵件，謝謝!!</span>
</div>
</form>
';

/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
$HideLoginWindow = true;
include_once("include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("register.tpl.php");
?>