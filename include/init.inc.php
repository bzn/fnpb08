<?php
/*********************************************************************************************
DATE      :
AUTHOR    :
COPYRIGHT :
*********************************************************************************************/

/*****************************************************************************************
/* SMARTY FILE
*****************************************************************************************/
require_once("smartylibs/Smarty.class.php");
//require_once("Smarty.class.php");

/*****************************************************************************************
/* CONFIG FILE
*****************************************************************************************/
include_once("conf.ini.php");

/*****************************************************************************************
/* INCLUDE FILES
*****************************************************************************************/
include_once("include.inc.php");

/*****************************************************************************************
/* INITIAL SMARTY
*****************************************************************************************/
$setting = array();
foreach ($ini_array['smarty'] as $key => $value)
{
    $setting[$key] = dirname(__FILE__).'/'.$value;
}
$smarty = new MySmarty($setting);
unset($setting);

/*****************************************************************************************
/* INITIAL DB CONNECTION
*****************************************************************************************/
include_once("database/database.inc.php");

/*****************************************************************************************
/* COOKIE TO SESSION
*****************************************************************************************/
include_once("chk_account.inc.php");

/*****************************************************************************************
/* INITIAL LOG OBJECT
*****************************************************************************************/
/*if($SQLObj0 && $_SESSION['loginid'])
{
    $Log = new Log($SQLObj0, $ini_array['system']['dbname'], $_SESSION['loginid']);
}*/

/*****************************************************************************************
/* MB SETTINGS
*****************************************************************************************/
mb_internal_encoding("UTF-8");
?>