<?php
session_start();
extract($_POST);
extract($_GET);
set_time_limit(1500);
include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/npb.class.php");

$date = '2008-03-20';

?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
//取得聯盟數
	$str = "SELECT * FROM lea_data";
	$SQLObj0->RunSQL($str);
	$lea_count = $SQLObj0->LinkAll();
	echo $lea_count."個聯盟<BR>";
	for($j=0;$j<$lea_count;$j++)
	{
		//取得lea人數
		$str = "SELECT * FROM lea_index WHERE lea_id = '".($j+1)."'";
		$SQLObj0->RunSQL($str);
		$mem_count = $SQLObj0->LinkAll();
		echo "聯盟".($j+1)."共".$mem_count."隊<BR>";
		if($mem_count)
		{
			$a_teamid = array();
			$a_points = array();
			$a_price = array();
			//取得聯盟成員
			$a_teamid = $SQLObj0->GetData("TEAM_ID");
			for($i=0;$i<$mem_count;$i++)
			{
				$str = "SELECT * FROM myteam_score_log WHERE teamid = '".$a_teamid[$i]."'AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 23:59:59'";
				//echo $str."<BR>";
				$SQLObj0->RunSQL($str);
				$SQLObj0->LinkNext();
				$a_points[$i] = $SQLObj0->GetData("TOL_POINTS");
				//echo $a_points[$i];
				$a_price[$i] = $SQLObj0->GetData("TOL_PRICE");
				//echo $a_price[$i];
			}
			//echo "<BR>";
			//var_dump($a_points);
			//echo "<BR>";
			//var_dump($a_teamid);
			//echo "<BR>";
			//var_dump($a_price);
			//echo "<BR>";
			array_multisort($a_points,SORT_DESC,$a_teamid,$a_price);
			for($i=0;$i<$mem_count;$i++)
			{
				$str = "UPDATE myteam_score_log SET lea_p_rank = '".($i+1)."' WHERE teamid = '".$a_teamid[$i]."'AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 23:59:59'";
				$SQLObj0->RunSQL($str);
				$str = "UPDATE myteam_data SET lea_p_rank = '".($i+1)."' WHERE id = '".$a_teamid[$i]."'";
				$SQLObj0->RunSQL($str);
			}
			array_multisort($a_price,SORT_DESC,$a_teamid,$a_points);
			for($i=0;$i<$mem_count;$i++)
			{
				$str = "UPDATE myteam_score_log SET lea_m_rank = '".($i+1)."' WHERE teamid = '".$a_teamid[$i]."'AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 23:59:59'";
				$SQLObj0->RunSQL($str);
				$str = "UPDATE myteam_data SET lea_m_rank = '".($i+1)."' WHERE id = '".$a_teamid[$i]."'";
				$SQLObj0->RunSQL($str);
			}
		}
	}
?>