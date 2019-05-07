<?php
session_start();
extract($_POST);
extract($_GET);
set_time_limit(1000);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");
/*
//匯入排名前500
$str = "SELECT * FROM mumutoys_npb2.myteam_data ORDER BY points DESC LIMIT 0,500";
$SQLObj0->RunSQL($str);
$nrows = $SQLObj0->LinkAll();
$a_teamid = $SQLObj0->GetData("ID");
$a_points = $SQLObj0->GetData("POINTS");
for($i=0;$i<$nrows;$i++)
{
	$str = "SELECT * FROM mumutoys_npb2.myteam_index WHERE myteam_id=".$a_teamid[$i];
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$userid = $SQLObj0->GetData("USER_ID");
		echo ($i+1).".".$a_teamid[$i]." ".$a_points[$i]."<BR>";	
		$str = "INSERT INTO mumutoys_public.rank_data SET userid =".$userid.", myteamid = ".$a_teamid[$i].", year = 200702, rank = ".($i+1);
		$SQLObj0->RunSQL($str);
	}
	
}
*/
//計算榮譽值
for($i=0;$i<5000;$i++)
{
	$str = "SELECT * FROM mumutoys_public.rank_data WHERE userid=".$i;
	$SQLObj0->RunSQL($str);
	if($nrows = $SQLObj0->LinkAll())
	{
		//前500名一顆
		$honor = 1;
		$a_rank = $SQLObj0->GetData("RANK");
		echo $a_rank[0]." - ".$a_rank[1]."<BR>";
		//曾經進入前100名1顆
		if(($a_rank[0] <= 100 && $a_rank[0]>0) || ($a_rank[1] <= 100 && $a_rank[1]>0))
			$honor++;
			
		//前20名1顆
		if($a_rank[0] <= 20 && $a_rank[0]>0)
			$honor++;
		if($a_rank[1] <= 20 && $a_rank[1]>0)
			$honor++;
			
		//前3名1顆
		if($a_rank[0] <= 3 && $a_rank[0]>0)
			$honor++;
		if($a_rank[1] <= 3 && $a_rank[1]>0)
			$honor++;			
			
		if($honor>5)
			$honor = 5;
			
		$str = "UPDATE mumutoys_public.user_data SET honor=".$honor." WHERE id =".$i;
		$SQLObj0->RunSQL($str);
	}
}
?>