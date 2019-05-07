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

if(in_array($_POST['account'],$ini_array['admin']))
{
    $sqlstr = 'SELECT * FROM '.$ini_array['system']['dbpublic'].'.user_data 
               WHERE 1 AND account=\''.$_POST['account'].'\'';
    $SQLObj0->RunSQL($sqlstr);
    if($SQLObj0->LinkNext())
    {
        $password = $SQLObj0->GetData('password');
        $password = md5_decrypt($password, $ini_array['system']['md5']);
        if($_POST['password'] === $password)
        {
            $_SESSION['loginid'] = $_SESSION['admin'] = $_POST['account']; 
            header("location:main.php");
        }
        else 
        {
            header("location:index.php");
        }
    }
    else 
    {
        header("location:index.php");
    }
}
else 
{
    header("location:index.php");
}
?>