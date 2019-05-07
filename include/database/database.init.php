<?php
/*********************************************************************************************
DATE      :
AUTHOR    :
COPYRIGHT :

Initialize Database Object
*******************************************************************************************/
require_once(dirname(__FILE__)."/../class/mysql.class.php");
require(dirname(__FILE__)."/database.ini.php");

if($DB_Setting[0]['inuse'] )
{
    $SQLObj0 = new SQLObj();
    $SQLObj0->connect($DB_Setting[0]['host'],
                      $DB_Setting[0]['dbname'],
                      $DB_Setting[0]['username'],
                      $DB_Setting[0]['password']);        
}

if($DB_Setting[1]['inuse'])
{
    $SQLObj1 = new SQLObj();
    $SQLObj1->connect($DB_Setting[1]['host'],
                      $DB_Setting[1]['dbname'],
                      $DB_Setting[1]['username'],
                      $DB_Setting[1]['password']);
}

if($DB_Setting[2]['inuse'])
{
    $SQLObj2 = new SQLObj();
    $SQLObj2->connect($DB_Setting[2]['host'],
                      $DB_Setting[2]['dbname'],
                      $DB_Setting[2]['username'],
                      $DB_Setting[2]['password']);
}
?>