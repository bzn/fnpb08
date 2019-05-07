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
if(empty($_SESSION['admin']))
{
	echo '請先登入';
	exit;
}

if($_POST['action'] == 1)
{
	$a_board = GetPointBoard($SQLObj0,10);
	$mm = $_POST['textfield'];
	$dd = $_POST['textfield2'];
	$yy = THISYEAR;

	if(empty($_POST['textfield']) || empty($_POST['textfield2']))
	{
		echo "輸入日期格式有誤";
		exit;
	}
	
	$mktime = gmmktime(0,0,0,$mm,$dd,$yy);
	$date = gmdate("Y-m-d",$mktime);
	$mktime = gmmktime(0,0,0,$mm,$dd-6,$yy);
	$date7 = gmdate("Y-m-d",$mktime);
	$mktime = gmmktime(0,0,0,$mm,$dd-14,$yy);
	$date15 = gmdate("Y-m-d",$mktime);
	$mktime = gmmktime(0,0,0,$mm,$dd-29,$yy);
	$date30 = gmdate("Y-m-d",$mktime);
	
	//取得球員總數
	$str = "SELECT * FROM player_base_data";
	$SQLObj0->RunSQL($str);
	$playercount = $SQLObj0->LinkAll();
	
	//清空資料庫
	$str = "TRUNCATE TABLE player_record_7";
	$SQLObj0->RunSQL($str);
	//清空資料庫
	$str = "TRUNCATE TABLE player_record_15";
	$SQLObj0->RunSQL($str);
	//清空資料庫
	$str = "TRUNCATE TABLE player_record_30";
	$SQLObj0->RunSQL($str);
	//清空資料庫
	$str = "TRUNCATE TABLE player_record_2008";
	$SQLObj0->RunSQL($str);
	
	for($i=0;$i<$playercount;$i++)
	{
		$id = $i+1;
		//取得球員守備位置
		$str = "SELECT * FROM player_base_data WHERE id = ".$id."";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			//取得守備位置
			$p = $SQLObj0->GetData('P');
			$c = $SQLObj0->GetData('C');
			$fb = $SQLObj0->GetData('1B');
			$sb = $SQLObj0->GetData('2B');
			$ss = $SQLObj0->GetData('SS');
			$tb = $SQLObj0->GetData('3B');
			$of = $SQLObj0->GetData('OF');
			$dh = $SQLObj0->GetData('DH');
			$price = $SQLObj0->GetData('PRICE');
		}
		// 7 days
		$str = "SELECT SUM(g) AS tg,SUM(col1) AS tcol1,SUM(col2) AS tcol2,SUM(col3) AS tcol3,SUM(col4) AS tcol4,SUM(col5) AS tcol5,SUM(col6) AS tcol6,SUM(col7) AS tcol7,SUM(col8) AS tcol8,SUM(col9) AS tcol9,SUM(col10) AS tcol10,SUM(col11) AS tcol11,SUM(points) AS tpoints,SUM(pricemove) AS tpricemove FROM player_record_log WHERE player_id=".$id." AND `datetime`>='".$date7." 00:00:00'";
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$tg = $SQLObj0->GetData('TG');
		for($j=0;$j<11;$j++)
		{
			$tcol[$j] = $SQLObj0->GetData('TCOL'.($j+1));
		}
		$tppoints = $SQLObj0->GetData('TPOINTS');
		$tpricemove = $SQLObj0->GetData('TPRICEMOVE');
		//計算統計數據
		if($p)
		{
			$ip = round($tcol[3]+$tcol[4]/3);
			if($ip)
			{				
				//whip
				$tcol[11] = number_format(($tcol[5]+$tcol[7])/$ip,2)*1000;
				//era
				$tcol[12] = number_format($tcol[10]/$ip*9,2)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else 
			{
				$avg_points = 0;
			}
		}
		else
		{
			if($tcol[0])
			{
				//slg
				$tcol[11] = number_format(($tcol[2]+$tcol[3]+$tcol[4]*2)/$tcol[0],3)*1000;
				//avg
				$tcol[12] = number_format($tcol[2]/$tcol[0],3)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else
			{
				$avg_points = 0;
			}
		}
		
		$str = "INSERT INTO player_record_7 SET points=".$tppoints.",pricemove=".$tpricemove.",player_id=".$id.",p=".$p.",c=".$c.",1b=".$fb.",2b=".$fb.",ss=".$ss.",3b=".$tb.",of=".$of.",dh=".$dh.",g=".$tg.",col1=".$tcol[0].",col2=".$tcol[1].",col3=".$tcol[2].",col4=".$tcol[3].",col5=".$tcol[4].",col6=".$tcol[5].",col7=".$tcol[6].",col8=".$tcol[7].",col9=".$tcol[8].",col10=".$tcol[9].",col11=".$tcol[10].",col12=".$tcol[11].",col13=".$tcol[12].",avg_points=".$avg_points;
		$SQLObj0->RunSQL($str);
		
		// 15 days
		$str = "SELECT SUM(g) AS tg,SUM(col1) AS tcol1,SUM(col2) AS tcol2,SUM(col3) AS tcol3,SUM(col4) AS tcol4,SUM(col5) AS tcol5,SUM(col6) AS tcol6,SUM(col7) AS tcol7,SUM(col8) AS tcol8,SUM(col9) AS tcol9,SUM(col10) AS tcol10,SUM(col11) AS tcol11,SUM(points) AS tpoints,SUM(pricemove) AS tpricemove FROM player_record_log WHERE player_id=".$id." AND `datetime`>='".$date15." 00:00:00'";
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$tg = $SQLObj0->GetData('TG');
		for($j=0;$j<11;$j++)
		{
			$tcol[$j] = $SQLObj0->GetData('TCOL'.($j+1));
		}
		$tppoints = $SQLObj0->GetData('TPOINTS');
		$tpricemove = $SQLObj0->GetData('TPRICEMOVE');
		
		//計算統計數據
		if($p)
		{
			$ip = round($tcol[3]+$tcol[4]/3);
			if($ip)
			{				
				//whip
				$tcol[11] = number_format(($tcol[5]+$tcol[7])/$ip,2)*1000;
				//era
				$tcol[12] = number_format($tcol[10]/$ip*9,2)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else 
			{
				$avg_points = 0;
			}
		}
		else
		{
			if($tcol[0])
			{
				//slg
				$tcol[11] = number_format(($tcol[2]+$tcol[3]+$tcol[4]*2)/$tcol[0],3)*1000;
				//avg
				$tcol[12] = number_format($tcol[2]/$tcol[0],3)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else
			{
				$avg_points = 0;
			}
		}
		
		$str = "INSERT INTO player_record_15 SET points=".$tppoints.",pricemove=".$tpricemove.",player_id=".$id.",p=".$p.",c=".$c.",1b=".$fb.",2b=".$fb.",ss=".$ss.",3b=".$tb.",of=".$of.",dh=".$dh.",g=".$tg.",col1=".$tcol[0].",col2=".$tcol[1].",col3=".$tcol[2].",col4=".$tcol[3].",col5=".$tcol[4].",col6=".$tcol[5].",col7=".$tcol[6].",col8=".$tcol[7].",col9=".$tcol[8].",col10=".$tcol[9].",col11=".$tcol[10].",col12=".$tcol[11].",col13=".$tcol[12].",avg_points=".$avg_points;
		$SQLObj0->RunSQL($str);

		// 30 days
		$str = "SELECT SUM(g) AS tg,SUM(col1) AS tcol1,SUM(col2) AS tcol2,SUM(col3) AS tcol3,SUM(col4) AS tcol4,SUM(col5) AS tcol5,SUM(col6) AS tcol6,SUM(col7) AS tcol7,SUM(col8) AS tcol8,SUM(col9) AS tcol9,SUM(col10) AS tcol10,SUM(col11) AS tcol11,SUM(points) AS tpoints,SUM(pricemove) AS tpricemove FROM player_record_log WHERE player_id=".$id." AND `datetime`>='".$date30." 00:00:00'";
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$tg = $SQLObj0->GetData('TG');
		for($j=0;$j<11;$j++)
		{
			$tcol[$j] = $SQLObj0->GetData('TCOL'.($j+1));
		}
		$tppoints = $SQLObj0->GetData('TPOINTS');
		$tpricemove = $SQLObj0->GetData('TPRICEMOVE');

		//計算統計數據
		if($p)
		{
			$ip = round($tcol[3]+$tcol[4]/3);
			if($ip)
			{				
				//whip
				$tcol[11] = number_format(($tcol[5]+$tcol[7])/$ip,2)*1000;
				//era
				$tcol[12] = number_format($tcol[10]/$ip*9,2)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else 
			{
				$avg_points = 0;
			}
		}
		else
		{
			if($tcol[0])
			{
				//slg
				$tcol[11] = number_format(($tcol[2]+$tcol[3]+$tcol[4]*2)/$tcol[0],3)*1000;
				//avg
				$tcol[12] = number_format($tcol[2]/$tcol[0],3)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else
			{
				$avg_points = 0;
			}
		}
		
		$str = "INSERT INTO player_record_30 SET points=".$tppoints.",pricemove=".$tpricemove.",player_id=".$id.",p=".$p.",c=".$c.",1b=".$fb.",2b=".$fb.",ss=".$ss.",3b=".$tb.",of=".$of.",dh=".$dh.",g=".$tg.",col1=".$tcol[0].",col2=".$tcol[1].",col3=".$tcol[2].",col4=".$tcol[3].",col5=".$tcol[4].",col6=".$tcol[5].",col7=".$tcol[6].",col8=".$tcol[7].",col9=".$tcol[8].",col10=".$tcol[9].",col11=".$tcol[10].",col12=".$tcol[11].",col13=".$tcol[12].",avg_points=".$avg_points;
		$SQLObj0->RunSQL($str);
		
		// 今年
		$str = "SELECT SUM(g) AS tg,SUM(col1) AS tcol1,SUM(col2) AS tcol2,SUM(col3) AS tcol3,SUM(col4) AS tcol4,SUM(col5) AS tcol5,SUM(col6) AS tcol6,SUM(col7) AS tcol7,SUM(col8) AS tcol8,SUM(col9) AS tcol9,SUM(col10) AS tcol10,SUM(col11) AS tcol11,SUM(points) AS tpoints,SUM(pricemove) AS tpricemove FROM player_record_log WHERE player_id=".$id;
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$tg = $SQLObj0->GetData('TG');
		for($j=0;$j<11;$j++)
		{
			$tcol[$j] = $SQLObj0->GetData('TCOL'.($j+1));
		}
		$tppoints = $SQLObj0->GetData('TPOINTS');
		$tpricemove = $SQLObj0->GetData('TPRICEMOVE');

		//計算統計數據
		if($p)
		{
			$ip = round($tcol[3]+$tcol[4]/3);
			if($ip)
			{				
				//whip
				$tcol[11] = number_format(($tcol[5]+$tcol[7])/$ip,2)*1000;
				//era
				$tcol[12] = number_format($tcol[10]/$ip*9,2)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else 
			{
				$avg_points = 0;
			}
		}
		else
		{
			if($tcol[0])
			{
				//slg
				$tcol[11] = number_format(($tcol[2]+$tcol[3]+$tcol[4]*2)/$tcol[0],3)*1000;
				//avg
				$tcol[12] = number_format($tcol[2]/$tcol[0],3)*1000;
			}
			else 
			{
				$tcol[11] = 0;
				$tcol[12] = 0;
			}
			if($tg)
			{
				$avg_points = number_format($tppoints / $tg,1)*1000;
			}
			else
			{
				$avg_points = 0;
			}
		}
		
		$str = "INSERT INTO player_record_2008 SET price=".($price+$tpricemove).",points=".$tppoints.",pricemove=".$tpricemove.",player_id=".$id.",p=".$p.",c=".$c.",1b=".$fb.",2b=".$fb.",ss=".$ss.",3b=".$tb.",of=".$of.",dh=".$dh.",g=".$tg.",col1=".$tcol[0].",col2=".$tcol[1].",col3=".$tcol[2].",col4=".$tcol[3].",col5=".$tcol[4].",col6=".$tcol[5].",col7=".$tcol[6].",col8=".$tcol[7].",col9=".$tcol[8].",col10=".$tcol[9].",col11=".$tcol[10].",col12=".$tcol[11].",col13=".$tcol[12].",avg_points=".$avg_points;
		$SQLObj0->RunSQL($str);
	}
	?>
	<script language="javascript">
	<!--
	alert("7-15-30加總成功");
	//-->
	</script>
	<?
}
?>
<form id="form1" name="form1" method="post" action="">
  <input type="hidden" name="action" value="1">
  <b>本日紀錄加總器 v1.2</b><BR>
  <font color="FFOOOO">注意!!本加總程式必須在每日 rec2db 之後執行!!</font>
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
  <input type="submit" name="Submit" value="開始計算7-15-30" />
</form>