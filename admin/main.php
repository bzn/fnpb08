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
$css        = '<LINK href="/css/css.css" rel="stylesheet" type="text/css">';
$javascript = '<script type="text/javascript" language="javascript" src="/js/prototype/prototype.js"></script>';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
    <!--第一個框架(上下)//-->
    <frameset rows="100,*" cols="*" name="frameset1" frameborder="0" border="0" framespacing="0">
        <frame src="top.php" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" title="topFrame" />
        <!--第二個框架(左右)//-->
        <frameset cols="160,*" rows="*" name="frameset2" frameborder="0" border="0" framespacing="0">
            <frame src="menu.php" name="menuFrame" id="menuFrame" title="menuFrame" />
            <frame src="" name="mainFrame" id="mainFrame" title="mainFrame" />
        </frameset>
    </frameset>
    <noframes>
        <body>
        </body>
    </noframes>
';

/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("../include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("blank.tpl.php");
?>