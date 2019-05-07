<?php
/*********************************************************************************************
DATE      :
AUTHOR    :
COPYRIGHT :

DATABASE SETTINGS
$DB_Setting[$i]['inuse']    => 是否使用(true/false)
$DB_Setting[$i]['new']      => 是否新增資料庫連線(true/false)
                               (第一條連線一定要新增)
                               (如果false共用第一個連線)
$DB_Setting[$i]['host']     => 伺服器
$DB_Setting[$i]['dbname']   => 資料庫名稱
$DB_Setting[$i]['username'] => 使用者
$DB_Setting[$i]['password'] => 密碼
*******************************************************************************************/
$ini_array['system']['dbname']   = 'mumutoys_npb0801';
$ini_array['system']['dbpublic'] = 'mumutoys_public';
$i = 0;

$DB_Setting[$i]['inuse']    = true;
$DB_Setting[$i]['new']      = true;
$DB_Setting[$i]['host']     = 'localhost';
$DB_Setting[$i]['dbname']   = $ini_array['system']['dbname'];
$DB_Setting[$i]['username'] = 'mumutoys_fantasy';
$DB_Setting[$i]['password'] = '1qaz2wsx';

$i++;
$DB_Setting[$i]['inuse']    = true;
$DB_Setting[$i]['new']      = true;
$DB_Setting[$i]['host']     = 'localhost';
$DB_Setting[$i]['dbname']   = $ini_array['system']['dbname'];
$DB_Setting[$i]['username'] = 'mumutoys_fantasy';
$DB_Setting[$i]['password'] = '1qaz2wsx';

$i++;
$DB_Setting[$i]['inuse']    = true;
$DB_Setting[$i]['new']      = true;
$DB_Setting[$i]['host']     = 'localhost';
$DB_Setting[$i]['dbname']   = $ini_array['system']['dbname'];
$DB_Setting[$i]['username'] = 'mumutoys_fantasy';
$DB_Setting[$i]['password'] = '1qaz2wsx';

unset($i);

?>