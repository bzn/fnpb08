<?php
/*
Rec to DB Ver2.0
*/
session_start();
extract($_POST);
extract($_GET);
include_once(dirname(__FILE__)."/connect.php");
$isDebug = TRUE;
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
$isHomeScoreOK = FALSE;
$isAwayScoreOK = FALSE;
$isHomeHitterOK = FALSE;
$isAwayHitterOK = FALSE;
$isHomePitcherOK = FALSE;
$isAwayPitcherOK = FALSE;

if($_POST['action'] == 1)
{
	$str = $_POST['textarea'];
	$a_str = explode("\r\n",$str);
	$count = count($a_str);

	for($i=0;$i<$count;$i++)
	{
		if($isDebug)
			echo $a_str[$i]."<BR>";

		//判定日期和對戰組合
		if((substr($a_str[$i],0,4) === "4月") || 
		(substr($a_str[$i],0,4) === "5月") || 
		(substr($a_str[$i],0,4) === "6月") ||
		(substr($a_str[$i],0,4) === "7月") ||
		(substr($a_str[$i],0,4) === "8月") ||
		(substr($a_str[$i],0,4) === "9月") ||
		(substr($a_str[$i],0,5) === "10月") ||
		(substr($a_str[$i],0,6) === "11月"))
		{
			//$a_player_count_pos++;
			$a_temp = explode(" ",$a_str[$i]);
			
			//解析日期
			$str = $a_temp[0];
			//$pos = strpos($str,"2009年");
			$pos2 = strpos($str,"日");
			$datestr = substr($str,0,$pos2+3);
			//echo $datestr;
			//$pos = strpos($datestr,"年");
			$yy = 2009;
			//$datestr = substr($datestr,$pos+3);
			$pos = strpos($datestr,"月");
			$mm = substr($datestr,0,$pos);
			$datestr = substr($datestr,$pos+3);
			$pos = strpos($datestr,"日");
			$dd = substr($datestr,0,$pos);
			$date = $yy."-".sprintf("%02d",$mm)."-".sprintf("%02d",$dd);
			$datetime = $yy."-".sprintf("%02d",$mm)."-".sprintf("%02d",$dd)." 18:00:00";

			$a_temp2 = explode("）",$a_temp[0]);
			$homename = $a_temp2[1];
			$str = "SELECT * FROM team_data WHERE name_3 ='".$homename."'";
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			$homeid = $SQLObj0->GetData('ID');
			
			$a_temp = explode(" ",$a_str[$i]);
			$awayname = $a_temp[2];
			$str = "SELECT * FROM team_data WHERE name_3 ='".$awayname."'";
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			$awayid = $SQLObj0->GetData('ID');
			
			//顯示結果
			echo "<font color='green'>".$yy."年".$mm."月".$dd."日".$homename." vs ".$awayname."</font><BR>";
		}
		else if(substr($a_str[$i],0,strlen($homename)) === $homename)
		{
			if(!$isHomeScoreOK)
			{
				$isHomeScoreOK = TRUE;
				//取得比數
				//$a_str[$i] = str_replace('　','',$a_str[$i]);
				//$a_str[$i] = str_replace('	','',$a_str[$i]);
				$a_temp = explode("	",$a_str[$i]);
				$home_err = array_pop($a_temp);
				$home_h = array_pop($a_temp);
				$home_score = array_pop($a_temp);
	
				echo "<font color='green'>主場：".$home_score."分/".$home_h."安/".$home_err."誤</font><BR>";
				
				//紀錄比數到資料庫
				$str = "UPDATE schedule_data SET score_1=".$home_score." WHERE team_id_1=".$homeid." AND team_id_2=".$awayid." AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 24:00:00'";
				$SQLObj0->RunSQL($str);
			}
		}
		else if(substr($a_str[$i],0,strlen($awayname)) === $awayname)
		{
			if(!$isAwayScoreOK)
			{
				$isAwayScoreOK = TRUE;
				//取得比數
				$a_temp = explode("	",$a_str[$i]);
				$away_err = array_pop($a_temp);
				$away_h = array_pop($a_temp);
				$away_score = array_pop($a_temp);
	
				echo "<font color='green'>客場：".$away_score."分/".$away_h."安/".$away_err."誤</font><BR>";	
				
				//紀錄比數到資料庫
				$str = "UPDATE schedule_data SET score_2=".$away_score." WHERE team_id_1=".$homeid." AND team_id_2=".$awayid." AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 24:00:00'";
				$SQLObj0->RunSQL($str);			
			}
		}
		else if($a_str[$i] === "塁")
		{
			echo "!!!!!!!!!!!!!!!!";
			$i++;
			$nowteamid = 0;
			if(!$isAwayHitterOK)
			{				
				$isAwayHitterOK = TRUE;
				$nowteamid = $awayid;
			}
			else if(!$isHomeHitterOK)
			{
				$isHomeHitterOK = TRUE;
				$nowteamid = $homeid;
			}

			while($i<$count)
			{
				$i++;					
				echo $a_str[$i]."<BR>";
				$a_temp = explode(" ",$a_str[$i]);
				//去除無用符號			
				$a_temp[0] = str_replace('　','',$a_temp[0]);
				$a_temp[0] = str_replace('	','',$a_temp[0]);				
				$a_temp[1] = str_replace('　','',$a_temp[1]);
				$a_temp[1] = str_replace('	','',$a_temp[1]);
				
				if($a_temp[0] === '合計')
				{
					break;
				}
				else if(
				$a_temp[0] === "(一)" ||
				$a_temp[0] === "(二)" ||
				$a_temp[0] === "(三)" ||
				$a_temp[0] === "(遊)" ||
				$a_temp[0] === "(捕)" ||
				$a_temp[0] === "(左)" ||
				$a_temp[0] === "(中)" ||
				$a_temp[0] === "(右)" ||
				$a_temp[0] === "(打)" ||
				$a_temp[0] === "(走)" ||
				$a_temp[0] === "(指)" ||
				$a_temp[0] === "一" ||
				$a_temp[0] === "二" ||
				$a_temp[0] === "三" ||
				$a_temp[0] === "遊" ||
				$a_temp[0] === "捕" ||
				$a_temp[0] === "左" ||
				$a_temp[0] === "中" ||
				$a_temp[0] === "右" ||
				$a_temp[0] === "打" ||
				$a_temp[0] === "走" ||
				$a_temp[0] === "指"
				)
				{
					echo "<font color='green'>".$a_str[$i]."</font><BR>";
					$col1 = 0;$col2 = 0;$col3 = 0;$col4 = 0;$col5 = 0;$col6 = 0;$col7 = 0;$col8 = 0;$col9 = 0;$col10 = 0;$col11 = 0;$points = 0;
					//選手
					$name_2 = $a_temp[1];
					//打数
					$col1 = $a_temp[3];
					//得點
					$col2 = $a_temp[4];
					//安打
					$col3 = $a_temp[5];
					//打點
					$col7 = $a_temp[6];
					//三振
					$col10 = $a_temp[7];
					//四死
					$col9 = $a_temp[8];
					//盗塁
					$col8 = $a_temp[10];
					//二壘打
					$col4 = 0;
					//三壘打
					$col5 = 0;
					//本壘打
					$col6 = $a_temp[12];
					//雙殺打
					$col11 = 0;
					
					$data_count = count($a_temp);
					for($j=13;$j<$data_count;$j++)
					{
						$a_temp[$j] = str_replace('　','',$a_temp[$j]);
						$a_temp[$j] = str_replace('	','',$a_temp[$j]);
						$str = substr($a_temp[$j],6,3);
						if($str === '２')
							$col4++;
						else if($str === '３')
							$col5++;
					}
					//計算績分
					$points = -2*($col1-$col3)+$col2*5+$col3*5+$col4*5+$col5*10+$col6*15+$col7*5+$col8*10+$col9*3-$col10;
					//echo "<font color='green'>".$points."</font><BR>";
					//取得playerid
					$player_id = GetPlayerID($SQLObj0,$name_2,$nowteamid);
					//echo $player_id."<BR>";
					//UPDATE
					if($player_id)
					{
						$str = "UPDATE player_record_log SET pitcher=0,g=1,col1=".$col1.",col2=".$col2.",col3=".$col3.",col4=".$col4.",col5=".$col5.",col6=".$col6.",
								col7=".$col7.",col8=".$col8.",col9=".$col9.",col10=".$col10.",col11=".$col11.",points=".$points." WHERE 
								player_id=".$player_id." AND `datetime`>'".$date." 00:00:00' AND `datetime`<'".$date." 24:00:00'"; 
						$SQLObj0->RunSQL($str);
						echo "<font color='green'>本日積分".$points."</font><BR>";
						echo $str."<BR>";
					}
					else 
					{
						//查無此球員
						echo "<font color='red'>查無 ".$name_2." 此球員!!隊伍id:".$nowteamid."</font><BR>";
					}
				}
			}			
		}
		else if($a_str[$i] === "*")
		{	
			$nowteamid = 0;
			if(!$isAwayPitcherOK)
			{				
				$isAwayPitcherOK = TRUE;
				$nowteamid = $awayid;
			}
			else if(!$isHomePitcherOK)
			{
				$isHomePitcherOK = TRUE;
				$nowteamid = $homeid;
			}

			$nowteamid = $awayid;
			while($i<$count)
			{
				$i++;	
				if($a_str[$i] === "*")
				{
					$nowteamid = $homeid;
				}
				if($isDebug)				
					echo $a_str[$i]."<BR>";
				$a_temp = explode(" ",$a_str[$i]);
				//去除無用符號			
				//去除無用符號			
				$a_temp[0] = str_replace('　','',$a_temp[0]);
				$a_temp[0] = str_replace('	','',$a_temp[0]);				
				$a_temp[1] = str_replace('　','',$a_temp[1]);
				$a_temp[1] = str_replace('	','',$a_temp[1]);
				
				$col1 = 0;$col2 = 0;$col3 = 0;$col4 = 0;$col5 = 0;$col6 = 0;$col7 = 0;$col8 = 0;$col9 = 0;$col10 = 0;$col11 = 0;$points = 0;
				
				$move = 0;
				if($a_temp[0] === "○")
				{
					echo "<font color='green'>[Win]</font>";
					$col1=1;
					$move = 1;
				}
				else if($a_temp[0] === "●")
				{
					echo "<font color='green'>[Lose]</font>";
					$col2=1;
					$move = 1;
				}
				else if($a_temp[0]=== "S")
				{
					echo "<font color='green'>[Save]</font>";
					$col3=1;
					$move = 1;
				}
				else if($a_temp[0]=== "Copyright")
				{
					$i = $count;
					break;
				}
				$name_2 = $a_temp[$move];
				//echo $name_2."<BR>";
				//var_dump($a_temp);				
				//echo "<BR>";
				//投球回数
				//$ip = $a_temp[2-$move];
				$col4 = $a_temp[2+$move];
				$col5 = 0;
				if($a_temp[3+$move] === '1/3')
				{
					$col5 = 1;
					$move++;
				}
				else if($a_temp[3+$move] === '2/3')
				{
					$col5 = 2;	
					$move++;
				}
				//被安打
				$col6 = $a_temp[5+$move];
				//被本塁打
				//$col7 = $a_temp[6-$move];
				//奪三振
				$col9 = $a_temp[7+$move];
				//与四死球
				$col8 = $a_temp[8+$move];
				//失点
				$col10 = $a_temp[9+$move];
				//自責点
				$col11 = $a_temp[10+$move];
				//計算積分
				echo $col1."/".$col2."/".$col3."/".$col4."/".$col5."/".$col6."/".$col9."/".$col8."/".$col11."<BR>";
				$points = $col1*30-$col2*15+$col3*30+$col4*15+$col5*5-$col6*5+$col9*3-$col8*3-$col11*10;
				//取得playerid
				$player_id = GetPlayerID($SQLObj0,$name_2,$nowteamid);
				//echo $player_id."<BR>";
				//UPDATE
				if($player_id)
				{
					$str = "UPDATE player_record_log SET pitcher=1,datetime='".$datetime."',
						g=1,col1=".$col1.",col2=".$col2.",col3=".$col3.",col4=".$col4.",col5=".$col5.",col6=".$col6.",
						col7=".$col7.",col8=".$col8.",col9=".$col9.",col10=".$col10.",col11=".$col11.",points=".$points." WHERE 
						player_id=".$player_id." AND `datetime`>'".$date." 00:00:00' AND `datetime`<'".$date." 24:00:00'"; 
					$SQLObj0->RunSQL($str);
					echo "<font color='green'>".$a_str[$i]."</font><BR>";
					echo "<font color='green'>本日積分".$points."</font><BR>";
					echo $str."<BR>";
				}
				else 
				{
					//查無此球員
					if($points)
						echo "<font color='red'>查無 ".$name_2." 此球員!!隊伍id:".$nowteamid."</font><BR>";
				}
				
			}	
			echo "<font color='red'>本計分程式順利執行終了</font>";
		}
	}
}
?>
<form id="form1" name="form1" method="post" action="">
  <input type="hidden" name="action" value="1">
  <b>本日紀錄擷取器 v2.0</b><BR>
  <textarea name="textarea" cols="60" rows="15"></textarea>
  <br />
  <input type="submit" name="Submit" value="送出" />
</form>
