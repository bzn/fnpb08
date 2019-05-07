<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
if($_POST['action'] == 1)
{
	include_once(dirname(__FILE__)."/connect.php");
	include_once(dirname(__FILE__)."/npb.func.php");
	$str = $_POST['textarea'];
	$a_str = explode("\r\n",$str);
	$count = count($a_str);
	$picher = false;
	$h = 0;
	$p = 0;
	//隊員計數(先攻打/先攻投/後攻打/後攻投)
	$a_player_count[0] = 0;
	$a_player_count[1] = 0;
	$a_player_count[2] = 0;
	$a_player_count[3] = 0;
	$a_player_count[4] = 0;
	$a_player_count_pos = 0;
	for($i=0;$i<$count;$i++)
	{
		//echo substr($a_str[$i],0,8)."<BR>";
		if((substr($a_str[$i],0,8) === "  先攻"))
		{
			$a_player_count_pos++;
			$a_temp = explode(" ",$a_str[$i]);
			$awayname = $a_temp[3];
			$str = "SELECT * FROM team_data WHERE name_3 ='".$awayname."'";
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			$awayid = $SQLObj0->GetData('ID');
			//$nowteamid = $awayid;
		}
		else if((substr($a_str[$i],0,8) === "  後攻"))
		{
			$a_player_count_pos++;
			$a_temp = explode(" ",$a_str[$i]);
			$homename = $a_temp[3];
			$str = "SELECT * FROM team_data WHERE name_3 ='".$homename."'";
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			$homeid = $SQLObj0->GetData('ID');
			//$nowteamid = $homeid;
		}
		if(substr($a_str[$i],0,4) === "2006")
		{
			//echo $a_str[$i];
			//解析日期
			$pos = strpos($str,"2006年");
			$pos2 = strpos($str,"日",$pos);
			$datestr = substr($str,$pos,$pos2-$pos+3);
			$pos = strpos($datestr,"年");
			$yy = substr($datestr,0,$pos);
			$datestr = substr($datestr,$pos+3);
			//echo $yy."<BR>";
			$pos = strpos($datestr,"月");
			$mm = substr($datestr,0,$pos);
			$datestr = substr($datestr,$pos+3);
			//echo $mm."<BR>";
			$pos = strpos($datestr,"日");
			$dd = substr($datestr,0,$pos);
			//echo $dd."<BR>";
			$datetime = $yy."-".$mm."-".$dd." 18:00:00";
		}
		if(substr($a_str[$i],0,3) === "（")
		{
			$a_str[$i] = str_replace("（","",$a_str[$i]);
			$a_str[$i] = str_replace("）","",$a_str[$i]);
			//echo $a_str[$i]."<BR>";
		}
		if(strlen($a_str[$i]) < 16)
		{
			$picher = false;
		}
		else if(substr($a_str[$i],0,3)==="打"||substr($a_str[$i],0,3)==="一"||substr($a_str[$i],0,3)==="二"||substr($a_str[$i],0,3)==="三"||substr($a_str[$i],0,3)==="遊"||substr($a_str[$i],0,3)==="捕"||substr($a_str[$i],0,3)==="左"||substr($a_str[$i],0,3)==="中"||substr($a_str[$i],0,3)==="右"||substr($a_str[$i],0,3)==="指")
		{
			//echo $a_str[$i]."<BR>";
			$a_hit[$h] = $a_str[$i];
			$h++;
			$a_player_count[$a_player_count_pos]++;
		}
		elseif(substr($a_str[$i],0,3) === "投")
		{
			//echo $a_str[$i]."<BR>";
		}
		elseif(substr($a_str[$i],0,6) === "勝敗")
		{
			$picher = true;
			//echo $a_str[$i]."<BR>";
		}
		elseif($picher == true)
		{
			//echo $a_str[$i]."<BR>";
			$a_picher[$p] = $a_str[$i];
			$p++;
			$a_player_count[$a_player_count_pos]++;
		}
		//$tempstr = substr($a_str[$i],0,1);
		//echo $tempstr;
	}
	//exit();
	for($i=0;$i<$p;$i++)
	{
		echo $a_picher[$i]."<BR>";
		$col1=0;
		$col2=0;
		$col3=0;
		$move = 0;
		if(substr($a_picher[$i],0,3) === "○")
		{
			//echo "W";
			$col1=1;
			$move = 1;
			//$a_picher[$i] = substr($a_picher[$i],4,strlen($a_picher[$i])-4);
		}
		elseif(substr($a_picher[$i],0,3) === "●")
		{
			//echo "L";
			$col2=1;
			$move = 1;
			//$a_picher[$i] = substr($a_picher[$i],4,strlen($a_picher[$i])-4);
		}
		elseif(substr($a_picher[$i],0,1) === "S")
		{
			//echo "S";
			$col3=1;
			$move = 1;
			//$a_picher[$i] = substr($a_picher[$i],2,strlen($a_picher[$i])-2);
		}
		//exit();
		$a_temp = explode(" ",$a_picher[$i]);

		//選手 防御率 投球回数 打者数 投球数 被安打 被本塁打 奪三振 与四死球 失点 自責点 
		//選手
		$name_2 = $a_temp[2-$move];
		//投球回数
		$ip = $a_temp[4-$move];
		$col4 = floor($ip);
		$col5 = $ip-floor($ip);
		//被安打
		$col6 = $a_temp[7-$move];
		//被本塁打
		$col7 = $a_temp[8-$move];
		//奪三振
		$col9 = $a_temp[9-$move];
		//与四死球
		$col8 = $a_temp[10-$move];
		//失点
		$col10 = $a_temp[11-$move];
		//自責点
		$col11 = $a_temp[12-$move];
		//取得球員id
		if($i<$a_player_count[2])
		{
			$nowteamid = $awayid;
			$awaypoint += $col10;
		}
		else
		{
			$nowteamid = $homeid;
			$homepoint += $col10;
		}
		echo $nowteamid."<BR>";
		$player_id = GetPlayerID($SQLObj0,$name_2,$nowteamid);
		//存入資料庫
		$str = "INSERT INTO player_record_log (player_id,datetime,g,col1,col2,col3,col4,col5,col6,col7,col8,col9,col10,col11) 
				VALUES (".$player_id.",'".$datetime."',1,".$col1.",".$col2.",".$col3.",".$col4.",".$col5.",".$col6.",".$col7.",".$col8.",".$col9.",".$col10.",".$col11.")";
		$SQLObj0->RunSQL($str);
		echo $str."<BR>";
	}
	echo "<BR>";
	for($i=0;$i<$h;$i++)
	{
		echo $a_hit[$i]."<BR>";
		$a_temp = explode(" ",$a_hit[$i]);
		//var_dump($a_temp);
		//選手 通算打率 打数 得点 安打 打点 三振 四死 犠打 盗塁 失策 
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
		$col6 = 0;
		//雙殺打
		$col11 = 0;
		
		$count = count($a_temp);
		for($j=12;$j<$count;$j++)
		{
			$str = substr($a_temp[$j],6,3);
			if(substr($a_temp[$j],6,3)==='2')
				$col4++;
			elseif(substr($a_temp[$j],6,3)==='3')
				$col5++;
			elseif(substr($a_temp[$j],6,3)==='本')
				$col6++; 
			elseif(substr($a_temp[$j],3,6)==='併打')  
				$col11++;
		}
		//取得球員id
		if($i<$a_player_count[1])
			$nowteamid = $awayid;
		else
			$nowteamid = $homeid;
		echo $nowteamid."<BR>";
		//取得playerid
		$player_id = GetPlayerID($SQLObj0,$name_2,$nowteamid);
		//存入資料庫
		$str = "INSERT INTO player_record_log (player_id,datetime,g,col1,col2,col3,col4,col5,col6,col7,col8,col9,col10,col11) 
				VALUES (".$player_id.",'".$datetime."',1,".$col1.",".$col2.",".$col3.",".$col4.",".$col5.",".$col6.",".$col7.",".$col8.",".$col9.",".$col10.",".$col11.")";
		$SQLObj0->RunSQL($str);
		echo $str."<BR>";
		//exit();
		echo "<BR>";
	}
	//顯示比數
	echo $awaypoint." : ".$homepoint."<BR>";
	//紀錄比數到資料庫
	//....
	//var_dump($a_player_count);
}
?>
<form id="form1" name="form1" method="post" action="">
  <input type="hidden" name="action" value="1">
  <textarea name="textarea" cols="60" rows="15"></textarea>
  <br />
  <input type="submit" name="Submit" value="送出" />
</form>
