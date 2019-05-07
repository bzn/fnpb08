<?php
/*
檢查COOKIE中的account,id是否正確
*/
if($SQLObj0 && !empty($_COOKIE['account']) && !empty($_COOKIE['loginid']))
{
    $sqlstr = "SELECT * FROM `".$ini_array['system']['dbpublic']."`.`user_data` 
               WHERE 1 
               AND `account`='".md5_decrypt($_COOKIE['account'], $ini_array['system']['md5'])."' 
               AND `id`='".md5_decrypt($_COOKIE['loginid'], $ini_array['system']['md5'])."'";
    $SQLObj0->RunSQL($sqlstr);
    //如果不一致，清除COOKIE//
    if(!$SQLObj0->LinkNext())
    {
        $_COOKIE = array();
    }
    //如果一致，把COOKIE的值丟給SESSION//
    else 
    {
        $_SESSION['USERDATA']  = $SQLObj0->GetData1(0);
        //紀錄IP//
        $sqlstr = "UPDATE `".$ini_array['system']['dbpublic']."`.`user_data` SET `ip`='".$_SERVER['REMOTE_ADDR']."' WHERE `id`='".$_SESSION['loginid']."'";
        $SQLObj0->RunSQL($sqlstr);
        //避免不活躍//
        $gmnow = gmdate("Y-m-d H:i:s",gmmktime(gmdate("H")+8,gmdate("i"),gmdate("s"),gmdate("m"),gmdate("d"),gmdate("Y")));
        $sqlstr = "
        SELECT * FROM `".$ini_array['system']['dbname']."`.`myteam_index` 
        WHERE 1 AND `user_id` = '".$_SESSION['loginid']."'";
        $SQLObj0->RunSQL($sqlstr);
        if($SQLObj0->LinkNext())
        {
            if($_POST['remember'] == 'Y')
            {
                setcookie("myteamid", md5_encrypt($SQLObj0->GetData('myteam_id'), $ini_array['system']['md5']),time()+60*60*24*365,"",$_SERVER['HTTP_HOST']);
            }
            $_SESSION['myteamid0801'] = $SQLObj0->GetData('myteam_id');
        	$sqlstr = "UPDATE `".$ini_array['system']['dbname']."`.`myteam_data` SET `lastlogin`='".$gmnow."' 
            	       WHERE 1 AND `id`='".$_SESSION['myteamid0801']."'";
        	$SQLObj0->RunSQL($sqlstr);
        }
        $_SESSION['account']   = md5_decrypt($_COOKIE['account'], $ini_array['system']['md5']);
        $_SESSION['loginid']   = md5_decrypt($_COOKIE['loginid'], $ini_array['system']['md5']);
        $_SESSION['myteamid0801']  = md5_decrypt($_COOKIE['myteamid0801'], $ini_array['system']['md5']);
        //$_SESSION['myteamid2'] = md5_decrypt($_COOKIE['myteamid2'], $ini_array['system']['md5']);
    }
}
?>