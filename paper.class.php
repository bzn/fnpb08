<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
/*******************************************************************************************
DATE      : 2006/12/15
AUTHOR    : bluezhin
Paper Class 
******************************************************************************************/
class PaperObj{
    //考卷流水號
    var $id			= 0;
    //科目
    var $subject	= '';
    //年級
    var $grade		= '';
    //教材條件(n,k,h,l,e,f)
    var $ver		= '';
    //範圍條件開始
    var $range1		= 0;
    //範圍條件結束
    var $range2		= 0;
    //考試標題
    var $title		= '';
    //考卷難度設定(123,易中難)
    var $level		= 0;
    //題數(所有題目)
    var $Qcount	= 0;
    //題數(有計分的題目)
    var $Qcount2		= 0;
    //設定作答時間
    var $time		= 0;
    //標頭文字
    var $headtext	= '';
    //結尾文字
    var $endtext	= '';
    //題組索引陣列
    var $a_index	= array();
    //題目編號陣列
    var $a_id		= array();
    //題目時間陣列
    var $a_time		= array();
    //題目難度陣列
    var $a_level	= array();
    //題目字串陣列
    var $a_text		= array();
    //題目選項1陣列
    var $a_ans1		= array();
   	//題目選項2陣列
    var $a_ans2		= array();
    //題目選項3陣列
    var $a_ans3		= array();
    //題目選項4陣列
    var $a_ans4		= array();
    //正確答案
    var $a_trueans	= array();
    //你的答案
    //var $a_yourans	= array();
    //配分
    var $a_score	= array();
    //得分
    var $yourscore	= 0;
    
    //============初始所有的變數============//
    function init()
    {
		$this->id			= 0;
    	$this->subject		= '';
    	$this->grade		= '';
    	$this->ver			= '';
	    $this->range1		= 0;
    	$this->range2		= 0;
    	$this->title		= '';
    	$this->level		= 0;
    	$this->Qcount		= 0;
	    $this->Qcount2		= 0;
	    $this->time			= 0;
	    $this->headtext		= '';
		$this->endtext		= '';
		$this->a_index		= array();
    	$this->a_id			= array();
    	$this->a_time		= array();
    	$this->a_level		= array();
		$this->a_text		= array();
		$this->a_ans1		= array();
		$this->a_ans2		= array();
		$this->a_ans3		= array();
		$this->a_ans4		= array();
		$this->a_trueans	= array();
		//$this->a_yourans	= array();
		$this->a_score		= array();
		$this->yourscore	= 0;
    }

    //===============預測落點===============//
    function Score2Pa($SQLObj,$score)
    {
    	//取得總人數
    	$str = "SELECT SUM(count) AS total FROM exm_rec"; 
    	$SQLObj->RunSQL($str);
    	$SQLObj->LinkNext();
    	$all = $SQLObj->GetData('total');
    	//取得比自己分數高的人數
    	$str = "SELECT SUM(count) AS total FROM exm_rec WHERE score >".$score.""; 
    	$SQLObj->RunSQL($str);
    	$SQLObj->LinkNext();
    	$up = $SQLObj->GetData('total');
    	//取得百分比
    	$pa = $up/$all;
    	return $pa;
	}
    
    //===============讀取之前的考卷===============//
    function LoadPaper($SQLObj,$paperid)
    {
    	$this->init();
    	$str = "SELECT * FROM exmlog WHERE id='".$paperid."'";
    	//echo $str;
    	$SQLObj->RunSQL($str);
		if($SQLObj->LinkNext())
		{
			$this->id			= $paperid;
	    	$this->subject		= $SQLObj->GetData('subject');
	    	$this->grade		= $SQLObj->GetData('grade');
	    	$this->title		= iconv("Big5","UTF-8",$SQLObj->GetData('title'));
	    	$this->level		= $SQLObj->GetData('level');
	    	$this->Qcount		= $SQLObj->GetData('qcount');
		    $this->Qcount2		= $SQLObj->GetData('qcount2');
		    $this->time			= $SQLObj->GetData('time');
		    $this->headtext		= iconv("Big5","UTF-8",$SQLObj->GetData('head_text'));
			$this->endtext		= iconv("Big5","UTF-8",$SQLObj->GetData('end_text'));
			$this->a_index		= explode("[&]", iconv("Big5","UTF-8",$SQLObj->GetData('a_index')));
	    	//$this->a_id			= array();
	    	//$this->a_time		= array();
	    	//$this->a_level		= array();
			$this->a_text		= explode("[&]", iconv("Big5","UTF-8",$SQLObj->GetData('a_text')));
			$this->a_ans1		= explode("[&]", iconv("Big5","UTF-8",$SQLObj->GetData('a_ans1')));
			$this->a_ans2		= explode("[&]", iconv("Big5","UTF-8",$SQLObj->GetData('a_ans2')));
			$this->a_ans3		= explode("[&]", iconv("Big5","UTF-8",$SQLObj->GetData('a_ans3')));
			$this->a_ans4		= explode("[&]", iconv("Big5","UTF-8",$SQLObj->GetData('a_ans4')));
			$this->a_trueans	= explode("[&]", $SQLObj->GetData('a_trueans'));
			$this->a_yourans	= explode("[&]", $SQLObj->GetData('a_yourans'));
			$this->a_score		= explode("[&]", $SQLObj->GetData('a_score'));
			$this->yourscore	= $SQLObj->GetData('score');
		}
		else 
			echo "NO PAPER";
    }
    
    //=========算分數,並更新作答和成績資訊==========//
    function Score($SQLObj,$a_yourans,$paperid)
    {
    	$now_score = 100;
    	$str = "SELECT * FROM exmlog where id='".$paperid."'";
    	$SQLObj->RunSQL($str);
		if($SQLObj->LinkNext())
		{
			//解析正確答案
			$a_trueans = explode("[&]", $SQLObj->GetData('a_trueans'));
			//解析配分
			$a_score = explode("[&]", $SQLObj->GetData('a_score'));
			for($i=0;$i<count($a_trueans);$i++)
			{
				//echo $a_trueans[$i]."-".$a_yourans[$i]."<BR>";
				if($a_trueans[$i] != $a_yourans[$i])
					$now_score -= $a_score[$i];
			}
			//echo $now_score;
			$yourans = $a_yourans[0];
			for($i=1;$i<count($a_yourans);$i++)
			{
    			$yourans = $yourans."[&]".$a_yourans[$i];
			}
			$str = "UPDATE exmlog SET yourscore='".$now_score."', a_yourans='".$yourans."' WHERE id='".$paperid."'";
			$SQLObj->RunSQL($str);
			
			//加入統計樣本中
			$str = "UPDATE exm_rec SET count=count+1 WHERE score=".$now_score."";
			$SQLObj->RunSQL($str);
			/*
			for($i=0;$i<count($a_yourans);$i++)
			{
				echo $a_trueans[$i]." - ".$a_yourans[$i]."<BR>";
			}
			*/
			return $now_score;
		}
		else 
		{
			echo "NO PAPER";
		}
    }
    
    //=============儲存考卷,並配分===============//
    function SavePaper($SQLObj)
    {
    	//=================計算配分==================//
    	$total_score = 0;
    	for($i=0,$j=0;$i<$this->Qcount;$i++)
    	{
    		//如果不是題組
    		if($this->a_index[$i]==0)
    		{
    			$this->a_score[$j] = floor($this->a_time[$i] / $this->time * 100);
    			if($this->a_score[$j] < 1)
    				$this->a_score[$j] = 1;
    			$total_score += $this->a_score[$j];
    			//echo $i."(1) - ".$this->a_score[$j]."-".$total_score."<BR>";
    			$j++;
    		}
    		else 
    		{
    			//echo $this->a_time[$i]." / ".$this->time." / ".$this->a_index[$i];
    			$tempscore = floor($this->a_time[$i] / $this->time / $this->a_index[$i] * 100);
    			for($k=0;$k<$this->a_index[$i];$k++)
    			{
    				$this->a_score[$j] = $tempscore;
    				if($this->a_score[$j] < 1)
    					$this->a_score[$j] = 1;
    				$total_score += $this->a_score[$j];
    				//echo $i."(2) - ".$this->a_score[$j]."-".$total_score."<BR>";
    				$j++;
    			}
    			$i += $this->a_index[$i];
    		}
    	}
    	//echo $total_score;
    	$left_score = 100-$total_score;
    	for($i=0;$i<$left_score;$i++)
    	{
    		$this->a_score[$this->Qcount2-1-$i]++;
    	}
    	/*
    	for($i=0;$i<$this->Qcount2;$i++)
    		echo $this->a_score[$i];
    	*/
    	//=====================================//
    	
    	$a_index = $this->a_index[0];
    	$a_text = $this->a_text[0];
    	$a_ans1 = $this->a_ans1[0];
    	$a_ans2 = $this->a_ans2[0];
    	$a_ans3 = $this->a_ans3[0];
    	$a_ans4 = $this->a_ans4[0];
    	for($i=1;$i<$this->Qcount;$i++)
    	{
    		$a_index = $a_index."[&]".$this->a_index[$i];
    		$a_text = $a_text."[&]".$this->a_text[$i];
	    	$a_ans1 = $a_ans1."[&]".$this->a_ans1[$i];
	    	$a_ans2 = $a_ans2."[&]".$this->a_ans2[$i];
	    	$a_ans3 = $a_ans3."[&]".$this->a_ans3[$i];
	    	$a_ans4 = $a_ans4."[&]".$this->a_ans4[$i];
	    	//$yourscore
    	}
    	
    	//答案部分另外處理
    	for($i=0;$i<$this->Qcount;$i++)
    	{
    		//如果剛開頭
    		if(!strlen($a_trueans))
    			$a_score = $this->a_score[$i];
    		else 
    			$a_score = $a_score."[&]".$this->a_score[$i];
    		//如果不是題組
    		if($this->a_index[$i] == 0)
    		{
    			//如果剛開頭
    			if(!strlen($a_trueans))
    			{
    				$a_trueans = $this->a_trueans[$i]; 			    		
    			}
    			else 
    			{
		    		$a_trueans = $a_trueans."[&]".$this->a_trueans[$i]; 			    		
    			}
    		}
    	}
    	
    	//取代字元
    	$a_text = str_replace("'","\'",$a_text);
    	$a_ans1 = str_replace("'","\'",$a_ans1);
    	$a_ans2 = str_replace("'","\'",$a_ans2);
    	$a_ans3 = str_replace("'","\'",$a_ans3);
    	$a_ans4 = str_replace("'","\'",$a_ans4);
    	
    	$str = "INSERT INTO exmlog (id,subject,grade,title,level,time,qcount,qcount2,head_text,end_text,a_index,a_text,a_ans1,a_ans2,a_ans3,a_ans4,a_trueans,a_yourans,a_score,yourscore) 
		    	VALUES ('','".$this->subject."','".$this->grade."','','".$this->level."','".$this->time."','".$this->Qcount."','".$this->Qcount2."','".$this->headtext."','".$this->endtext."','".$a_index."','".$a_text."','".$a_ans1."','".$a_ans2."','".$a_ans3."','".$a_ans4."','".$a_trueans."','','".$a_score."','')";
		    	//echo $str."<BR>";
		    	$str = iconv("UTF-8", "Big5", $str);
				$SQLObj->RunSQL($str);
		return mysql_insert_id();
    }
    
    //============亂數產生整個題庫============//
    function MakePaperByTime($SQLObj)
    {
    	//取得範圍參數
    	$verstr = "ver_".$this->ver;
    	//期望難度加總
    	$lv_wish = 0;
    	//目前難度加總
    	$lv_now = 0;
    	//目前時間加總
    	$nowtime = 0;
    	//已經取得的問題id字串
    	$str2 = '';
    	$i=0;
    	//以難度等級分布考題
    	switch($this->level)
    	{
    		case 1:
    		{
	    		//等級一(易-中-難)1-3-6
	    		$a_range = array(1,2,2,2,3,3,3,3,3,3);
	    		break;
    		}
    		case 2:
    		{
	    		//等級二(易-中-難)2-6-2
	    		$a_range = array(1,1,2,2,2,2,2,2,3,3);
	    		break;
    		}
    		case 3:
    		{
	    		//等級三(易-中-難)6-3-1
	    		$a_range = array(1,1,1,1,1,1,2,2,2,3);
	    		break;
    		}
    	}
    	reset($a_range);
    	//var_dump($a_range);
    	//print_r($a_range);
    	//exit();
    	//echo $this->time;
    	//exit();
    	for($i=0;$nowtime<$this->time;$i++)
    	{  
    		//echo "nowtime=".$nowtime."<BR>";
    		//echo "thistime=".$this->time."<BR>";
    		//目前題號
    		$QNo = $i+1;
    		//計算本次難度範圍
    		$pos = ceil($nowtime/$this->time*9);
    		//echo $pos."<BR>";
    		$level = $a_range[$pos];
			//echo $level."<BR>";
    		//取得在出題範圍內,且難度加總在level左右的題目,並剔除已經取得的問題,並且不是小題
    		if($this->grade === '4')
    		{
    			//隨機取得年級d,f,h
    			$a_grade = array('d','f','h');
    			reset($a_grade);
    			$pos = rand(0,2);
    			$str = "SELECT * FROM exm_".$this->subject.$a_grade[$pos].$range." WHERE level=".$level." ".$str2." AND id2=0 ORDER BY RAND() LIMIT 1";
    		}
    		else
    		{
				$str = "SELECT * FROM exm_".$this->subject.$this->grade." WHERE level=".$level." AND ".$verstr.">=".$this->range1." AND ".$verstr."<=".$this->range2." ".$str2." AND id2=0 ORDER BY RAND() LIMIT 1";
    		}
			//echo $str."<BR>";
			$SQLObj->RunSQL($str);	
	    	if($nrows = $SQLObj->LinkNext())
	    	{
	    		//本題小題數
	    		$this->a_index[$i] = 0;
	    		//*******如果是題組的開始**********//
	    		if($SQLObj->GetData('ans1') === '')
	    		{

	    			//echo 'hi';
	    			//已經取得的問題字串
		    		$this->a_id[$i] = $SQLObj->GetData('id');
		    		$str2 = $str2." AND id<>".$this->a_id[$i]." ";
			    	//取得作答時間
		    		$this->a_time[$i] = $SQLObj->GetData('time');
		    		//如果作答時間還沒爆表
		    		if(($nowtime+$this->a_time[$i]) < $this->time)
		    		{
			    		//目前累計作答時間
			    		$nowtime += $this->a_time[$i];
			    		//取得難度
			    		//$this->a_level = $SQLObj->GetData('level');
				    	
		    			//$this->a_id[$i]			= $SQLObj->GetData('id');
						$this->a_text[$i]		= $SQLObj->GetData('text');
						$this->a_text[$i] = iconv("Big5", "UTF-8", $this->a_text[$i]);
						//echo $this->a_id[$i]." - ".$this->a_text[$i]."<BR>";

		    			//檢查有多少題組
		    			if($this->grade === '4')
			    		{
			    			$str = "SELECT * FROM exm_".$this->subject.$a_grade[$pos].$range." WHERE id2='".$this->a_id[$i]."'";
			    		}
			    		else 
			    		{
		    				$str = "SELECT * FROM exm_".$this->subject.$this->grade." WHERE id2='".$this->a_id[$i]."'";
			    		}
		    			//echo $str;
						$SQLObj->RunSQL($str);	
				    	$nrows = $SQLObj->LinkAll();
				    	//var_dump($SQLObj->Data);
						//exit();
				    	//本題小題數
	    				$this->a_index[$i] = $nrows;

			    		$a_tempid = $SQLObj->GetData('ID');
			    		//紀錄撈過的id
			    		$a_temptext = $SQLObj->GetData('TEXT');
			    		$a_tempans1 = $SQLObj->GetData('ANS1');
			    		$a_tempans2 = $SQLObj->GetData('ANS2');
			    		$a_tempans3 = $SQLObj->GetData('ANS3');
			    		$a_tempans4 = $SQLObj->GetData('ANS4');
			    		$a_tempans5 = $SQLObj->GetData('ANS5');
			    		$a_tempans6 = $SQLObj->GetData('ANS6');
			    		$a_tempans7 = $SQLObj->GetData('ANS7');
			    		$a_tempans8 = $SQLObj->GetData('ANS8');
			    		/*
			    		for($xxx=0;$xxx<$nrows;$xxx++)
			    		{
			    			echo "a_tempans1=".$a_tempans1[$xxx]."<BR>";
			    		}
						*/
			    		//echo "OK啦";
			    		//因為大題組的開頭不算分
			    		//$this->Qcount2++;
			    		$i++;
				    	for($j=0;$j<$nrows;$j++,$i++)
				    	{
				    		//本題小題數
	    					$this->a_index[$i] = 0;
				    		$this->Qcount2++;
				    		//echo "[ ".$i." ]";
				    		//已經取得的問題字串
				    		$this->a_id[$i] = $a_tempid[$j];
				    		//$str2 = $str2." AND id<>".$this->a_id[$i]." ";
					    	//取得作答時間
				    		//$this->a_time[$i] = $SQLObj->GetData('time');
				    		//取得難度
				    		//$this->a_level = $SQLObj->GetData('level');
					    	
			    			//$this->a_id[$i]			= $SQLObj->GetData('id');
							$this->a_text[$i] = $a_temptext[$j];
							$this->a_text[$i] = iconv("Big5", "UTF-8", $this->a_text[$i]);
							//echo $this->a_id[$i]." - ".$this->a_text[$i]."<BR>";
							//取得所有的答案
							//正確和錯誤答案計數
							$Ocount=0;
							$Xcount=0;
							$a_ans[0] = iconv("Big5", "UTF-8",$a_tempans1[$j]);
							$a_ans[1] = iconv("Big5", "UTF-8",$a_tempans2[$j]);
							$a_ans[2] = iconv("Big5", "UTF-8",$a_tempans3[$j]);
							$a_ans[3] = iconv("Big5", "UTF-8",$a_tempans4[$j]);
							$a_ans[4] = iconv("Big5", "UTF-8",$a_tempans5[$j]);
							$a_ans[5] = iconv("Big5", "UTF-8",$a_tempans6[$j]);
							$a_ans[6] = iconv("Big5", "UTF-8",$a_tempans7[$j]);
							$a_ans[7] = iconv("Big5", "UTF-8",$a_tempans8[$j]);
							for($k=0;$k<8;$k++)
							{
								//echo $a_ans[$i]."!";
								//$a_ans[$k] = $a_ans;
								//$a_ans[$k] = iconv("Big5", "UTF-8", $a_ans[$k]);
								$head = substr($a_ans[$k],0,3);
								if($head === '[O]')
								{
									$Oindex[$Ocount] = $a_ans[$k];
									$Ocount++;
								}
								elseif ($head === '[X]')
								{
									$Xindex[$Xcount] = $a_ans[$k];
									$Xcount++;
								}
							}
									
							//取一個正確答案
							if($Ocount>1)
							{
								srand((double)microtime()*1000000);	
								$a_allans[0] = $Oindex[rand(0,$Ocount)];
							}
							else
								$a_allans[0] = $Oindex[0];
							//隨機調換位置n次
							for($k=0;$k<$Xcount;$k++)
							{		
								while(!$Xindex[$tempA])
									$tempA = rand(1,$Xcount);
								while(!$Xindex[$tempB])
									$tempB = rand(1,$Xcount);		
								$temp = $Xindex[$tempA];
								$Xindex[$tempA] = $Xindex[$tempB];
								$Xindex[$tempB] = $temp;
							}
							//取三個錯誤答案
							$a_allans[1] = $Xindex[0];
							$a_allans[2] = $Xindex[1];
							$a_allans[3] = $Xindex[2];
							//答案隨機調換位置
							srand((double)microtime()*1000000);
							$tempA = rand(0,3);
							$temp = $a_allans[0];
							$a_allans[0] = $a_allans[$tempA];
							$a_allans[$tempA] = $temp;
							
							//echo $a_allans[0];
							//echo $a_allans[1];
							//echo $a_allans[2];
							//echo $a_allans[3];
							//echo "<BR>";
							
							$this->a_ans1[$i] = $a_allans[0];
							$this->a_ans2[$i] = $a_allans[1];
							$this->a_ans3[$i] = $a_allans[2];
							$this->a_ans4[$i] = $a_allans[3];
				    	}
				    	$i--;
			    	}
			    	else 
			    	{
			    		//echo "不OK啦";
			    		//容不下題組...重抓一次
			    		$i--;
			    	}

	    		}
	    		else 
	    		{
	    			$this->Qcount2++;
		    		//*******************************//
		    		//已經取得的問題字串
		    		$this->a_id[$i] = $SQLObj->GetData('id');
		    		//時間加總
		    		$nowtime += $SQLObj->GetData('time');
		    		$str2 = $str2." AND id<>".$this->a_id[$i]." ";
			    	//取得作答時間
		    		$this->a_time[$i] = $SQLObj->GetData('time');
		    		//取得難度
		    		$this->a_level = $SQLObj->GetData('level');
			    	
	    			//$this->a_id[$i]			= $SQLObj->GetData('id');
					$this->a_text[$i]		= $SQLObj->GetData('text');
					$this->a_text[$i] = iconv("Big5", "UTF-8", $this->a_text[$i]);
					//echo $this->a_id[$i]." - ".$this->a_text[$i]."<BR>";
					//取得所有的答案
					//正確和錯誤答案計數
					$Ocount=0;
					$Xcount=0;
					for($j=0;$j<8;$j++)
					{
						$a_ans[$j] = $SQLObj->GetData('ans'.($j+1));
						$a_ans[$j] = iconv("Big5", "UTF-8", $a_ans[$j]);
						$head = substr($a_ans[$j],0,3);
						//echo "HEAD=".$head;
						if($head === '[O]')
						{
							$Oindex[$Ocount] = $a_ans[$j];
							//echo "!addO->".$Oindex[$Ocount]."<BR>";
							$Ocount++;
						}
						elseif ($head === '[X]')
						{
							$Xindex[$Xcount] = $a_ans[$j];
							//echo "!addX->".$Xindex[$Xcount]."<BR>";
							$Xcount++;
						}
					}
					//echo "[Ocount]=".$Ocount."[Xcount]=".$Xcount;
							
					//取一個正確答案
					if($Ocount>1)
					{
						srand((double)microtime()*1000000);	
						$a_allans[0] = $Oindex[rand(0,$Ocount-1)];
					}
					else
						$a_allans[0] = $Oindex[0];
					
					//echo "TRUE=".$a_allans[0];	
					/*
					echo "掉換前<BR>";
					echo $Xindex[0]."<BR>";
					echo $Xindex[1]."<BR>";
					echo $Xindex[2]."<BR>";
					echo $Xindex[3]."<BR>";
					echo $Xindex[4]."<BR>";
					echo $Xindex[5]."<BR>";
					echo $Xindex[6]."<BR>";
					echo $Xindex[7]."<BR>";
					*/
					//隨機調換位置n次
					for($j=0;$j<$Xcount;$j++)
					{				
						while(!$Xindex[$tempA])
							$tempA = rand(1,$Xcount);
						while(!$Xindex[$tempB])
							$tempB = rand(1,$Xcount);
						$temp = $Xindex[$tempA];
						$Xindex[$tempA] = $Xindex[$tempB];
						$Xindex[$tempB] = $temp;
					}
					/*
					echo "掉換後<BR>";
					echo $Xindex[0]."<BR>";
					echo $Xindex[1]."<BR>";
					echo $Xindex[2]."<BR>";
					echo $Xindex[3]."<BR>";
					echo $Xindex[4]."<BR>";
					echo $Xindex[5]."<BR>";
					echo $Xindex[6]."<BR>";
					echo $Xindex[7]."<BR>";
					*/
					//取三個錯誤答案
					$a_allans[1] = $Xindex[0];
					$a_allans[2] = $Xindex[1];
					$a_allans[3] = $Xindex[2];
					//echo "[xxx".$a_allans[1]."--".$a_allans[2]."--".$a_allans[3]."xxx]";
					//答案隨機調換位置
					srand((double)microtime()*1000000);
					$tempA = rand(0,3);
					$temp = $a_allans[0];
					$a_allans[0] = $a_allans[$tempA];
					$a_allans[$tempA] = $temp;
					
					//echo "1:".$a_allans[0];
					//echo "2:".$a_allans[1];
					//echo "3:".$a_allans[2];
					//echo "4:".$a_allans[3];
					//echo "<BR>";
					
					$this->a_ans1[$i] = $a_allans[0];
					$this->a_ans2[$i] = $a_allans[1];
					$this->a_ans3[$i] = $a_allans[2];
					$this->a_ans4[$i] = $a_allans[3];
		    	}
	    	}
	    	else 
	    	{
	    		echo "題數不足<BR>";
	    		echo $str;
	    		break;
	    	}
	    	//echo "***********".$this->Qcount2." - ".$i."**************<BR>";
    	}
    	//取得估計作答時間
    	$this->time = $nowtime;
    	
    	$this->Qcount = $i;
    	for($i=0;$i<$this->Qcount;$i++)
    	{
    		if(substr($this->a_ans1[$i],0,3) === '[O]')
    			$this->a_trueans[$i] = 1;
    		elseif(substr($this->a_ans2[$i],0,3) === '[O]')
    			$this->a_trueans[$i] = 2;
    		elseif(substr($this->a_ans3[$i],0,3) === '[O]')
    			$this->a_trueans[$i] = 3;
    		elseif(substr($this->a_ans4[$i],0,3) === '[O]')
    			$this->a_trueans[$i] = 4;
    	}
    }
    
    /*this->Qcount2要矯正
    //============亂數產生整個題庫============//
    function MakePaperByCount($SQLObj)
    {
    	//取得範圍參數
    	$verstr = "ver_".$this->ver;
    	//期望難度加總
    	$lv_wish = 0;
    	//目前難度加總
    	$lv_now = 0;
    	//已經取得的問題id字串
    	$str2 = '';
    	$i=0;
    	//以難度等級分布考題
    	switch($this->level)
    	{
    		case 1:
    		{
	    		//等級一(易-中-難)1-3-6
	    		$a_range = array(1,2,2,2,3,3,3,3,3,3);
	    		break;
    		}
    		case 2:
    		{
	    		//等級二(易-中-難)2-6-2
	    		$a_range = array(1,1,2,2,2,2,2,2,3,3);
	    		break;
    		}
    		case 3:
    		{
	    		//等級三(易-中-難)6-3-1
	    		$a_range = array(1,1,1,1,1,1,2,2,2,3);
	    		break;
    		}
    	}
    	
    	for($i=0;$i<$this->Qcount2;$i++)
    	{  
    		//目前題號
    		$QNo = $i+1;
    		//計算本次難度範圍
    		$level = $a_range[(ceil($QNo/$this->Qcount2*10)-1)];

    		//取得在出題範圍內,且難度加總在level左右的題目,並剔除已經取得的問題,並且不是小題
			$str = "SELECT * FROM exm_".$this->subject.$this->grade." WHERE level=".$this->level." AND ".$verstr.">=".$this->range1." AND ".$verstr."<=".$this->range2." ".$str2." AND id2=0 ORDER BY RAND() LIMIT 1";
			//echo $str."<BR>";
			$SQLObj->RunSQL($str);	
	    	if($nrows = $SQLObj->LinkNext())
	    	{
	    		//============如果是題組的開始=============//
	    		if($SQLObj->GetData('ans1') === '')
	    		{
	    			//echo 'hi';
	    			//已經取得的問題字串
		    		$this->a_id[$i] = $SQLObj->GetData('id');
		    		$str2 = $str2." AND id<>".$this->a_id[$i]." ";
			    	//取得作答時間
		    		$this->a_time[$i] = $SQLObj->GetData('time');
		    		$this->time += $this->a_time[$i];
		    		//取得難度
		    		//$this->a_level = $SQLObj->GetData('level');
			    	
	    			//$this->a_id[$i]			= $SQLObj->GetData('id');
					$this->a_text[$i]		= $SQLObj->GetData('text');
					$this->a_text[$i] = iconv("Big5", "UTF-8", $this->a_text[$i]);
					echo $this->a_id[$i]." - ".$this->a_text[$i]."<BR>";

	    			//檢查有多少題組
	    			$str = "SELECT * FROM exm_".$this->subject.$this->grade." WHERE id2='".$this->a_id[$i]."'";
					$SQLObj->RunSQL($str);	
			    	$nrows = $SQLObj->LinkAll();
			    	//如果可以容得下題組
			    	if($i+$nrows <= $this->Qcount2)
			    	{
			    		$a_tempid = $SQLObj->GetData('id');
			    		$a_temptext = $SQLObj->GetData('text');
			    		$a_tempans1 = $SQLObj->GetData('ans1');
			    		$a_tempans2 = $SQLObj->GetData('ans2');
			    		$a_tempans3 = $SQLObj->GetData('ans3');
			    		$a_tempans4 = $SQLObj->GetData('ans4');
			    		$a_tempans5 = $SQLObj->GetData('ans5');
			    		$a_tempans6 = $SQLObj->GetData('ans6');
			    		$a_tempans7 = $SQLObj->GetData('ans7');
			    		$a_tempans8 = $SQLObj->GetData('ans8');
			    		//echo "OK啦";
			    		//因為大題組的開頭不算分
			    		$this->Qcount2++;
			    		$i++;
				    	for($j=0;$j<$nrows;$j++,$i++)
				    	{
				    		//echo "[ ".$i." ]";
				    		//已經取得的問題字串
				    		$this->a_id[$i] = $a_tempid[$j];
				    		//$str2 = $str2." AND id<>".$this->a_id[$i]." ";
					    	//取得作答時間
				    		//$this->a_time[$i] = $SQLObj->GetData('time');
				    		//取得難度
				    		//$this->a_level = $SQLObj->GetData('level');
					    	
			    			//$this->a_id[$i]			= $SQLObj->GetData('id');
							$this->a_text[$i] = $a_temptext[$j];
							$this->a_text[$i] = iconv("Big5", "UTF-8", $this->a_text[$i]);
							echo $this->a_id[$i]." - ".$this->a_text[$i]."<BR>";
							//取得所有的答案
							//正確和錯誤答案計數
							$Ocount=0;
							$Xcount=0;
							$a_ans[0] = iconv("Big5", "UTF-8",$a_tempans1[$i]);
							$a_ans[1] = iconv("Big5", "UTF-8",$a_tempans2[$i]);
							$a_ans[2] = iconv("Big5", "UTF-8",$a_tempans3[$i]);
							$a_ans[3] = iconv("Big5", "UTF-8",$a_tempans4[$i]);
							$a_ans[4] = iconv("Big5", "UTF-8",$a_tempans5[$i]);
							$a_ans[5] = iconv("Big5", "UTF-8",$a_tempans6[$i]);
							$a_ans[6] = iconv("Big5", "UTF-8",$a_tempans7[$i]);
							$a_ans[7] = iconv("Big5", "UTF-8",$a_tempans8[$i]);
							for($k=0;$k<8;$k++)
							{
								//$a_ans[$k] = $a_ans;
								//$a_ans[$k] = iconv("Big5", "UTF-8", $a_ans[$k]);
								$head = substr($a_ans[$k],0,3);
								if($head === '[O]')
								{
									$Oindex[$Ocount] = $a_ans[$k];
									$Ocount++;
								}
								elseif ($head === '[X]')
								{
									$Xindex[$Xcount] = $a_ans[$k];
									$Xcount++;
								}
							}
									
							//取一個正確答案
							if($Ocount>1)
							{
								srand((double)microtime()*1000000);	
								$a_allans[0] = $Oindex[rand(1,$Ocount)];
							}
							else
								$a_allans[0] = $Oindex[0];
							//隨機調換位置n次
							for($k=0;$k<$Xcount;$k++)
							{				
								$tempA = rand(1,$Xcount);
								$tempB = rand(1,$Xcount);
								$temp = $Xindex[$tempA];
								$Xindex[$tempA] = $Xindex[$tempB];
								$Xindex[$tempB] = $temp;
							}
							//取三個錯誤答案
							$a_allans[1] = $Xindex[0];
							$a_allans[2] = $Xindex[1];
							$a_allans[3] = $Xindex[2];
							//答案隨機調換位置
							srand((double)microtime()*1000000);
							$tempA = rand(1,4);
							$temp = $a_allans[0];
							$a_allans[0] = $a_allans[$tempA];
							$a_allans[$tempA] = $temp;
							
							//echo $a_allans[0];
							//echo $a_allans[1];
							//echo $a_allans[2];
							//echo $a_allans[3];
							
							$this->a_ans1[$i] = $a_allans[0];
							$this->a_ans2[$i] = $a_allans[1];
							$this->a_ans3[$i] = $a_allans[2];
							$this->a_ans4[$i] = $a_allans[3];
				    	}
			    	}
			    	else 
			    	{
			    		//echo "不OK啦";
			    		//容不下題組...重抓一次
			    		$i--;
			    	}
	    		}
	    		else 
	    		{
		    		//已經取得的問題字串
		    		$this->a_id[$i] = $SQLObj->GetData('id');
		    		$str2 = $str2." AND id<>".$this->a_id[$i]." ";
			    	//取得作答時間
		    		$this->a_time[$i] = $SQLObj->GetData('time');
		    		//取得難度
		    		$this->a_level = $SQLObj->GetData('level');
			    	
	    			//$this->a_id[$i]			= $SQLObj->GetData('id');
					$this->a_text[$i]		= $SQLObj->GetData('text');
					$this->a_text[$i] = iconv("Big5", "UTF-8", $this->a_text[$i]);
					echo $this->a_id[$i]." - ".$this->a_text[$i]."<BR>";
					//取得所有的答案
					//正確和錯誤答案計數
					$Ocount=0;
					$Xcount=0;
					for($j=0;$j<8;$j++)
					{
						$a_ans[$j] = $SQLObj->GetData('ans'.($j+1));
						$a_ans[$j] = iconv("Big5", "UTF-8", $a_ans[$j]);
						$head = substr($a_ans[$j],0,3);
						if($head === '[O]')
						{
							$Oindex[$Ocount] = $a_ans[$j];
							$Ocount++;
						}
						elseif ($head === '[X]')
						{
							$Xindex[$Xcount] = $a_ans[$j];
							$Xcount++;
						}
					}
							
					//取一個正確答案
					if($Ocount>1)
					{
						srand((double)microtime()*1000000);	
						$a_allans[0] = $Oindex[rand(1,$Ocount)];
					}
					else
						$a_allans[0] = $Oindex[0];
					//隨機調換位置n次
					for($j=0;$j<$Xcount;$j++)
					{				
						$tempA = rand(1,$Xcount);
						$tempB = rand(1,$Xcount);
						$temp = $Xindex[$tempA];
						$Xindex[$tempA] = $Xindex[$tempB];
						$Xindex[$tempB] = $temp;
					}
					//取三個錯誤答案
					$a_allans[1] = $Xindex[0];
					$a_allans[2] = $Xindex[1];
					$a_allans[3] = $Xindex[2];
					//答案隨機調換位置
					srand((double)microtime()*1000000);
					$tempA = rand(1,4);
					$temp = $a_allans[0];
					$a_allans[0] = $a_allans[$tempA];
					$a_allans[$tempA] = $temp;
					
					//echo $a_allans[0];
					//echo $a_allans[1];
					//echo $a_allans[2];
					//echo $a_allans[3];
					
					$this->a_ans1[$i] = $a_allans[0];
					$this->a_ans2[$i] = $a_allans[1];
					$this->a_ans3[$i] = $a_allans[2];
					$this->a_ans4[$i] = $a_allans[3];
		    	}
	    	}
    	}
    }
    */
}
?>