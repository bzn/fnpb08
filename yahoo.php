<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php

if($_POST['action'] == 1)
{
	//include_once(dirname(__FILE__)."/connect.php");
	//include(dirname(__FILE__)."/quest.class.php");
	
	$filename = $file;
	$fd = fopen( $filename, "r" );
	$str = fread($fd, filesize($filename));
	
	$str = iconv("EUC-JP", "UTF-8", $str);
	//echo $str;
	//exit();
	//$str = "<TITLE>Yahoo!プロ野球 - 2007年10月1日 横浜vs.ヤクルト 成績</TITLE>";
	
	//解析日期
	$pos = strpos($str,"2006年");
	$pos2 = strpos($str,"日",$pos);
	$datestr = substr($str,$pos,$pos2-$pos+3);
	$pos = strpos($datestr,"年");
	$yy = substr($datestr,0,$pos);
	$datestr = substr($datestr,$pos+3);
	echo $yy."<BR>";
	$pos = strpos($datestr,"月");
	$mm = substr($datestr,0,$pos);
	$datestr = substr($datestr,$pos+3);
	echo $mm."<BR>";
	$pos = strpos($datestr,"日");
	$dd = substr($datestr,0,$pos);
	echo $dd."<BR>";
	//exit();

	//解析對戰隊伍
	$pos = strpos($str,"日 ");
	$pos2 = strpos($str," 成績",$pos);
	$teamstr = substr($str,$pos+4,$pos2-$pos-4);
	$a_teamstr = explode("vs.",$teamstr);
	//後攻
	echo $a_teamname[0]."<BR>";
	//先攻
	echo $a_teamname[1]."<BR>";
	
	//取得兩隊選手資料
	//先攻
	$pos = strpos($str,"http://baseball.yahoo.co.jp/npb/player");
	$tempstr = substr($str,0,$pos);
	$pos2 = strrpos($tempstr,"<TR");
	$playerstr = substr($str,$pos2);
	$pos = strpos($playerstr,"後攻");
	$tempstr = substr($playerstr,0,$pos);
	//尋找最後一次的</TR
	$pos2 = strrpos($tempstr,"</TR>");
	$a_teamstr[0] = substr($playerstr,0,$pos2);
	//echo $a_teamstr[0];
	//尋找最後一次的</TR
	$pos3 = strrpos($playerstr,"</TR>");
	$a_teamstr[1] = substr($playerstr,$pos2,$pos3);
	//echo $a_teamstr[1];
	//exit();
	
	//先攻野手
	//先攻投手
	//後攻野手
	//後攻投手
	
	//取出選手資料
	while(true)
	{
		$pos = strpos($playerstr,"http://baseball.yahoo.co.jp/npb/player");
		if($pos == false)
		{
			echo 'no';
			break;
		}
		echo $pos."<BR>";
		$pos2 = strpos($playerstr,"</TR>",$pos);
		echo $pos2."<BR>";
		//exit();
		$playerstr = substr($playerstr,$pos-74,$pos2-$pos+74);
		echo $playerstr;
		exit();
		//裁切
		$playerstr = substr($playerstr,$pos2-$pos);
	}
	//解析投手
	
	//解析打者
	
	//解析比數
	
	exit();
	
	//尋找下一個難度標頭
	//正在檢查的位置
	$nowpos = 1;
	//字數計算器
	$count = 0;
	//產生的題數
	$Qcount = 0;
	//題目序號
	$Qid = 0;
	while(true)
	{
		//尋找下一次的答案標頭
		$nextmarkpos = strpos($contents,'[',$nowpos);
		//echo $nextmark;
		//如果沒有標頭了
		if($nextmarkpos == false)
		{
			//echo $contents."<BR>";
			//$str = substr($contents,0,$count);
			//取得這一個標頭
			$mark = substr($contents,0,3);
			//如果是小題的話
			if (ereg('^[+@[!]+]', $mark))
			{
				//取得大題題號填入DB
				echo $QuestObj->analysis($_POST['textfield'],$contents,0,$Qid);
				$QuestObj->QtoDB($SQLObj0);
			}
			else 
			{
				//填入DB
				echo $QuestObj->analysis($_POST['textfield'],$contents,0,0);
				$QuestObj->QtoDB($SQLObj0);
			}
			$Qcount++;
			break;
		}
		else 
		{
			//取得字數
			$count = intval($nextmarkpos);
		}
		
		//取得下一個標頭
		$nextmark = substr($contents,$count,3);
		//echo $mark;
		//如果下一個是難度標頭或小題標頭
		if (ereg('^[+@[0-9\!]+]', $nextmark))
		{
			//echo $contents."<BR>";
			//取得這行題目
			$str = substr($contents,0,$count);
			//取得這一個標頭
			$mark = substr($contents,0,3);
			//如果是小題的話
			if (ereg('^[+@[!]+]', $mark))
			{
				//取得大題題號填入DB
				echo $QuestObj->analysis($_POST['textfield'],$str,0,$Qid);
				$QuestObj->QtoDB($SQLObj0);
			}
			else 
			{
				//填入DB並取得題號
				echo $QuestObj->analysis($_POST['textfield'],$str,0,0);
				$Qid = $QuestObj->QtoDB($SQLObj0);
			}
			//裁切
			$contents = substr($contents, $count, strlen($contents)-$count);
			//矯正
			$nowpos = 1;
			$count = 0;
			$Qcount++;
		}
		else 
		{
			$nowpos = $count+1;
		}
	}
	echo "<BR>新增了".$Qcount."筆題目(含小題)";
	fclose( $fd );
}
?>

<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="">
<input type="hidden" name="action" value="1">
<label></label>
<br />
  <label>
  <input type="file" name="file" />
  <br />
  <input type="submit" name="Submit" value="傳至db" />
  </label>
</form>
