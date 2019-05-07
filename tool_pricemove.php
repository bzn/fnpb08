<?php
session_start();
extract($_POST);
extract($_GET);
set_time_limit(3000);
include_once(dirname(__FILE__)."/connect.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
if(empty($_SESSION['admin']))
{
	echo '請先登入';
	exit;
}

//自動化判斷...........
//如果今天已經執行過了
	//return
//如果今天沒比賽
	//執行時間為20:00
//如果今天有比賽
	//執行時間為最後一場比賽開始後的3小時
	
//單日價格變動基準(1000,000)
$pricemove_unit = 200;
//保證不跌之佔有比率30%
$lowpercent = 5;
//保證漲之佔有比率30%
$highpercent = 30;
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
	echo "更新 ".$today." 禮拜 ".$week." 的薪水資料<BR>";
	
	//檢查是否已經更新過了
	$str = "SELECT * FROM log_pricemove WHERE `datetime`>='".$today." 00:00:00' AND `datetime`<='".$today." 23:59:59'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		echo "今日已經更新過價錢了!!!<BR>";
		exit();
	}
	
	//檢查是否已經更新過了
	$str = "SELECT * FROM player_record_log WHERE `datetime`>='".$today." 00:00:00' AND `datetime`<='".$today." 23:59:59'";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		echo $str."<BR>";
		echo "今日已經更新過價錢了(2)!!!<BR>";
		exit();
	}
	//檢查今日是否已經變動過了
	$mktime = gmmktime(19,0,0,$mm,$dd,$yy);
	$today = gmdate("Y-m-d",$mktime);
	$str = "SELECT * FROM myteam_score_log WHERE `datetime`>='".$today." 00:00:00' AND `datetime`<='".$today." 23:59:59' AND teamid=2";
	$SQLObj0->RunSQL($str);
	//今日已經變動
	if($SQLObj0->LinkNext())
	{
		echo "今天算過價錢排名了";
		exit;
	}
	//取得上次pricemove的時間
	$lastmovetime = "1970-00-00 00:00:00";
	$str = "SELECT * FROM log_pricemove ORDER BY `datetime` DESC LIMIT 0,1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$lastmovetime = $SQLObj0->GetData('datetime');
	}
	
	//取得玩家隊伍總數(活躍的)
	$mktime = gmmktime(gmdate("H")+GMHOUR,gmdate("i"),gmdate("s"),$mm,$dd-8,$yy);
	$lastlogin = gmdate("Y-m-d H:i:s",$mktime);
	$str = "SELECT * FROM myteam_data WHERE lastlogin>='".$lastlogin."'";
	$SQLObj0->RunSQL($str);
	$teamcount = $SQLObj0->LinkAll();
	$allteamcount = GetTeamCount($SQLObj0);
	echo "活躍玩家:".$teamcount." 總玩家:".$allteamcount."<BR>";
	
	//取得球員總數
	$str = "SELECT * FROM player_base_data";
	$SQLObj0->RunSQL($str);
	$playercount = $SQLObj0->LinkAll();
	$mktime = gmmktime(gmdate("H")+GMHOUR,gmdate("i"),gmdate("s"),$mm,$dd,$yy);
	$today = gmdate("Y-m-d H:i:s",$mktime);
	//$mktime = gmmktime(19,0,0,$mm,$dd-1,$yy);
	//$yesterday = gmdate("Y-m-d H:i:s",$mktime);
	$str = "SELECT * FROM myteam_trade_log WHERE `datetime` >='".$lastmovetime."' AND `datetime` <'".$today."'";

	$SQLObj0->RunSQL($str);
	$tradecount = $SQLObj0->LinkAll();
	//取得買進球員的陣列(昨日更新時間~現在)
	$a_inid = $SQLObj0->GetData('IN_ID');
	//取得賣出球員的陣列(昨日更新時間~現在)
	$a_outid = $SQLObj0->GetData('OUT_ID');

	for($i=0;$i<$tradecount;$i++)
	{
		if($a_inid[$i])
			$a_allplayer_trade[$a_inid[$i]]++;
		if($a_outid[$i])
			$a_allplayer_trade[$a_outid[$i]]--;
		if($a_outid[$i] == 517)
			$del++;
		if($a_inid[$i] == 517)
			$add++;
	}

	for($i=1;$i<$playercount+1;$i++)
	{
		//預設pricemove
		$a_pricemove[$i] = 0;
		$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d"),gmdate("Y"));
		$a_pricemove[$i] = 0;
		//第一日不做pricemove
		if($mktime>=gmmktime(0,0,0,OPENMM,OPENDD,THISYEAR))
		{			
			//套用價格變動公式
			$a_pricemove[$i] = round($pricemove_unit * ($a_allplayer_trade[$i] / $teamcount) );
			echo $i." : ".$a_allplayer_trade[$i]." / ".$teamcount." = ".$a_pricemove[$i];
		}
		//檢查目前佔有率
		$owncount = OwnCount($SQLObj0,$i);
		//如果佔有率低於設定
		$percent = $owncount/$teamcount*100;
		if($percent <= $lowpercent)
			$a_pricemove[$i] -= 2;
		else if($percent >= $highpercent)
			$a_pricemove[$i] += 2;
		echo " 佔有人數:".$owncount;
		//取得變動前的price
		$a_price[$i] = GetPlayerPrice($SQLObj0,$i);
		//如果在底限之下
		if($a_price[$i] + $a_pricemove[$i] < 50 )
		{
			//不跌
			$a_pricemove[$i] = $a_price[$i] - 50;
		}
		$a_price[$i] = $a_price[$i] + $a_pricemove[$i];

		echo GetPlayerName2($SQLObj0,$i)." : ".$a_pricemove[$i]."<BR>";
		if(IsPicher($SQLObj0,$i))
			$p = 1;
		else 
			$p = 0;
		//紀錄到player_record_log的pricemove
		$str = "INSERT INTO player_record_log (player_id,pitcher,datetime,pricemove) VALUES (".$i.",".$p.",'".$today." 21:00:00',".$a_pricemove[$i].")";
		//echo $str."<BR>";
		$SQLObj0->RunSQL($str);
	}
	//exit;

	//紀錄所有隊伍1800前的名單
	$mktime = gmmktime(19,0,0,$mm,$dd,$yy);
	$today = gmdate("Y-m-d H:i:s",$mktime);
	echo "玩家隊伍總數".$allteamcount."<BR>";
	for($i=0;$i<$allteamcount;$i++)
	{
		//取得名單
		$str = "SELECT * FROM myteam_roster_log WHERE team_id=".($i+1)." AND `datetime`<='".NOW()."' ORDER BY `datetime` DESC LIMIT 0,1";
		//if($i==6)
			//echo "<BR>".$str."<BR>";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$cash = $SQLObj0->GetData('CASH');
			$trade_1 = $SQLObj0->GetData('TRADE_1');
			$trade_2 = $SQLObj0->GetData('TRADE_2');
			$p1 = $SQLObj0->GetData('P1');
			$p2 = $SQLObj0->GetData('P2');
			$p3 = $SQLObj0->GetData('P3');
			$p4 = $SQLObj0->GetData('P4');
			$p5 = $SQLObj0->GetData('P5');
			$c = $SQLObj0->GetData('C');
			$fb = $SQLObj0->GetData('1B');
			$sb = $SQLObj0->GetData('2B');
			$ss = $SQLObj0->GetData('SS');
			$tb = $SQLObj0->GetData('3B');
			$of1 = $SQLObj0->GetData('OF1');
			$of2 = $SQLObj0->GetData('OF2');
			$of3 = $SQLObj0->GetData('OF3');
			$dh = $SQLObj0->GetData('DH');
			//檢查今日是否已經變動過了
			$mktime = gmmktime(19,0,0,$mm,$dd,$yy);
			$today = gmdate("Y-m-d",$mktime);
			$str = "SELECT * FROM myteam_score_log WHERE `datetime`>='".$today." 00:00:00' AND `datetime`<='".$today." 23:59:59' AND teamid=".($i+1);
			$SQLObj0->RunSQL($str);
			//今日未變動
			if(!$SQLObj0->LinkNext())
			{
				$date = substr($today,0,10);
				//取得總價
				$tol_price = $a_price[$p1]+$a_price[$p2]+$a_price[$p3]+$a_price[$p4]+$a_price[$p5]+$a_price[$c]+$a_price[$fb]+$a_price[$sb]+$a_price[$ss]+$a_price[$tb]+$a_price[$of1]+$a_price[$of2]+$a_price[$of3]+$a_price[$dh];
				
				if($i==1)
				{
					echo $p1." ".GetPlayerPriceByDatetime($SQLObj0,$p1,$date)."<BR>";
					echo $p2." ".GetPlayerPriceByDatetime($SQLObj0,$p2,$date)."<BR>";
					echo $p3." ".GetPlayerPriceByDatetime($SQLObj0,$p3,$date)."<BR>";
					echo $p4." ".GetPlayerPriceByDatetime($SQLObj0,$p4,$date)."<BR>";
					echo $p5." ".GetPlayerPriceByDatetime($SQLObj0,$p5,$date)."<BR>";
					echo $c." ".GetPlayerPriceByDatetime($SQLObj0,$c,$date)."<BR>";
					echo $fb." ".GetPlayerPriceByDatetime($SQLObj0,$fb,$date)."<BR>";
					echo $sb." ".GetPlayerPriceByDatetime($SQLObj0,$sb,$date)."<BR>";
					echo $ss." ".GetPlayerPriceByDatetime($SQLObj0,$ss,$date)."<BR>";
					echo $tb." ".GetPlayerPriceByDatetime($SQLObj0,$tb,$date)."<BR>";
					echo $of1." ".GetPlayerPriceByDatetime($SQLObj0,$of1,$date)."<BR>";
					echo $of2." ".GetPlayerPriceByDatetime($SQLObj0,$of2,$date)."<BR>";
					echo $of3." ".GetPlayerPriceByDatetime($SQLObj0,$of3,$date)."<BR>";
					echo $dh." ".GetPlayerPriceByDatetime($SQLObj0,$dh,$date)."<BR>";
					echo $cash."<BR>";
				}
				
				$tol_price = $tol_price + $cash;
				if($i==1)
					echo $tol_price."<BR>";
				//取得價錢變動
				$pricemove = $a_pricemove[$p1]+$a_pricemove[$p2]+$a_pricemove[$p3]+$a_pricemove[$p4]+$a_pricemove[$p5]+$a_pricemove[$c]+$a_pricemove[$fb]+$a_pricemove[$sb]+$a_pricemove[$ss]+$a_pricemove[$tb]+$a_pricemove[$of1]+$a_pricemove[$of2]+$a_pricemove[$of3]+$a_pricemove[$dh];
				//存取到score_log
				$today = THISYEAR."-".$mm."-".$dd." 21:00:00";
				$str = "INSERT INTO myteam_score_log (teamid,datetime,cash,trade_1,trade_2,p1,p2,p3,p4,p5,c,1b,2b,ss,3b,of1,of2,of3,dh,pricemove,tol_price)
				VALUES (".($i+1).",'".$today."',".$cash.",".$trade_1.",".$trade_2.",".$p1.",".$p2.",".$p3.",".$p4.",".$p5.",".$c.",".$fb.",".$sb.",".$ss.",".$tb.",".$of1.",".$of2.",".$of3.",".$dh.",".$pricemove.",".$tol_price.")";
				$SQLObj0->RunSQL($str);
				//存取到myteamdata
				$str = "UPDATE myteam_data SET money=".$tol_price." WHERE id=".($i+1);
				//echo $str."<BR>";
				echo "隊伍id= ".($i+1)."結算資產= ".$tol_price." 今日上漲= ".$pricemove."<BR>";
				$SQLObj0->RunSQL($str);
			}
			else 
			{
				echo "今天算過價錢排名了";
				exit;
			}
		}
	}
	
	//計算資產排名
	$today = THISYEAR."-".$mm."-".$dd;
	$str = "SELECT * FROM myteam_data ORDER BY money DESC";
	echo $str."<BR>";
	$SQLObj0->RunSQL($str);
	$nrows = $SQLObj0->LinkAll();
	$a_teamid = $SQLObj0->GetData('id');
	$a_money = $SQLObj0->GetData('MONEY');
	//var_dump($a_teamid);
	echo "<BR>";
	$nowrank = 1;
	for($i=0;$i<$nrows;$i++)
	{
		//$team_id = $a_teamid[$i];
		//bug這裡會取到0
		//echo $rank = GetLastMoneyRank($SQLObj0,$team_id);
		//echo "<BR>";
		//避免同分情形
		if($i>0 && $a_money[$i] == $a_money[$i-1])
		{
			//不做任何事以延續上一個rank
		}
		else
		{
			$nowrank = $i+1;
		}	
		$str = "SELECT * FROM myteam_score_log WHERE teamid=".$a_teamid[$i]." ORDER BY `datetime` DESC LIMIT 1,1";
		echo $str."<BR>";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$rank = $SQLObj0->GetData('PRICE_RANK');
		}

		//紀錄排名
		$str = "UPDATE myteam_score_log SET price_rank=".$nowrank.",last_m_rank=".$rank." WHERE teamid=".$a_teamid[$i];
		echo $str."<BR>";
		$SQLObj0->RunSQL($str);
	}
	//如果是周3
	if($week == 3)
	{
		for($i=0;$i<$allteamcount;$i++)
		{
			$str = "UPDATE myteam_data SET trade_1=trade_1+3 WHERE id=".($i+1);
			$SQLObj0->RunSQL($str);
		}
		echo "增加投手交易次數!!";
	}
	//如果是周5
	if($week == 5)
	{
		for($i=0;$i<$allteamcount;$i++)
		{
			$str = "UPDATE myteam_data SET trade_2=trade_2+3 WHERE id=".($i+1);
			$SQLObj0->RunSQL($str);
		}
		echo "增加打者交易次數!!";
	}
	
	//是否已經更新過了
	//$str = "INSERT INTO log_pricemove SET `datetime` = '".NOW()."'";
	//$SQLObj0->RunSQL($str);

}
?>
<form id="form1" name="form1" method="post" action="">
  <input type="hidden" name="action" value="1">
  <B>本日價錢計算器 v1.1</B><BR>
  <font color="FFOOOO">注意!!pricemove必須在每日所有比賽開始之後執行!!並耐心等候程式執行完成</font>
  <BR>
  請輸入price move的日期<br />
  <label>
  <input name="textfield" type="text" size="4" />
月  </label>
  <label>
  <input name="textfield2" type="text" size="4" /> 
  日
  </label>
  <br />
  <input type="submit" name="Submit" value="開始計算pricemove" />
</form>