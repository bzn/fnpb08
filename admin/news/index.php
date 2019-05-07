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
$_SESSION['select'] = array();

/*********************************************************************************************
INCLUDE
*********************************************************************************************/
include_once("../../connect.php");

/*********************************************************************************************
HTML
*********************************************************************************************/
$htmlobj    = new html();
$title      = $ini_array['html']['title'];
$meta       = $ini_array['html']['meta'];
$css        = '
<LINK href="/css/css.css" rel="stylesheet" type="text/css">
<LINK href="/css/tab.css" rel="stylesheet" type="text/css">';
$javascript = '
<script type="text/javascript" language="javascript" src="/js/prototype/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="/js/MyTab.js"></script>
<script language="JavaScript" type="text/javascript" src="/js/MyExpand.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
    window.onload = function()
    {
        MyTab.Initial(1,1);
    }
//-->
</script>
';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<div id="list" align="left">
   <iframe name="listFrame1" frameborder="0" width="100%" height="200" src="list1.php"></iframe>
</div>
<div id="modify" align="left">
    <div class="TabDiv" style="margin-top:2px;">
        <input type="button" value="內容" id="TabBtn1">
    </div>
    <div class="PageDiv">
    	<div id="TabPage1">
    	   <iframe name="modifyFrame1" frameborder="0" width="100%" height="200" src="modify1.php"></iframe>
        </div>
    </div>
</div>
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