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
header("Content-type:text/xml;charset=UTF-8");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");

/*********************************************************************************************
INCLUDE
*********************************************************************************************/
include_once("../connect.php");

/*********************************************************************************************
ACTION
*********************************************************************************************/
$xml .= '<?xml version="1.0" encoding="UTF-8" ?>';
$xml .= '<data>';

$sqlstr = '
SELECT * FROM '.$ini_array['system']['dbpublic'].'.user_data 
WHERE 1 AND account = \''.$_POST['account'].'\'';
$SQLObj0->RunSQL($sqlstr);
//檢查帳號是否存在//
if($SQLObj0->LinkNext())
{
    $xml .= '<result>0</result>';
}
else 
{
    $xml .= '<result>1</result>';
}

$xml .= '</data>';
echo $xml;
?>