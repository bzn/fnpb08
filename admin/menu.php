<?php
/*********************************************************************************************
DATE      : 2006/08/18
AUTHOR    : ahdai(alan@signet.com.tw)
COPYRIGHT : 新台運通股份有限公司
*********************************************************************************************/

/*********************************************************************************************
CACHE
*********************************************************************************************/
header("Expires: " .gmdate ("D, d M Y H:i:s", time() + 60 * 10). " GMT");
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( "Cache-Control: public" ); 

/*********************************************************************************************
SESSION
*********************************************************************************************/
if ($_COOKIE['PHPSESSID'])	session_id($_COOKIE['PHPSESSID']);
session_start();
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
$css        = '<LINK href="../../css/css.css" rel="stylesheet" type="text/css">
               <LINK href="../../css/tree.css" rel="stylesheet" type="text/css">';
$javascript = '<script type="text/javascript" language="javascript" src="../../js/prototype/prototype.js"></script>
               <script type="text/javascript" language="javascript" src="../../js/GoUrl.js"></script>';
$htmlobj->settext($title, $meta, $css, $javascript);

/*********************************************************************************************
JS TREE
*********************************************************************************************/
$html  = '
<SCRIPT language="javascript">
<!--
var TREE_NODES = [
	[\'系統管理\', null, null,
        [\'本日價錢計算器\', \'/tool_pricemove.php\', \'mainFrame\'],
        [\'本日紀錄擷取器\', \'/0801/tool_rec2db.php\', \'mainFrame\'],
        [\'紀錄加總器\', \'/0801/tool_7_15_30.php\', \'mainFrame\'],
        [\'本日積分計算器\', \'/0801/tool_scorer.php\', \'mainFrame\'],
		[\'新聞管理\', \'./news/\', \'mainFrame\'],
		[\'連結管理\', \'./link/\', \'mainFrame\']
	],
	[\'登出\', \'/logout.php\', \'_top\',]
];
//-->
</SCRIPT>';

//==================================MENU END============================================
$html .= '
<SCRIPT language="JavaScript" src="/js/tree/tree_format.js"></SCRIPT>
<SCRIPT language="JavaScript" src="/js/tree/nostree.js"></SCRIPT>
<SCRIPT language="JavaScript">
<!--
var treeName = "Tree";
new NosTree(treeName, TREE_NODES, TREE_FORMAT);
//-->
</SCRIPT>
';

/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("../include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("modify.tpl.php");
?>