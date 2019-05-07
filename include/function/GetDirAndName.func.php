<?php
/*
回傳程式所在的路徑
最後一個folder名稱
跟程式的basename
*/
function GetDirAndName($file)
{
    $rArray = array();
    $rArray['pname'] = basename($file);
    $dir             = dirname($file);
    $dir             = explode("/",$dir);
    $count           = count($dir) - 1;
    $rArray['dir']   = $dir[$count];
    return $rArray;
}
?>