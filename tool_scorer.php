<?php
session_start();
extract($_POST);
extract($_GET);
set_time_limit(1500);
include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/npb.class.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
/*
if(empty($_SESSION['admin']))
{
	echo '請先登入';
	exit;
}
*/
if($_POST['action'] == 1)
{
	if(empty($_POST['textfield']) || empty($_POST['textfield2']))
	{
		echo "輸入日期格式有誤";
		exit;
	}
	$a_board = GetPointBoard($SQLObj0,10);
	$mm = $_POST['textfield'];
	$dd = $_POST['textfield2'];
	$yy = THISYEAR;
	$week = gmdate("w",gmmktime(0,0,0,$mm,$dd,$yy));

	$today = THISYEAR."-".sprintf("%02d",$mm)."-".sprintf("%02d",$dd);
	//檢查是否已經更新過了
	$str = "SELECT * FROM log_pricemove WHERE `datetime`>='".$today." 00:00:00' AND `datetime`<='".$today." 23:59:59'";
	echo $str."<BR>";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$pricemovetime = $SQLObj0->GetData('DATETIME');
	}
	else 
	{
		echo "今日尚未更新過價錢喔!!!<BR>";
		exit();
	}

	$today = THISYEAR."-".$mm."-".$dd;
	echo "更新 ".$today." 禮拜 ".$week." 的積分資料<BR>";

	//取得玩家隊伍總數
	$str = "SELECT * FROM myteam_data ORDER BY id DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$teamcount = $SQLObj0->GetData('ID');
	}
	
	$date = $yy."-".sprintf("%02d",$mm)."-".sprintf("%02d",$dd);
	
	//取得所有球員的積分陣列
	$str = "SELECT * FROM player_record_log WHERE `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 24:00:00'";
	$SQLObj0->RunSQL($str);
	if($nrows = $SQLObj0->LinkAll())
	{
		$a_id = $SQLObj0->GetData('PLAYER_ID');
		$a_point = $SQLObj0->GetData('POINTS');
		for($i=0;$i<$nrows;$i++)
		{
			//可能一天兩場比賽,所以用 +=
			$a_player['points'][$a_id[$i]] += $a_point[$i];
		}
	}

	$MyTeamObj = new MyTeamObj();
	//計算所有隊伍積分
	for($i=0;$i<$teamcount;$i++)
	{
		$MyTeamObj->init();
		$MyTeamObj->GetDataByDate($SQLObj0,$i+1,$date);

		//計分
		for($j=0;$j<14;$j++)
		{
			//避免有任何一個位置沒買滿(FULL)
			if($MyTeamObj->pos[$j] != 0)
			{
				$a_team[$i+1] += $a_player['points'][$MyTeamObj->pos[$j]];
				if($i==1)
				{
					echo $MyTeamObj->pos[$j]." - ".$a_player['points'][$MyTeamObj->pos[$j]]."<BR>";
				}
			}
			else 
			{
				$a_team[$i+1] = 0;	
				break;
			}
		}
		
		$str = "UPDATE myteam_score_log SET points=".$a_team[$i+1]." WHERE teamid=".($i+1)." AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 24:00:00'";
		$SQLObj0->RunSQL($str);
			
		//計算總分
		$str = "SELECT SUM(points) AS tol_points FROM myteam_score_log WHERE teamid=".($i+1);
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$tol_points = $SQLObj0->GetData('TOL_POINTS');
		if(!$tol_points)
		{
			$tol_points = 0;
		}
		$str = "UPDATE myteam_data SET points=".$tol_points." WHERE id=".($i+1);
		$SQLObj0->RunSQL($str);
	}

	//計算積分排名
	$str = "SELECT * FROM myteam_data ORDER BY points DESC";
	$SQLObj0->RunSQL($str);
	$nrows = $SQLObj0->LinkAll();
	$a_teamid = $SQLObj0->GetData('ID');
	$a_points = $SQLObj0->GetData('POINTS');
	//var_dump($a_teamid);
	//echo "<BR>";
	$nowrank = 1;
	for($i=0;$i<$nrows;$i++)
	{
		//避免同分情形
		if($i>0 && $a_points[$i] == $a_points[$i-1])
		{
			//不做任何事以延續上一個rank
		}
		else
		{
			$nowrank = $i+1;
		}
		//紀錄排名
		//$last_p_rank = GetLastPointRank($SQLObj0,$a_teamid[$i]);
		$str = "SELECT * FROM myteam_score_log WHERE teamid=".$a_teamid[$i]." ORDER BY datetime DESC LIMIT 1,1";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			$rank = $SQLObj0->GetData('POINT_RANK');
		else
			$rank = 0;
		//這裡紀錄tot_points可能有誤bug
		$str = "UPDATE myteam_score_log SET point_rank=".$nowrank.",tol_points=".$a_points[$i].",last_p_rank=".$rank." WHERE teamid=".$a_teamid[$i];
		echo $str."<BR>";
		$SQLObj0->RunSQL($str);
	}
	
	
	//以下為聯盟專用
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
	
	//以下為提供給日促會的資料
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

	//矯正lea的人數
	$str = "SELECT * FROM lea_data";
	$SQLObj0->RunSQL($str);
	$nrows = $SQLObj0->LinkAll();
	$a_id = $SQLObj0->GetData("ID");
	for($i=0;$i<$nrows;$i++)
	{
		$count = GetLeaMemCountByID($SQLObj0,$a_id[$i]);
		$str = "UPDATE lea_data SET count='".$count."' WHERE id='".$a_id[$i]."'";
		$SQLObj0->RunSQL($str);
	}
}
?>
<form id="form1" name="form1" method="post" action="">
  <input type="hidden" name="action" value="1">
  <b>本日積分計算器 v1.3</b><BR>
  <font color="FFOOOO">注意!!Scorer必須在每日執行7-15-30之後執行 "一次" !!</font>
  <BR>
  請輸入scorer的日期<br />
  <label>
  <input name="textfield" type="text" size="4" />
月  </label>
  <label>
  <input name="textfield2" type="text" size="4" /> 
  日
  </label>
  <br />
  <input type="submit" name="Submit" value="開始計算Scorer" />
</form>