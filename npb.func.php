<?php
//取得出賽次數
function GetPlayerG($SQLObj0,$id)
{
	$str = "SELECT SUM(g) AS tol_g FROM player_record_log WHERE player_id = ".$id;
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('tol_g');
}
//取得最後一次的分數
function GetPlayerLastPoints($SQLObj0,$id)
{
	$str = "SELECT * FROM player_record_log WHERE player_id = ".$id." ORDER BY `datetime` DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('points');
}
//取得球員總分
function GetPlayerAllPoints($SQLObj0,$id)
{
	$str = "SELECT SUM(points) AS tol_points FROM player_record_log WHERE player_id = ".$id;
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('tol_points');
}
//取得玩家隊伍名稱
function GetMyteamName($SQLObj0,$id)
{
	$str = "SELECT * FROM myteam_data WHERE id = ".$id;
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('NAME');
}
//取得玩家隊伍名稱
function GetNickname($SQLObj0,$id)
{
	$str = "SELECT * FROM user_data WHERE id = ".$id;
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('NICKNAME');
}
//取得佔有率
function OwnCount($SQLObj0,$id)
{
	$mktime = mktime(date("H"),date("i"),date("s"),$mm,$dd-8,$yy);
	$lastlogin = date("Y-m-d H:i:s",$mktime);
	$str = "SELECT * FROM myteam_data WHERE p1=".$id." OR p2=".$id." OR p3=".$id." OR p4=".$id." OR p5=".$id." OR c=".$id." OR 1b=".$id." OR 2b=".$id." OR ss=".$id." OR 3b=".$id." OR of1=".$id." OR of2=".$id." OR of3=".$id." OR dh=".$id." AND lastlogin>='".$lastlogin."'";
	$SQLObj0->RunSQL($str);
	return $SQLObj0->LinkAll();
}
//取得總積分
function GetTeamPoints($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_data WHERE id=".$teamid;
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('POINTS');
	}
	return 0;
}
//取得昨日積分
function GetTeamLastPoints($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('POINTS');
	}
	return 0;
}
//取得昨日積分
function GetTeamPointsByDate($SQLObj0,$teamid,$date)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." AND datetime>='".$date." 00:00:00' AND datetime<='".$date." 24:00:00' ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('TOL_POINTS');
	}
	return 0;
}
function GetTeamMoneyByDate($SQLObj0,$teamid,$date)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." AND datetime>='".$date." 00:00:00' AND datetime<='".$date." 24:00:00' ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('TOL_PRICE');
	}
	return 0;
}
function GetTeamPricemoveByDate($SQLObj0,$teamid,$date)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." AND datetime>='".$date." 00:00:00' AND datetime<='".$date." 24:00:00' ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('PRICEMOVE');
	}
	return 0;
}
//顯示標準價錢變動
function ShowPriceMove($pricemove)
{
	if($pricemove == 0)
		return 0;
	else 
		return $pricemove."0,000";
}
//隊伍現金
function GetTeamCash($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_data WHERE id=".$teamid;
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('CASH');
	}
	return 0;
}
//取得玩家隊伍總數
function GetTeamCount($SQLObj0)
{
	$str = "SELECT * FROM myteam_data ORDER BY id DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('ID');
	}
	return 0;
}
//取得資產名次
function GetMoneyRank($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		return $SQLObj0->GetData('PRICE_RANK');
	else 
		return 0;
}
function GetMoneyRankByDate($SQLObj0,$teamid,$date)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." AND datetime>='".$date." 00:00:00' AND datetime<='".$date." 24:00:00' LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		return $SQLObj0->GetData('PRICE_RANK');
	else 
		return 0;
}
//取得積分名次
function GetPointRank($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." AND point_rank<>0 ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		return $SQLObj0->GetData('POINT_RANK');
	else 
		return "-";
}
//取得積分名次
function GetLastPointRank($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		return $SQLObj0->GetData('LAST_P_RANK');
	else 
		return 0;
}
//取得積分名次
function GetLastMoneyRank($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		return $SQLObj0->GetData('PRICE_RANK');
	else 
		return 0;
}
function GetPointRankByDate($SQLObj0,$teamid,$date)
{
	$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." AND datetime>='".$date." 00:00:00' AND datetime<='".$date." 24:00:00' LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		return $SQLObj0->GetData('POINT_RANK');
	else 
		return 0;
}
//取得積分排行榜
function GetPointBoard($SQLObj0,$count)
{
	$str = "SELECT * FROM myteam_data ORDER BY points DESC LIMIT 0,".$count;
	$SQLObj0->RunSQL($str);
	if($nrows = $SQLObj0->LinkAll())
	{
		$a_board['id'] = $SQLObj0->GetData('ID');
		$a_board['teamname'] = $SQLObj0->GetData('NAME');
		$a_board['points'] = $SQLObj0->GetData('POINTS');
		$a_board['money'] = $SQLObj0->GetData('MONEY');
	}
	
	//取得最新的資料
	$str = "SELECT * FROM log_pricemove ORDER BY datetime DESC";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	$datetime = $SQLObj0->GetData('DATETIME');
	//echo $datetime."<BR>";
	$date = substr($datetime,0,10);
	$mm = substr($datetime,5,2);
	$dd = substr($datetime,8,2);
			
	for($i=0;$i<$nrows;$i++)
	{
		if($a_board['id'][$i])
		{
			//取得玩家id
			$str = "SELECT * FROM myteam_index WHERE myteam_id=".$a_board['id'][$i];
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			$user_id = $SQLObj0->GetData('USER_ID');
	
			if(!empty($user_id))
			{
				$str = "SELECT * FROM user_data WHERE id=".$user_id;
				$SQLObj0->RunSQL($str);
				$SQLObj0->LinkNext();
				$a_board['nickname'][$i] = $SQLObj0->GetData('nickname');
			}
			
			$a_board['teamname'][$i] = "<a href='res_roster.php?myteamid=".$a_board['id'][$i]."&mm=".$mm."&dd=".$dd."'>".$a_board['teamname'][$i]."</a>";
			$a_board['money'][$i] = ShowPrice1($a_board['money'][$i]);
			if(empty($a_board['points'][$i]))
				$a_board['points'][$i] = 0;
			if(empty($a_board['money'][$i]))
				$a_board['money'][$i] = 0;
			$a_board['rank'][$i] = 1;
			if($i>0 && $a_board['points'][$i] == $a_board['points'][$i-1])
			{
				$a_board['rank'][$i] = $a_board['rank'][$i-1];
			}
			else 
			{
				$a_board['rank'][$i] = $i+1;
			}
		}
	}
	return $a_board;
}
//取得金錢排行榜
//Roster是否已經買齊
function IsRosterFull($SQLObj0,$teamid)
{
	$str = "SELECT * FROM myteam_data WHERE id = '".$teamid."'";
	$SQLObj0->RunSQL($str);
	if($nows = $SQLObj0->LinkNext())
	{
		if($SQLObj0->GetData('P1')==0||$SQLObj0->GetData('P2')==0||$SQLObj0->GetData('P3')==0||$SQLObj0->GetData('P4')==0||$SQLObj0->GetData('P5')==0||$SQLObj0->GetData('C')==0||$SQLObj0->GetData('1B')==0||$SQLObj0->GetData('2B')==0||$SQLObj0->GetData('3B')==0||$SQLObj0->GetData('SS')==0||$SQLObj0->GetData('OF1')==0||$SQLObj0->GetData('OF2')==0||$SQLObj0->GetData('OF3')==0||$SQLObj0->GetData('DH')==0)
			return FALSE;
		else 
			return TRUE;
	}
	return FALSE;
}

//取得價錢顯示($99,990,000)
function ShowPrice1($price)
{
	if(!$price)
		return "0";
	$price1 = floor($price/100);
	$price2 = $price-$price1*100;

	if($price1)
	{
		$price2 = sprintf("%02d",$price2);
		return $price1.",".$price2."0,000";
	}
	else 
		return $price2."0,000";
}
//取得價錢顯示($99.99M)
function ShowPrice2($price)
{
	if(!$price)
		return;
	$price1 = floor($price/100);
	$price2 = $price-$price1*100;
	$price2 = sprintf("%02d",$price2);
	return "$ ".$price1.".".$price2."M";
}

//取得球員隊伍編號
function GetPlayerTeamID($SQLObj0,$id)
{
	$str = "SELECT * FROM team_index WHERE player_id = ".$id."";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		return $SQLObj0->GetData('TEAM_ID');
	}
}

//取得球員守備位置
function GetPlayerPos($SQLObj0,$id)
{
	if(!$id)
		return '';
	$str = "SELECT * FROM player_base_data WHERE id = ".$id."";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		//取得守備位置
		$player['p'] = $SQLObj0->GetData('P');
		$player['c'] = $SQLObj0->GetData('C');
		$player['1b'] = $SQLObj0->GetData('1B');
		$player['2b'] = $SQLObj0->GetData('2B');
		$player['ss'] = $SQLObj0->GetData('SS');
		$player['3b'] = $SQLObj0->GetData('3B');
		$player['of'] = $SQLObj0->GetData('OF');
		$player['dh'] = $SQLObj0->GetData('DH');

		//防守位置字串
		$posstr = '';
		//是否擁有
		$ishave = IsHave($SQLObj0,$a_player['id']);
		
		//是否凍結
		//....
		
		if($player['p'])
		{
			if($ishave)
				$posstr = $posstr.'P ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=P'>P</a> ";
		}
		if($player['c'])
		{
			if($ishave)
				$posstr = $posstr.'C ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=C'>C</a> ";
		}
		if($player['1b'])
		{
			if($ishave)
				$posstr = $posstr.'1B ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=1B'>1B</a> ";
		}
		if($player['2b'])
		{
			if($ishave)
				$posstr = $posstr.'2B ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=2B'>2B</a> ";
		}
		if($player['ss'])
		{
			if($ishave)
				$posstr = $posstr.'SS ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=SS'>SS</a> ";
		}
		if($player['3b'])
		{
			if($ishave)
				$posstr = $posstr.'3B ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=3B'>3B</a> ";
		}
		if($player['of'])
		{
			if($ishave)
				$posstr = $posstr.'OF ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=OF'>OF</a> ";
		}
		if($player['dh'])
		{
			if($ishave)
				$posstr = $posstr.'DH ';
			else
				$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=DH'>DH</a> ";
		}
		
		return $posstr;
	}
}

//檢查球員是否被凍結
function IsForzen($SQLObj0,$id)
{
	$str = "SELECT * FROM team_index WHERE player_id=".$id."";
	//echo $str."<BR>";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$teamid = $SQLObj0->GetData('TEAM_ID');
		$mktime = mktime(date("H")+1,date("i"),date("s"),date("m"),date("d"),date("Y"));
		$datetime = date("Y-m-d H:i:s",$mktime);
		$date = date("Y-m-d",$mktime);
		$hour = intval(substr($datetime,11,2));

		//確認現在時間是否不介於12:00~18:00之間
		if($hour>12)
		{
		}
		else
		{
			return FALSE;
		}	
		
		//檢查有沒有今天pricemove的資料(是否已經pricemove過了)
		$str = "SELECT * FROM myteam_score_log WHERE teamid=".$teamid." AND datetime>='".$date." 00:00:00' LIMIT 0,1";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			return FALSE;
		}
			
		$str = "SELECT * FROM schedule_data WHERE team_id_1=".$teamid." AND datetime<='".$datetime."'";
		//echo $str."<BR>";
		//exit();
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			return TRUE;

		$str = "SELECT * FROM schedule_data WHERE team_id_2=".$teamid." AND datetime<='".$datetime."'";
		//echo $str."<BR>";
		//exit();
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			return TRUE;
		return FALSE;
	}
	return TRUE;
}

function GetScheduleAll($SQLObj0,$teamid)
{
	$str = "SELECT * FROM schedule_data WHERE (team_id_2 =".$teamid." OR team_id_1=".$teamid.") ORDER BY datetime";
	$SQLObj0->RunSQL($str);
	$nrows = $SQLObj0->LinkAll();
	$a_schedule['count'] = $nrows;
	$a_date = $SQLObj0->GetData('DATETIME');
	$a_teamid1 = $SQLObj0->GetData('TEAM_ID_1');
	$a_teamid2 = $SQLObj0->GetData('TEAM_ID_2');
	$a_score1 = $SQLObj0->GetData('SCORE_1');
	$a_score2 = $SQLObj0->GetData('SCORE_2');
	for($i=0;$i<$nrows;$i++)
	{
		$a_schedule[$i]['datetime'] = $a_date[$i];
		if($a_score1[$i]==0 && $a_score2[$i]==0)
		{
			
		}
		else
			$a_schedule[$i]['score'] = $a_score1[$i].":".$a_score2[$i];
		$winmsg = '和';
		if($teamid == $a_teamid2[$i])
		{
			$a_schedule[$i]['team_name'] = GetTeamName($SQLObj0,$a_teamid1[$i]);
			if($a_score1[$i]>$a_score2[$i])
				$winmsg = '勝';
			else if($a_score1[$i]<$a_score2[$i])
				$winmsg = '敗';
			else 
				$winmsg = '和';
		}
		else
		{
			$a_schedule[$i]['team_name'] = " @ ".GetTeamName($SQLObj0,$a_teamid2[$i]);
			if($a_score1[$i]<$a_score2[$i])
				$winmsg = '勝';
			else if($a_score1[$i]>$a_score2[$i])
				$winmsg = '敗';
			else 
				$winmsg = '和';
		}
		if($a_score1[$i]!=0 && $a_score2[$i]!=0)
			$a_schedule[$i]['score'] = $a_schedule[$i]['score']." ( ".$winmsg." ) ";
		//echo $a_schedule[$i]['datetime']." ".$a_schedule[$i]['team_name']."<BR>";
	}
	return $a_schedule;
}
function IsSeasonStart()
{
	$mktime = mktime(0,0,0,date("m"),date("d"),date("Y"));
	//確認是否已開賽
	if($mktime>=mktime(0,0,0,3,24,2007))
	{
		return TRUE;
	}
	return FALSE;
}
//換算成日文週
function Week2Week($week)
{
	switch ($week)
	{
		case 'Mon':
		{
			return '月';
			break;
		}
		case 'Tue':
		{
			return '火';
			break;
		}
		case 'Wed':
		{
			return '水';
			break;
		}
		case 'Thu':
		{
			return '木';
			break;
		}
		case 'Fri':
		{
			return '金';
			break;
		}
		case 'Sat':
		{
			return '土';
			break;
		}
		case 'Sun':
		{
			return '日';
			break;
		}
	}
}
//取得最近的賽程(期間)
function GetScheduleByPeri($SQLObj0,$teamid,$peri)
{
	//確認是否已開賽
	if(IsSeasonStart())
	{
		/*
		$datetime1 = date("Y-m-d H:i:s",$mktime);
		$mktime = mktime(0,0,0,date("m"),date("d")+$peri,date("Y"));
		$datetime2 = date("Y-m-d H:i:s",$mktime);
		*/
		$datetime = GetLastPricemoveTime($SQLObj0);
		$str = "SELECT * FROM schedule_data WHERE (team_id_2 =".$teamid." OR team_id_1=".$teamid.") AND datetime>'".$datetime."' ORDER BY datetime LIMIT 0,".$peri;
	}
	else 
	{
		$datetime1 = "2007-03-24 00:00:00";
		$datetime2 = "2007-04-21 00:00:00";
		$str = "SELECT * FROM schedule_data WHERE (team_id_2 =".$teamid." OR team_id_1=".$teamid.") AND datetime>'".$datetime1."' AND datetime<'".$datetime2."' ORDER BY datetime LIMIT 0,".$peri;
	}
	
	//echo $str."<BR>";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkAll();
	$a_date = $SQLObj0->GetData('DATETIME');
	$a_teamid1 = $SQLObj0->GetData('TEAM_ID_1');
	$a_teamid2 = $SQLObj0->GetData('TEAM_ID_2');

	//確認是否已開賽
	if(IsSeasonStart())
	{
		$j=0;
		for($i=0;$i<$peri;$i++)
		{
			$mktime = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
			$a_schedule[$i]['datetime'] = date("m-d",$mktime)." ".Week2Week(date("D",$mktime));
			
			//echo "i=".$i." j=".$j."<BR>";
			//echo substr($a_date[$j],5,5)." = ".substr($a_schedule[$i]['datetime'],0,5)."<BR>";
			if(substr($a_date[$j],5,5) === substr($a_schedule[$i]['datetime'],0,5))
			{
				if($teamid == $a_teamid2[$j])
				{
					$a_schedule[$i]['teamid'] = $a_teamid1[$j];
					$a_schedule[$i]['team_name'] = GetTeamName($SQLObj0,$a_teamid1[$j]);
				}
				else
				{
					$a_schedule[$i]['teamid'] = $a_teamid2[$j];
					$a_schedule[$i]['team_name'] = " @ ".GetTeamName($SQLObj0,$a_teamid2[$j]);
				}
				$j++;
			}
		}
	}
	else 
	{
		$j=0;
		for($i=0;$i<$peri;$i++)
		{
			$mktime = mktime(0,0,0,3,24+$i,2007);
			$a_schedule[$i]['datetime'] = date("m-d",$mktime)." ".Week2Week(date("D",$mktime));
			if(substr($a_date[$j],5,5) === substr($a_schedule[$i]['datetime'],0,5))
			{
				if($teamid == $a_teamid2[$j])
				{
					$a_schedule[$i]['teamid'] = $a_teamid1[$j];
					$a_schedule[$i]['team_name'] = " @ ".GetTeamName($SQLObj0,$a_teamid1[$j]);
				}
				else
				{
					$a_schedule[$i]['teamid'] = $a_teamid2[$j];
					$a_schedule[$i]['team_name'] = GetTeamName($SQLObj0,$a_teamid2[$j]);
				}
				$j++;
			}
			//echo $a_schedule[$i]['datetime']." ".$a_schedule[$i]['team_name']."<BR>";
		}
	}
	return $a_schedule;
}
//取得最近的賽程(7日)
function GetSchedule7($SQLObj0,$teamid)
{
	$mktime = mktime(0,0,0,date("m"),date("d"),date("Y"));
	//確認是否已開賽
	if($mktime>mktime(0,0,0,3,24,2007))
	{
		$today = date("Y-m-d H:i:s",$mktime);
		$mktime = mktime(0,0,0,date("m"),date("d")+7,date("Y"));
		$nextweek = date("Y-m-d H:i:s",$mktime);
	}
	else 
	{
		$today = "2007-03-24 00:00:00";
		$nextweek = "2007-03-31 00:00:00";
	}
	$str = "SELECT * FROM schedule_data WHERE (team_id_2 =".$teamid." OR team_id_1=".$teamid.") AND datetime>'".$today."' AND datetime<'".$nextweek."' ORDER BY datetime LIMIT 0,7";
	//echo $str;
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkAll();
	$a_date = $SQLObj0->GetData('DATETIME');
	$a_teamid1 = $SQLObj0->GetData('TEAM_ID_1');
	$a_teamid2 = $SQLObj0->GetData('TEAM_ID_2');

	//確認是否已開賽
	if($mktime>mktime(0,0,0,3,24,2007))
	{
		$j=0;
		for($i=0;$i<7;$i++)
		{
			$mktime = mktime(0,0,0,date("m"),date("d")+$i,date("Y"));
			$a_schedule[$i]['datetime'] = date("m-d",$mktime)." ".Week2Week(date("D",$mktime));
			if(substr($a_date[$j],5,5) === substr($a_schedule[$i]['datetime'],0,5))
			{
				if($teamid == $a_teamid2[$j])
				{
					$a_schedule[$i]['teamid'] = $a_teamid1[$j];
					$a_schedule[$i]['team_name'] = GetTeamName($SQLObj0,$a_teamid1[$j]);
				}
				else
				{
					$a_schedule[$i]['teamid'] = $a_teamid2[$j];
					$a_schedule[$i]['team_name'] = " @ ".GetTeamName($SQLObj0,$a_teamid2[$j]);
				}
				$j++;
			}
		}
	}
	else 
	{
		$j=0;
		for($i=0;$i<7;$i++)
		{
			$mktime = mktime(0,0,0,3,24+$i,2007);
			$a_schedule[$i]['datetime'] = date("m-d",$mktime)." ".Week2Week(date("D",$mktime));
			if(substr($a_date[$j],5,5) === substr($a_schedule[$i]['datetime'],0,5))
			{
				if($teamid == $a_teamid2[$j])
				{
					$a_schedule[$i]['teamid'] = $a_teamid1[$j];
					$a_schedule[$i]['team_name'] = " @ ".GetTeamName($SQLObj0,$a_teamid1[$j]);
				}
				else
				{
					$a_schedule[$i]['teamid'] = $a_teamid2[$j];
					$a_schedule[$i]['team_name'] = GetTeamName($SQLObj0,$a_teamid2[$j]);
				}
				$j++;
			}
			//echo $a_schedule[$i]['datetime']." ".$a_schedule[$i]['team_name']."<BR>";
		}
	}
	return $a_schedule;
}
function GetLastPricemoveTime($SQLObj0)
{
	//取得最新的資料
	$str = "SELECT * FROM log_pricemove ORDER BY datetime DESC";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	$datetime = $SQLObj0->GetData('DATETIME');
	return $datetime;
}

//取得最近的賽程
function GetSchedule($SQLObj0,$teamid)
{
	$datetime = GetLastPricemoveTime($SQLObj0);
	$str = "SELECT * FROM schedule_data WHERE (team_id_2 =".$teamid." OR team_id_1=".$teamid.") AND datetime>'".$datetime."' ORDER BY datetime LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	$date = substr($SQLObj0->GetData('DATETIME'),5,5);
	$teamid1 = $SQLObj0->GetData('TEAM_ID_1');
	$teamid2 = $SQLObj0->GetData('TEAM_ID_2');

	$teamname1 = GetTeamName2($SQLObj0,$teamid1);
	$teamname2 = GetTeamName2($SQLObj0,$teamid2);
	if($teamid1 == $teamid)
		return $date." ".$teamname2;
	else 
		return $date." @ ".$teamname1;
}
//取得隊伍名稱
function GetTeamName($SQLObj0,$id)
{
	$str = "SELECT * FROM team_data WHERE id = '".$id."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('NAME');
}
function GetTeamName2($SQLObj0,$id)
{
	$str = "SELECT * FROM team_data WHERE id = '".$id."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('NAME_2');
}
//取得隊伍名稱
function GetTeamNameByPlayerID($SQLObj0,$playerid)
{
	$str = "SELECT * FROM team_index WHERE player_id = '".$playerid."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	$teamid = $SQLObj0->GetData('TEAM_ID');
	$str = "SELECT * FROM team_data WHERE id = '".$teamid."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('NAME');
}
//取得隊伍名稱
function GetTeamIDByPlayerID($SQLObj0,$playerid)
{
	$str = "SELECT * FROM team_index WHERE player_id = '".$playerid."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('TEAM_ID');
}
//取得球員姓名
function GetPlayerName2($SQLObj0,$id)
{
	if(!$id)
		return '';
	//取得playerid
	$str = "SELECT * FROM player_base_data WHERE id = '".$id."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('NAME_2');
}

function GetPlayerName($SQLObj0,$id)
{
	if(!$id)
		return '';
	//取得playerid
	$str = "SELECT * FROM player_base_data WHERE id = '".$id."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	return $SQLObj0->GetData('NAME');
}

//是否擁有這個球員
function IsHave($SQLObj0,$id)
{
	$str = "SELECT * FROM myteam_data WHERE id = '".$_SESSION['myteamid2']."'";
	$SQLObj0->RunSQL($str);
	if($nows = $SQLObj0->LinkNext())
	{
		if($id == $SQLObj0->GetData('P1') || $id == $SQLObj0->GetData('P2') || $id == $SQLObj0->GetData('P3') || $id == $SQLObj0->GetData('P4') || $id == $SQLObj0->GetData('P5') || $id == $SQLObj0->GetData('C') || $id == $SQLObj0->GetData('1B') || $id == $SQLObj0->GetData('2B') || $id == $SQLObj0->GetData('3B') || $id == $SQLObj0->GetData('SS') || $id == $SQLObj0->GetData('OF1') || $id == $SQLObj0->GetData('OF2') || $id == $SQLObj0->GetData('OF3') || $id == $SQLObj0->GetData('DH'))
			return TRUE;
	}
	return FALSE;
}
//取得最新價錢變動
function GetPriceMove($SQLObj0,$id)
{
	//取得最後一次更新時間
	$str = "SELECT * FROM player_record_log ORDER BY datetime DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		return $SQLObj0->GetData('PRICEMOVE');
	else 
		return 0;
}

//取得當時價錢
function GetPlayerPriceByDatetime($SQLObj0,$id,$date)
{
	if($id)
	{
		$str = "SELECT * FROM player_base_data WHERE id = '".$id."'";
		$SQLObj0->RunSQL($str);
		$nows = $SQLObj0->LinkNext();
		$price = $SQLObj0->GetData('PRICE');
		
		//取得價格變動總合
		$str = "SELECT SUM(pricemove) AS tol_move FROM player_record_log WHERE player_id = '".$id."' AND datetime<='".$date." 24:00:00:00'";
		$SQLObj0->RunSQL($str);
		$nows = $SQLObj0->LinkNext();
		$pricemove = $SQLObj0->GetData('TOL_MOVE');
		return $price+$pricemove;
	}
	return 0;
}

//取得現在價錢
function GetPlayerPrice($SQLObj0,$id)
{
	if($id)
	{
		$str = "SELECT * FROM player_base_data WHERE id = '".$id."'";
		$SQLObj0->RunSQL($str);
		$nows = $SQLObj0->LinkNext();
		$price = $SQLObj0->GetData('PRICE');
		
		//取得最後一次更新時間
		$str = "SELECT * FROM player_record_log ORDER BY datetime DESC LIMIT 0,1";
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$datetime = $SQLObj0->GetData('DATETIME');
		$date = substr($datetime,0,10);
		
		$str = "SELECT SUM(pricemove) AS tol_move FROM player_record_log WHERE player_id = '".$id."' AND datetime<='".$date." 24:00:00:00'";
		$SQLObj0->RunSQL($str);
		$nows = $SQLObj0->LinkNext();
		$pricemove = $SQLObj0->GetData('TOL_MOVE');
		return $price+$pricemove;
	}
	return '';
}

function IsPicher($SQLObj0,$id)
{
	$str = "SELECT * FROM player_base_data WHERE id = '".$id."'";
	$SQLObj0->RunSQL($str);
	$nows = $SQLObj0->LinkNext();
	if($SQLObj0->GetData('P'))
		return TRUE;
	return FALSE;
}

function GetPlayerID($SQLObj0,$name,$teamid)
{
	//取得playerid
	$str = "SELECT * FROM player_base_data WHERE name_2 = '".$name."'";
	$SQLObj0->RunSQL($str);
	$nows = $SQLObj0->LinkAll();
	$a_tempid = $SQLObj0->GetData('ID');
	//避免球員同名
	for($i=0;$i<$nows;$i++)
	{
		$str = "SELECT * FROM team_index WHERE player_id = '".$a_tempid[$i]."' AND team_id = '".$teamid."'";
		echo $str."<BR>";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			return $a_tempid[$i];
	}
}

//取得球員基本資料
function GetPlayerBaseData($SQLObj0,$id)
{
	if(!$id)
	{
		return;
	}
	$a_player['id'] = $id;
	//取得隊伍編號
	$str = "SELECT * FROM team_index WHERE player_id='".$id."'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		$a_player['teamid'] = $SQLObj0->GetData('TEAM_ID');

	//取得隊伍名稱
	$str = "SELECT * FROM team_data WHERE id='".$a_player['teamid']."'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$a_player['teamname'] = $SQLObj0->GetData('NAME');	
		$a_player['teamname_2'] = $SQLObj0->GetData('NAME_2');	
	}
	
	//取得球員姓名
	$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
	//echo $str;
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	$a_player['name'] = $SQLObj0->GetData('NAME');
	$a_player['name_2'] = $SQLObj0->GetData('NAME_2');
	//取得背號
	$a_player['no'] = $SQLObj0->GetData('NO');
	//取得生日
	$a_player['birth'] = $SQLObj0->GetData('BIRTH');
	//取得左右手
	$a_player['pitch'] = $SQLObj0->GetData('PITCH');
	$a_player['bat'] = $SQLObj0->GetData('BAT');
	//取得價錢
	$a_player['price'] = $SQLObj0->GetData('PRICE');
	//取得守備位置
	$a_player['p'] = $SQLObj0->GetData('P');
	$a_player['c'] = $SQLObj0->GetData('C');
	$a_player['1b'] = $SQLObj0->GetData('1B');
	$a_player['2b'] = $SQLObj0->GetData('2B');
	$a_player['ss'] = $SQLObj0->GetData('SS');
	$a_player['3b'] = $SQLObj0->GetData('3B');
	$a_player['of'] = $SQLObj0->GetData('OF');
	$a_player['dh'] = $SQLObj0->GetData('DH');
	
	//取得下場比賽字串
	if($a_player['teamid'])
	{
		$a_player['schedule'] = GetSchedule($SQLObj0,$a_player['teamid']);
	}
	//防守位置字串
	$posstr = '';
	//是否擁有
	$ishave = IsHave($SQLObj0,$a_player['id']);
	$isforzen = IsForzen($SQLObj0,$a_player['id']);
	$playerid = $a_player['id'];
	if($a_player['p'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'P ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=P'>P</a> ";
	}
	if($a_player['c'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'C ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=C'>C</a> ";
	}
	if($a_player['1b'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'1B ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=1B'>1B</a> ";
	}
	if($a_player['2b'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'2B ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=2B'>2B</a> ";
	}
	if($a_player['ss'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'SS ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=SS'>SS</a> ";
	}
	if($a_player['3b'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'3B ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=3B'>3B</a> ";
	}
	if($a_player['of'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'OF ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=OF'>OF</a> ";
	}
	if($a_player['dh'])
	{
		if($ishave || $isforzen)
			$posstr = $posstr.'DH ';
		else
			$posstr = $posstr."<a href='trade.php?addid=".$playerid."&addpos=DH'>DH</a> ";
	}
	$a_player['posstr'] = $posstr;
	return $a_player;
}

//取得球員年度資料
function GetPlayerDataByYear($SQLObj0,$id,$year)
{
	//初始
	$a_player['g'] = '-';
	for($i=0;$i<11;$i++)
		$a_player['col'.($i+1)] = '-';
	$a_player['whip'] = '-';
	$a_player['era'] = '-';
	$a_player['tol_p'] = '-';
	$a_player['avg_p'] = '-';
	$a_player['slg'] = '-';
	$a_player['avg'] = '-';
	$a_player['tol_p'] = '-';
	$a_player['avg_p'] = '-';
	$a_player['yes_p'] = '-';
	$a_player['pricemove'] = '-';
	$a_player['price'] = '-';
		
	$a_player['id'] = $id;
	
	$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	//取得守備位置
	$a_player['p'] = $SQLObj0->GetData('P');
	$a_player['c'] = $SQLObj0->GetData('C');
	$a_player['1b'] = $SQLObj0->GetData('1B');
	$a_player['2b'] = $SQLObj0->GetData('2B');
	$a_player['ss'] = $SQLObj0->GetData('SS');
	$a_player['3b'] = $SQLObj0->GetData('3B');
	$a_player['of'] = $SQLObj0->GetData('OF');
	$a_player['dh'] = $SQLObj0->GetData('DH');
	$season_price = $SQLObj0->GetData('PRICE');
	
	//依時間條件取得球員資料
	switch ($year)
	{
		case 2006:
		{
			$str = "SELECT * FROM player_record_data WHERE player_id='".$id."' AND year='".$year."'";
			break;
		}
	}

	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$a_player['g'] = $SQLObj0->GetData('G');
		//echo "G=".$a_player[$i]['g'];
		for($j=1;$j<12;$j++)
			$a_player['col'.$j] = $SQLObj0->GetData('COL'.$j);
			
		//計算統計數據
		if($a_player['p'])
		{
			$ip = round($a_player['col4']+$a_player['col5']/3);
			if($ip)
			{
				$a_player['whip'] = number_format(($a_player['col6']+$a_player['col8'])/$ip,2);
				$a_player['era'] = number_format($a_player['col11']/$ip*9,2);
			}
			else 
			{
				$a_player['whip'] = 0;
				$a_player['era'] = 0;
			}
			//$a_player['yes_p']
			if($a_player['g'])
			{
				$a_player['tol_p'] = $a_player['col1']*30-$a_player['col2']*15+$a_player['col3']*30+$a_player['col4']*15+$a_player['col5']*5-$a_player['col6']*5-$a_player['col8']*3+$a_player['col9']*3-$a_player['col11']*10;
				$a_player['avg_p'] = number_format($a_player['tol_p'] / $a_player['g'],1);
			}
			else 
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
		}
		else
		{
			if($a_player['col1'])
			{
				$a_player['slg'] = number_format(($a_player['col3']+$a_player['col4']+$a_player['col5']*2)/$a_player['col1'],3);
				$a_player['avg'] = number_format($a_player['col3']/$a_player['col1'],3);
			}
			else 
			{
				$a_player['slg'] = 0;
				$a_player['avg'] = 0;
			}
			//$a_player['yes_p']
			if($a_player['g'])
			{
				$a_player['tol_p'] = ($a_player['col1']-$a_player['col3'])*(-2)+$a_player['col2']*5+$a_player['col3']*5+$a_player['col4']*5+$a_player['col5']*10+$a_player['col6']*15+$a_player['col7']*5+$a_player['col8']*10+$a_player['col9']*3-$a_player['col10'];
				$a_player['avg_p'] = number_format($a_player['tol_p'] / $a_player['g'],1);
			}
			else
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
		}
		//取得昨日成績
		$mktime = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
		$yesterday = date("Y-m-d",$mktime);
		$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$yesterday." 00:00:00:00' AND datetime<='".$yesterday." 24:00:00:00'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			for($j=1;$j<12;$j++)
				$a_col['col'.$j] = $SQLObj0->GetData('COL'.$j);
			if($a_player['p'])
				$a_player['yes_p'] = $a_col['col1']*30-$a_col['col2']*15+$a_col['col3']*30+$a_col['col4']*15+$a_col['col5']*5-$a_col['col6']*5-$a_col['col8']*3+$a_col['col9']*3-$a_col['col11']*10;
			else 
				$a_player['yes_p'] = ($a_col['col1']-$a_col['col3'])*(-2)+$a_col['col2']*5+$a_col['col3']*5+$a_col['col4']*5+$a_col['col5']*10+$a_col['col6']*15+$a_col['col7']*5+$a_col['col8']*10+$a_col['col9']*3-$a_col['col10'];
		}
		//取得昨日價錢變動變動
		$a_player['pricemove'] = GetPriceMove($SQLObj0,$id);
		//取得此時球員價錢
		$a_player['price'] = GetPlayerPrice($SQLObj0,$id);
	}

	return $a_player;
}

//取得球員資料
function GetPlayerDataByDate($SQLObj0,$id,$date)
{
	//初始
	$a_player['g'] = '-';
	for($i=0;$i<11;$i++)
		$a_player['col'.($i+1)] = '-';
	$a_player['whip'] = '-';
	$a_player['era'] = '-';
	$a_player['tol_p'] = '-';
	$a_player['avg_p'] = '-';
	$a_player['slg'] = '-';
	$a_player['avg'] = '-';
	$a_player['tol_p'] = '-';
	$a_player['avg_p'] = '-';
	$a_player['yes_p'] = '-';
	$a_player['pricemove'] = '-';
	$a_player['price'] = '-';
	
	$a_player['id'] = $id;
	$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	//取得守備位置
	$a_player['p'] = $SQLObj0->GetData('P');
	$a_player['c'] = $SQLObj0->GetData('C');
	$a_player['1b'] = $SQLObj0->GetData('1B');
	$a_player['2b'] = $SQLObj0->GetData('2B');
	$a_player['ss'] = $SQLObj0->GetData('SS');
	$a_player['3b'] = $SQLObj0->GetData('3B');
	$a_player['of'] = $SQLObj0->GetData('OF');
	$a_player['dh'] = $SQLObj0->GetData('DH');
	$season_price = $SQLObj0->GetData('PRICE');

	//依時間條件取得球員資料
	$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$date." 00:00:00:00' AND datetime<='".$date." 24:00:00:00'";

	$SQLObj0->RunSQL($str);
	$nrows = $SQLObj0->LinkAll();
	if($nrows)
	{
		$a_g = $SQLObj0->GetData('G');
		
		for($i=0;$i<11;$i++)
			$a_col[$i] = $SQLObj0->GetData('COL'.($i+1));
			
		for($i=0;$i<$nrows;$i++)
		{
			$g += $a_g[$i];
		}
		for($i=0;$i<11;$i++)
		{
			for($j=0;$j<$nrows;$j++)
				$col[$i] += $a_col[$i][$j];
		}
		$a_player['g'] = $g;
		//echo "G=".$a_player[$i]['g'];
		for($i=0;$i<11;$i++)
			$a_player['col'.($i+1)] = $col[$i];
		/*	
		$a_player['g'] = $SQLObj0->GetData('G');
		//echo "G=".$a_player[$i]['g'];
		for($j=1;$j<12;$j++)
			$a_player['col'.$j] = $SQLObj0->GetData('COL'.$j);
		*/	
		//計算統計數據
		if($a_player['p'])
		{
			$ip = round($a_player['col4']+$a_player['col5']/3);
			if($ip)
			{
				$a_player['whip'] = number_format(($a_player['col6']+$a_player['col8'])/$ip,2);
				$a_player['era'] = number_format($a_player['col11']/$ip*9,2);
			}
			else 
			{
				$a_player['whip'] = 0;
				$a_player['era'] = 0;
			}
			//$a_player['yes_p']
			if($a_player['g'])
			{
				$a_player['tol_p'] = $a_player['col1']*30-$a_player['col2']*15+$a_player['col3']*30+$a_player['col4']*15+$a_player['col5']*5-$a_player['col6']*5-$a_player['col8']*3+$a_player['col9']*3-$a_player['col11']*10;
				$a_player['avg_p'] = number_format($a_player['tol_p'] / $a_player['g'],1);
			}
			else 
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
		}
		else
		{
			if($a_player['col1'])
			{
				$a_player['slg'] = number_format(($a_player['col3']+$a_player['col4']+$a_player['col5']*2)/$a_player['col1'],3);
				$a_player['avg'] = number_format($a_player['col3']/$a_player['col1'],3);
			}
			else 
			{
				$a_player['slg'] = 0;
				$a_player['avg'] = 0;
			}
			//$a_player['yes_p']
			if($a_player['g'])
			{
				$a_player['tol_p'] = ($a_player['col1']-$a_player['col3'])*(-2)+$a_player['col2']*5+$a_player['col3']*5+$a_player['col4']*5+$a_player['col5']*10+$a_player['col6']*15+$a_player['col7']*5+$a_player['col8']*10+$a_player['col9']*3-$a_player['col10'];
				$a_player['avg_p'] = number_format($a_player['tol_p'] / $a_player['g'],1);
			}
			else 
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
		}
		//取得昨日成績
		$yy = substr($date,0,4);
		$mm = substr($date,5,2);
		$dd = substr($date,8,2);
		$mktime = mktime(0,0,0,$mm,$dd-1,$yy);
		$yesterday = date("Y-m-d",$mktime);
		$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$date." 00:00:00' AND datetime<='".$date." 24:00:00'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			for($j=1;$j<12;$j++)
				$a_col['col'.$j] = $SQLObj0->GetData('COL'.$j);
			if($a_player['p'])
				$a_player['yes_p'] = $a_col['col1']*30-$a_col['col2']*15+$a_col['col3']*30+$a_col['col4']*15+$a_col['col5']*5-$a_col['col6']*5-$a_col['col8']*3+$a_col['col9']*3-$a_col['col11']*10;
			else 
				$a_player['yes_p'] = ($a_col['col1']-$a_col['col3'])*(-2)+$a_col['col2']*5+$a_col['col3']*5+$a_col['col4']*5+$a_col['col5']*10+$a_col['col6']*15+$a_col['col7']*5+$a_col['col8']*10+$a_col['col9']*3-$a_col['col10'];
			//取得昨日球員價錢變動
			$a_player['pricemove'] = $SQLObj0->GetData('PRICEMOVE');
			//取得此時球員價錢
			$str = "SELECT SUM(pricemove) AS tol_pricemove FROM player_record_log WHERE player_id='".$id."' AND datetime<='".$yesterday." 24:00:00'";
			$SQLObj0->RunSQL($str);
			if($SQLObj0->LinkNext())
				$price_move = $SQLObj0->GetData('TOL_PRICEMOVE');
		}
	}
	//避免沒有紀錄就沒有價錢,所以拿到最外層
	$a_player['price'] = $season_price + $price_move;
	return $a_player;
}

//取得球員資料
function GetPlayerDataByPeri($SQLObj0,$id,$peri)
{
	//初始
	$a_player['g'] = '-';
	for($i=0;$i<11;$i++)
		$a_player['col'.($i+1)] = '-';
	$a_player['whip'] = '-';
	$a_player['era'] = '-';
	$a_player['tol_p'] = '-';
	$a_player['avg_p'] = '-';
	$a_player['slg'] = '-';
	$a_player['avg'] = '-';
	$a_player['tol_p'] = '-';
	$a_player['avg_p'] = '-';
	$a_player['yes_p'] = '-';
	$a_player['pricemove'] = '-';
	$a_player['price'] = '-';
	
	$a_player['id'] = $id;
	$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		//取得守備位置
		$a_player['p'] = $SQLObj0->GetData('P');
		$a_player['c'] = $SQLObj0->GetData('C');
		$a_player['1b'] = $SQLObj0->GetData('1B');
		$a_player['2b'] = $SQLObj0->GetData('2B');
		$a_player['ss'] = $SQLObj0->GetData('SS');
		$a_player['3b'] = $SQLObj0->GetData('3B');
		$a_player['of'] = $SQLObj0->GetData('OF');
		$a_player['dh'] = $SQLObj0->GetData('DH');
		$a_player['price'] = GetPlayerPrice($SQLObj0,$id);
	}

	//依時間條件取得球員資料
	switch ($peri)
	{
		case 1:
		{
			/*
			$mktime = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
			$oldday = date("Y-m-d",$mktime)." 00:00:00";
			$yesterday = date("Y-m-d",$mktime)." 24:00:00";
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$oldday."' AND datetime<='".$yesterday."'";
			*/
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime<=NOW() ORDER BY datetime DESC LIMIT 0,1"; 
			break;
		}
		case 7:
		{
			$mktime = mktime(0,0,0,date("m"),date("d")-7,date("Y"));
			$oldday = date("Y-m-d",$mktime)." 00:00:00";
			$mktime = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$yesterday = date("Y-m-d",$mktime)." 24:00:00";
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$oldday."' AND datetime<='".$yesterday."'";
			break;	
		}
		case 15:
		{
			$mktime = mktime(0,0,0,date("m"),date("d")-15,date("Y"));
			$oldday = date("Y-m-d",$mktime)." 00:00:00";
			$mktime = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$yesterday = date("Y-m-d",$mktime)." 24:00:00";
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$oldday."' AND datetime<='".$yesterday."'";
			break;
		}
		case 30:
		{
			$mktime = mktime(0,0,0,date("m"),date("d")-30,date("Y"));
			$oldday = date("Y-m-d",$mktime)." 00:00:00";
			$mktime = mktime(0,0,0,date("m"),date("d"),date("Y"));
			$yesterday = date("Y-m-d",$mktime)."24:00";
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$oldday."' AND datetime<='".$yesterday."'";
			break;
		}
		case 365:
		{
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'";
			break;
		}
	}
	//echo $str;
	$SQLObj0->RunSQL($str);
	$nrows = $SQLObj0->LinkAll();
	if($nrows)
	{
		$a_g = $SQLObj0->GetData('G');
		
		for($i=0;$i<11;$i++)
			$a_col[$i] = $SQLObj0->GetData('COL'.($i+1));
			//取得價格變動
		$a_pricemove = $SQLObj0->GetData('PRICEMOVE');
		//var_dump($a_pricemove);
		//echo "<BR>";
		for($i=0;$i<$nrows;$i++)
		{
			$g += $a_g[$i];
		}
		for($i=0;$i<11;$i++)
		{
			for($j=0;$j<$nrows;$j++)
				$col[$i] += $a_col[$i][$j];
		}
		$a_player['g'] = $g;
		//echo "G=".$a_player[$i]['g'];
		for($i=0;$i<11;$i++)
			$a_player['col'.($i+1)] = $col[$i];
			
		//計算統計數據
		if($a_player['p'])
		{
			$ip = round($a_player['col4']+$a_player['col5']/3);
			if($ip)
			{
				$a_player['whip'] = number_format(($a_player['col6']+$a_player['col8'])/$ip,2);
				$a_player['era'] = number_format($a_player['col11']/$ip*9,2);
			}
			else 
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
			//$a_player['yes_p']
			if($a_player['g'])
			{
				$a_player['tol_p'] = $a_player['col1']*30-$a_player['col2']*15+$a_player['col3']*30+$a_player['col4']*15+$a_player['col5']*5-$a_player['col6']*5-$a_player['col8']*3+$a_player['col9']*3-$a_player['col11']*10;
				$a_player['avg_p'] = number_format($a_player['tol_p'] / $a_player['g'],1);
			}
			else 
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
		}
		else
		{
			if($a_player['col1'])
			{
				$a_player['slg'] = number_format(($a_player['col3']+$a_player['col4']+$a_player['col5']*2)/$a_player['col1'],3);
				$a_player['avg'] = number_format($a_player['col3']/$a_player['col1'],3);
			}
			else 
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
			//$a_player['yes_p']
			if($a_player['g'])
			{
				$a_player['tol_p'] = ($a_player['col1']-$a_player['col3'])*(-2)+$a_player['col2']*5+$a_player['col3']*5+$a_player['col4']*5+$a_player['col5']*10+$a_player['col6']*15+$a_player['col7']*5+$a_player['col8']*10+$a_player['col9']*3-$a_player['col10'];
				$a_player['avg_p'] = number_format($a_player['tol_p'] / $a_player['g'],1);
			}
			else 
			{
				$a_player['tol_p'] = 0;
				$a_player['avg_p'] = 0;
			}
		}
		
		for($j=0;$j<$nrows;$j++)
		{
			$a_player['pricemove'] += $a_pricemove[$j];
		}
			
		//取得昨日成績
		$mktime = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
		$yesterday = date("Y-m-d",$mktime);
		$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND datetime>='".$yesterday." 00:00:00' AND datetime<='".$yesterday." 24:00:00'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			for($j=1;$j<12;$j++)
				$a_col['col'.$j] = $SQLObj0->GetData('COL'.$j);
			if($a_player['p'])
				$a_player['yes_p'] = $a_col['col1']*30-$a_col['col2']*15+$a_col['col3']*30+$a_col['col4']*15+$a_col['col5']*5-$a_col['col6']*5-$a_col['col8']*3+$a_col['col9']*3-$a_col['col11']*10;
			else 
				$a_player['yes_p'] = ($a_col['col1']-$a_col['col3'])*(-2)+$a_col['col2']*5+$a_col['col3']*5+$a_col['col4']*5+$a_col['col5']*10+$a_col['col6']*15+$a_col['col7']*5+$a_col['col8']*10+$a_col['col9']*3-$a_col['col10'];
		}
	}
	return $a_player;
}
?>