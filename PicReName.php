<?php
session_start();
extract($_POST);
extract($_GET);
set_time_limit(3000);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");
		
for($i=0;$i<5000;$i++)
{
	$userid = $i;
	$myteamid = GetMyTeamIDByUserID($SQLObj0,$i);
	if($myteamid)
	{		
		if(file_exists("../myteamicon/".$myteamid.".txt"))
		{	
		    if(copy("../myteamicon/".$myteamid.".txt","../usericon/".$userid.".txt"))
		    	echo "OK";
		    if(copy("../myteamicon/".$myteamid.".png","../usericon/".$userid.".png"))
		    	echo $myteamid."OK<BR>";
		    if(file_exists("../usericon/".$userid.".png"))
		    	echo "!!!!";
		}
	}
}

	
?>