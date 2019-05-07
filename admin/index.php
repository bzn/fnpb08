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
include_once("../connect.php");

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
<script language="javascript" type="text/javascript">
<!--
window.onload = function()
{
    form1.account.focus();
}
//-->
</script>
';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<div align="center">
<table border="0" cellpadding="2" cellspacing="1">
<form name="form1" action="CheckLogIn.php" method="POST">
<tr>
    <th class="row-title">帳號</th><td><input type="text" id="account" name="account"></td>
</tr>
<tr>
    <th class="row-title">
        密碼</th><td><input type="password" id="password" name="password">
        <input class="class_btn" type="submit" value="送出">
    </td>
</tr>
</table>
</div>
</form>
';

/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
$HideLoginWindow = true;
include_once("../include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("register.tpl.php");
?>