<?php
set_time_limit(30);
include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/npb.class.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
$count = 5;

$mktime = gmmktime(gmdate("H")+12,gmdate("i"),gmdate("s"),gmdate("m"),gmdate("d"),gmdate("Y"));
$datetime = gmdate("Y-m-d H:i:s",$mktime);
$mm = substr($datetime,5,2);
$dd = substr($datetime,8,2);
$yy = substr($datetime,0,4);
$hh = substr($datetime,11,2);
$ii = substr($datetime,14,2);
$ss = substr($datetime,17,2);

$mktime = gmmktime($hh,$ii,$ss,$mm,$dd-1,$yy);
$date = gmdate("Y-m-d H:i:s",$mktime);
$mktime = gmmktime($hh,$ii,$ss,$mm,$dd-7,$yy);
$date7 = gmdate("Y-m-d H:i:s",$mktime);
$mktime = gmmktime($hh,$ii,$ss,$mm,$dd-15,$yy);
$date15 = gmdate("Y-m-d H:i:s",$mktime);
$mktime = gmmktime($hh,$ii,$ss,$mm,$dd-30,$yy);
$date30 = gmdate("Y-m-d H:i:s",$mktime);

/*
$str = "TRUNCATE TABLE `myteam_1`";
$SQLObj0->RunSQL($str);
*/
$str = "SELECT * FROM myteam_score_log WHERE datetime >='".$date."'";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_id = $SQLObj0->GetData('TEAMID');
	$a_points = $SQLObj0->GetData('POINTS');
	for($i=0;$i<$nrows;$i++)
	{
		$a_score[$a_id[$i]] += $a_points[$i];
	}
	arsort($a_score);
	$i=0;
	for(reset($a_score); $key = key($a_score); next($a_score)) {	
		$team_name = GetMyteamName($SQLObj0,$key);
		//$user_name = GetNickname($SQLObj0,$key);
		/*
		echo "a_score[".$key."] = ".$a_score[$key]."<BR>";
		$str = "INSERT INTO myteam_1 SET id=".$key.",team_name='".$team_name."',points=".$a_score[$key].",rank=".($i+1);
		$SQLObj0->RunSQL($str);
		*/
		$a_id_1[$i] = $key;
		$a_teamname_1[$i] = $team_name;
		$a_points_1[$i] = $a_score[$key];
		$a_rank_1[$i] = $i+1;
		
		$i++;
		if($i == $count)
			break;
	}
	
	$rankstr = '';
	for($i=0;$i<$count;$i++)
	{
		$rankstr = $rankstr."<tr><td class='row2'>第".$a_rank_1[$i]."名</td><td class='row2'>".$a_teamname_1[$i]."</td><td class='row2'>".$a_points_1[$i]."分</td></tr>
";
	}
	//儲存TXT
    $path = "rank/1.txt";
    @unlink($path);
	//寫入檔案
	$fp = fopen($path,'w');
	//鎖住檔案
	if(flock($fp, LOCK_EX))
	{
		fwrite($fp,$rankstr);
		//解除封鎖
		flock($fp, LOCK_UN);
	}	
	fclose($fp);
}

echo "1-OK<BR>";
//清空
$a_score = array();

$str = "SELECT * FROM myteam_score_log WHERE datetime >='".$date7."'";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_id = $SQLObj0->GetData('TEAMID');
	$a_points = $SQLObj0->GetData('POINTS');
	for($i=0;$i<$nrows;$i++)
	{
		$a_score[$a_id[$i]] += $a_points[$i];
	}
	arsort($a_score);
	$i=0;
	for(reset($a_score); $key = key($a_score); next($a_score)) {	
		$team_name = GetMyteamName($SQLObj0,$key);
		//$user_name = GetNickname($SQLObj0,$key);
		/*
		echo "a_score[".$key."] = ".$a_score[$key]."<BR>";
		$str = "INSERT INTO myteam_1 SET id=".$key.",team_name='".$team_name."',points=".$a_score[$key].",rank=".($i+1);
		$SQLObj0->RunSQL($str);
		*/
		$a_id_7[$i] = $key;
		$a_teamname_7[$i] = $team_name;
		$a_points_7[$i] = $a_score[$key];
		$a_rank_7[$i] = $i+1;
		
		$i++;
		if($i == $count)
			break;
	}
	
	$rankstr = '';
	for($i=0;$i<$count;$i++)
	{
		$rankstr = $rankstr."<tr><td class='row2'>第".$a_rank_7[$i]."名</td><td class='row2'>".$a_teamname_7[$i]."</td><td class='row2'>".$a_points_7[$i]."分</td></tr>
";
	}
	//儲存TXT
    $path = "rank/7.txt";
    @unlink($path);
	//寫入檔案
	$fp = fopen($path,'w');
	//鎖住檔案
	if(flock($fp, LOCK_EX))
	{
		fwrite($fp,$rankstr);
		//解除封鎖
		flock($fp, LOCK_UN);
	}	
	fclose($fp);
}

echo "7-OK<BR>";
//清空
$a_score = array();

$str = "SELECT * FROM myteam_score_log WHERE datetime >='".$date15."'";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_id = $SQLObj0->GetData('TEAMID');
	$a_points = $SQLObj0->GetData('POINTS');
	for($i=0;$i<$nrows;$i++)
	{
		$a_score[$a_id[$i]] += $a_points[$i];
	}
	arsort($a_score);
	$i=0;
	for(reset($a_score); $key = key($a_score); next($a_score)) {	
		$team_name = GetMyteamName($SQLObj0,$key);
		//$user_name = GetNickname($SQLObj0,$key);
		/*
		echo "a_score[".$key."] = ".$a_score[$key]."<BR>";
		$str = "INSERT INTO myteam_1 SET id=".$key.",team_name='".$team_name."',points=".$a_score[$key].",rank=".($i+1);
		$SQLObj0->RunSQL($str);
		*/
		$a_id_15[$i] = $key;
		$a_teamname_15[$i] = $team_name;
		$a_points_15[$i] = $a_score[$key];
		$a_rank_15[$i] = $i+1;
		
		$i++;
		if($i == $count)
			break;
	}
	
	$rankstr = '';
	for($i=0;$i<$count;$i++)
	{
		$rankstr = $rankstr."<tr><td class='row2'>第".$a_rank_15[$i]."名</td><td class='row2'>".$a_teamname_15[$i]."</td><td class='row2'>".$a_points_15[$i]."分</td></tr>
";
	}
	//儲存TXT
    $path = "rank/15.txt";
    @unlink($path);
	//寫入檔案
	$fp = fopen($path,'w');
	//鎖住檔案
	if(flock($fp, LOCK_EX))
	{
		fwrite($fp,$rankstr);
		//解除封鎖
		flock($fp, LOCK_UN);
	}	
	fclose($fp);
}

echo "15-OK<BR>";
//清空
$a_score = array();

$str = "SELECT * FROM myteam_score_log WHERE datetime >='".$date30."'";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_id = $SQLObj0->GetData('TEAMID');
	$a_points = $SQLObj0->GetData('POINTS');
	for($i=0;$i<$nrows;$i++)
	{
		$a_score[$a_id[$i]] += $a_points[$i];
	}
	arsort($a_score);
	$i=0;
	for(reset($a_score); $key = key($a_score); next($a_score)) {	
		$team_name = GetMyteamName($SQLObj0,$key);
		//$user_name = GetNickname($SQLObj0,$key);
		/*
		echo "a_score[".$key."] = ".$a_score[$key]."<BR>";
		$str = "INSERT INTO myteam_1 SET id=".$key.",team_name='".$team_name."',points=".$a_score[$key].",rank=".($i+1);
		$SQLObj0->RunSQL($str);
		*/
		$a_id_30[$i] = $key;
		$a_teamname_30[$i] = $team_name;
		$a_points_30[$i] = $a_score[$key];
		$a_rank_30[$i] = $i+1;
		
		$i++;
		if($i == $count)
			break;
	}
	
	$rankstr = '';
	for($i=0;$i<$count;$i++)
	{
		$rankstr = $rankstr."<tr><td class='row2'>第".$a_rank_30[$i]."名</td><td class='row2'>".$a_teamname_30[$i]."</td><td class='row2'>".$a_points_30[$i]."分</td></tr>
";
	}
	//儲存TXT
    $path = "rank/30.txt";
    @unlink($path);
	//寫入檔案
	$fp = fopen($path,'w');
	//鎖住檔案
	if(flock($fp, LOCK_EX))
	{
		fwrite($fp,$rankstr);
		//解除封鎖
		flock($fp, LOCK_UN);
	}	
	fclose($fp);
}
echo "30-OK<BR>";
?>