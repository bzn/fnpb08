<?php
class PlayerBaseObj{
	//球員編號
	var $id			= 0;
	//球員姓名縮寫
	var $name		= '';
	//球員姓名
	var $name_2		= '';
	//隊伍編號
	var $teamid		= 0;
	//隊伍名稱1
	var $teamname	= '';
	//隊伍名稱2
	var $teamname_2	= '';
	//隊伍名稱3
	var $teamname_3	= '';
	//下次對戰隊伍
	var $next		= '';
	//背號
	var $no			= 0;
	//生日
	var $birth		= '';
	//取得左右手
	var $pitch		= '';
	var $bat		= '';
	//取得價錢
	var $price		= 0;
	//取得守備位置
	var $P			= false;
	var $C			= false;
	var $FB			= false;
	var $SB			= false;
	var $SS			= false;
	var $TB			= false;
	var $OF			= false;
	var $DH			= false;
	
	function init()
	{
		$this->id			= 0;
		$this->name			= '';
		$this->name_2		= '';
		$this->teamid		= 0;
		$this->teamname		= '';
		$this->teamname_2	= '';
		$this->teamname_3	= '';
		$this->next			= '';
		$this->no			= 0;
		$this->birth		= '';
		$this->pitch		= '';
		$this->bat			= '';
		$this->price		= 0;
		$this->P			= false;
		$this->C			= false;
		$this->FB			= false;
		$this->SB			= false;
		$this->SS			= false;
		$this->TB			= false;
		$this->OF			= false;
		$this->DH			= false;
	}
	function GetData($SQLObj0,$id)
	{
		$this->id = $id;
		//取得隊伍編號
		$str = "SELECT * FROM team_index WHERE player_id='".$id."'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			$this->teamid	= $SQLObj0->GetData('TEAM_ID');
		//取得隊伍名稱
		$str = "SELECT * FROM team_data WHERE id='".$a_player['teamid']."'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$this->teamname = $SQLObj0->GetData('NAME');	
			$this->teamname_2 = $SQLObj0->GetData('NAME_2');
			$this->teamname_3 = $SQLObj0->GetData('NAME_3');
		}
		//取得下次對戰隊伍
		//....
		
		//取得球員姓名
		$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
		//echo $str;
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$this->name = $SQLObj0->GetData('NAME');
		$this->name_2 = $SQLObj0->GetData('NAME_2');
		//取得背號
		$this->no = $SQLObj0->GetData('NO');
		//取得生日
		$this->birth = $SQLObj0->GetData('BIRTH');
		//取得左右手
		$this->pitch = $SQLObj0->GetData('PITCH');
		$this->bat = $SQLObj0->GetData('BAT');
		//取得價錢
		$this->price = $SQLObj0->GetData('PRICE');
		//取得守備位置
		$this->P = $SQLObj0->GetData('P');
		$this->C = $SQLObj0->GetData('C');
		$this->FB = $SQLObj0->GetData('1B');
		$this->SB = $SQLObj0->GetData('2B');
		$this->SS = $SQLObj0->GetData('SS');
		$this->TB = $SQLObj0->GetData('3B');
		$this->OF = $SQLObj0->GetData('OF');
		$this->DH = $SQLObj0->GetData('DH');
	}
}

class PlayerRecObj{
	var $id			= 0;
	var $g			= 0;
	var $a_col		= array();
	var $whip		= 0;
	var $era		= 0;
	var $slg		= 0;
	var $avg		= 0;
	var $tol_p		= 0;
	var $avg_p		= 0;
	var $yes_p		= 0;
	var $picher		= FALSE;
	
	function init()
	{
		$this->id			= 0;
		$this->g			= 0;
		$this->a_col		= array();
		$this->whip			= 0;
		$this->era			= 0;
		$this->slg			= 0;
		$this->avg			= 0;
		$this->tol_p		= 0;
		$this->avg_p		= 0;
		$this->yes_p		= 0;
		$picher		= FALSE;
	}
	function GetPlayerDataByYear($SQLObj0,$id,$year)
	{
		$this->id = $id;
		$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		//取得守備位置
		$this->picher = $SQLObj0->GetData('P');
		
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
			$this->g = $SQLObj0->GetData('G');
			for($i=1;$i<12;$i++)
				$this->a_col[$i] = $SQLObj0->GetData('COL'.$i);
			
			if($this->picher)
			{	
				//計算統計數據
				$ip = round($this->a_col[4]+$this->a_col[5]/3);
				if($ip)
				{
					$this->whip = number_format(($this->a_col[6]+$this->a_col[8])/$ip,2);
					$this->era = number_format($this->a_col[11]/$ip*9,2);
				}
	
				$this->tol_p = $this->a_col[1]*30-$this->a_col[2]*15+$this->a_col[3]*30+$this->a_col[4]*15+$this->a_col[5]*5-$this->a_col[6]*5-$this->a_col[8]*3+$this->a_col[9]*3-$this->a_col[11]*10;
				$this->avg_p = number_format($this->tol_p / $this->g,1);
			}
			else 
			{
				if($this->a_col[1])
				{
					$this->slg = number_format(($this->a_col[3]+$this->a_col[4]+$this->a_col[5]*2+$a_player['col6']*3)/$this->a_col[1],3);
					$this->avg = number_format($this->a_col[3]/$this->a_col[1],3);
				}
				else 
				{
					$this->slg = 0;
					$this->avg = 0;
				}
	
				$this->tol_p = ($this->a_col[1]-$this->a_col[3])*(-2)+$this->a_col[2]*5+$this->a_col[3]*5+$this->a_col[4]*5+$this->a_col[5]*10+$this->a_col[6]*15+$this->a_col[7]*5+$this->a_col[8]*10+$this->a_col[9]*3-$this->a_col[10];
				$this->avg_p = number_format($this->tol_p / $this->g,1);
			}
			//取得昨日成績
			$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-1,gmdate("Y"));
			$yesterday = gmdate("Y-m-d",$mktime);
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$yesterday." 00:00:00' AND `datetime`<='".$yesterday." 24:00:00'";
			$SQLObj0->RunSQL($str);
			if($SQLObj0->LinkNext())
			{
				for($j=1;$j<12;$j++)
					$tmp_col['col'.$j] = $SQLObj0->GetData('COL'.$j);
				if($this->picher)
					$this->yes_p = $tmp_col['col1']*30-$tmp_col['col2']*15+$tmp_col['col3']*30+$tmp_col['col4']*15+$tmp_col['col5']*5-$tmp_col['col6']*5-$tmp_col['col8']*3+$tmp_col['col9']*3-$tmp_col['col11']*10;
				else 
					$this->yes_p = ($tmp_col['col1']-$tmp_col['col3'])*(-2)+$tmp_col['col2']*5+$tmp_col['col3']*5+$tmp_col['col4']*5+$tmp_col['col5']*10+$tmp_col['col6']*15+$tmp_col['col7']*5+$tmp_col['col8']*10+$tmp_col['col9']*3-$tmp_col['col10'];
			}
		}
	}
	
	//取得球員資料
	function GetPlayerDataByDate($SQLObj0,$id,$date)
	{
		$this->id = $id;
		$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		//取得守備位置
		$this->picher = $SQLObj0->GetData('P');
	
		//依時間條件取得球員資料
		$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 24:00:00'";
	
		$SQLObj0->RunSQL($str);
		$nrows = $SQLObj0->LinkAll();
		if($nrows)
		{
			$a_g = $SQLObj0->GetData('G');
			
			for($i=0;$i<11;$i++)
				$tmp_col[$i] = $SQLObj0->GetData('COL'.($i+1));
				
			for($i=0;$i<$nrows;$i++)
			{
				$g += $a_g[$i];
			}
			for($i=0;$i<11;$i++)
			{
				for($j=0;$j<$nrows;$j++)
					$col[$i] += $tmp_col[$i][$j];
			}
			$this->g = $g;
			//echo "G=".$a_player[$i]['g'];
			for($i=0;$i<11;$i++)
				$this->a_col[($i+1)] = $col[$i];
			/*	
			$this->g = $SQLObj0->GetData('G');
			//echo "G=".$a_player[$i]['g'];
			for($j=1;$j<12;$j++)
				$a_player['col'.$j] = $SQLObj0->GetData('COL'.$j);
			*/	
			//計算統計數據
			if($this->picher)
			{
				$this->whip = number_format(($this->a_col[6]+$this->a_col[8])/($this->a_col[4].".".$this->a_col[5]),2);
				$ip = round($this->a_col[4]+$this->a_col[5]/3);
				$this->era = number_format($this->a_col[11]/$ip*9,2);
				//$this->yes_p
				$this->tol_p = $this->a_col[1]*30-$this->a_col[2]*15+$this->a_col[3]*30+$this->a_col[4]*15+$this->a_col[5]*5-$this->a_col[6]*5-$this->a_col[8]*3+$this->a_col[9]*3-$this->a_col[11]*10;
				$this->avg_p = number_format($this->tol_p / $this->g,1);
			}
			else
			{
				$this->slg = number_format(($this->a_col[3]+$this->a_col[4]+$this->a_col[5]*2+$a_player['col6']*3)/$this->a_col[1],3);
				$this->avg = number_format($this->a_col[3]/$this->a_col[1],3);
				//$this->yes_p
				$this->tol_p = ($this->a_col[1]-$this->a_col[3])*(-2)+$this->a_col[2]*5+$this->a_col[3]*5+$this->a_col[4]*5+$this->a_col[5]*10+$this->a_col[6]*15+$this->a_col[7]*5+$this->a_col[8]*10+$this->a_col[9]*3-$this->a_col[10];
				$this->avg_p = number_format($this->tol_p / $this->g,1);
			}
			//取得昨日成績
			$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-1,gmdate("Y"));
			$yesterday = gmdate("Y-m-d",$mktime);
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$yesterday." 00:00:00' AND `datetime`<='".$yesterday." 24:00:00'";
			$SQLObj0->RunSQL($str);
			if($SQLObj0->LinkNext())
			{
				for($j=1;$j<12;$j++)
					$tmp_col['col'.$j] = $SQLObj0->GetData('COL'.$j);
				if($this->picher)
					$this->yes_p = $tmp_col['col1']*30-$tmp_col['col2']*15+$tmp_col['col3']*30+$tmp_col['col4']*15+$tmp_col['col5']*5-$tmp_col['col6']*5-$tmp_col['col8']*3+$tmp_col['col9']*3-$tmp_col['col11']*10;
				else 
					$this->yes_p = ($tmp_col['col1']-$tmp_col['col3'])*(-2)+$tmp_col['col2']*5+$tmp_col['col3']*5+$tmp_col['col4']*5+$tmp_col['col5']*10+$tmp_col['col6']*15+$tmp_col['col7']*5+$tmp_col['col8']*10+$tmp_col['col9']*3-$tmp_col['col10'];
			}
		}
	}
	
	//取得球員資料
	function GetPlayerDataByPeri($SQLObj0,$id,$peri)
	{
		$this->id = $id;
		$str = "SELECT * FROM player_base_data WHERE id='".$id."'";
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		//取得守備位置
		$this->picher = $SQLObj0->GetData('P');
	
		//依時間條件取得球員資料
		switch ($peri)
		{
			case 1:
			{
				$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-1,gmdate("Y"));
				$yesterday = gmdate("Y-m-d",$mktime);
				$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$yesterday." 00:00:00' AND `datetime`<='".$yesterday." 24:00:00'";
				break;
			}
			case 7:
			{
				$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-7,gmdate("Y"));
				$oldday = gmdate("Y-m-d",$mktime)." 00:00:00";
				$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-1,gmdate("Y"));
				$yesterday = gmdate("Y-m-d",$mktime)." 24:00:00";
				$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$oldday."' AND `datetime`<='".$yesterday."'";
				break;	
			}
			case 15:
			{
				$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-15,gmdate("Y"));
				$oldday = gmdate("Y-m-d",$mktime)." 00:00:00";
				$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-1,gmdate("Y"));
				$yesterday = gmdate("Y-m-d",$mktime)." 24:00:00";
				$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$oldday."' AND `datetime`<='".$yesterday."'";
				break;
			}
			case 30:
			{
				$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-30,gmdate("Y"));
				$oldday = gmdate("Y-m-d",$mktime)." 00:00:00";
				$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-1,gmdate("Y"));
				$yesterday = gmdate("Y-m-d",$mktime)."24:00:00";
				$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$oldday."' AND `datetime`<='".$yesterday."'";
				break;
			}
			case 365:
			{
				$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'";
				break;
			}
		}
		$SQLObj0->RunSQL($str);
		$nrows = $SQLObj0->LinkAll();
		if($nrows)
		{
			$a_g = $SQLObj0->GetData('G');
			
			for($i=0;$i<11;$i++)
				$tmp_col[$i] = $SQLObj0->GetData('COL'.($i+1));
				
			for($i=0;$i<$nrows;$i++)
			{
				$g += $a_g[$i];
			}
			for($i=0;$i<11;$i++)
			{
				for($j=0;$j<$nrows;$j++)
					$col[$i] += $tmp_col[$i][$j];
			}
			$this->g = $g;
			//echo "G=".$a_player[$i]['g'];
			for($i=0;$i<11;$i++)
				$this->a_col[($i+1)] = $col[$i];
				
			//計算統計數據
			if($this->picher)
			{
				$this->whip = number_format(($this->a_col[6]+$this->a_col[8])/($this->a_col[4].".".$this->a_col[5]),2);
				$ip = round($this->a_col[4]+$this->a_col[5]/3);
				$this->era = number_format($this->a_col[11]/$ip*9,2);
				//$this->yes_p
				$this->tol_p = $this->a_col[1]*30-$this->a_col[2]*15+$this->a_col[3]*30+$this->a_col[4]*15+$this->a_col[5]*5-$this->a_col[6]*5-$this->a_col[8]*3+$this->a_col[9]*3-$this->a_col[11]*10;
				$this->avg_p = number_format($this->tol_p / $this->g,1);
			}
			else
			{
				$this->slg = number_format(($this->a_col[3]+$this->a_col[4]+$this->a_col[5]*2+$a_player['col6']*3)/$this->a_col[1],3);
				$this->avg = number_format($this->a_col[3]/$this->a_col[1],3);
				//$this->yes_p
				$this->tol_p = ($this->a_col[1]-$this->a_col[3])*(-2)+$this->a_col[2]*5+$this->a_col[3]*5+$this->a_col[4]*5+$this->a_col[5]*10+$this->a_col[6]*15+$this->a_col[7]*5+$this->a_col[8]*10+$this->a_col[9]*3-$this->a_col[10];
				$this->avg_p = number_format($this->tol_p / $this->g,1);
			}
			//取得昨日成績
			$mktime = gmmktime(0,0,0,gmdate("m"),gmdate("d")-1,gmdate("Y"));
			$yesterday = gmdate("Y-m-d",$mktime);
			$str = "SELECT * FROM player_record_log WHERE player_id='".$id."'  AND `datetime`>='".$yesterday." 00:00:00' AND `datetime`<='".$yesterday." 24:00:00'";
			$SQLObj0->RunSQL($str);
			if($SQLObj0->LinkNext())
			{
				for($j=1;$j<12;$j++)
					$tmp_col['col'.$j] = $SQLObj0->GetData('COL'.$j);
				if($this->picher)
					$this->yes_p = $tmp_col['col1']*30-$tmp_col['col2']*15+$tmp_col['col3']*30+$tmp_col['col4']*15+$tmp_col['col5']*5-$tmp_col['col6']*5-$tmp_col['col8']*3+$tmp_col['col9']*3-$tmp_col['col11']*10;
				else 
					$this->yes_p = ($tmp_col['col1']-$tmp_col['col3'])*(-2)+$tmp_col['col2']*5+$tmp_col['col3']*5+$tmp_col['col4']*5+$tmp_col['col5']*10+$tmp_col['col6']*15+$tmp_col['col7']*5+$tmp_col['col8']*10+$tmp_col['col9']*3-$tmp_col['col10'];
			}
		}
	}
}

class PlayerObj{
	var $BaseData;
	var $Day1;
	var $Day7;
	var $Day15;
	var $Day30;
	var $Day365;
	function init()
	{
		$this->BaseData = new PlayerBaseObj();
		$this->Day1		= new PlayerRecObj();
		$this->Day7		= new PlayerRecObj();
		$this->Day15	= new PlayerRecObj();
		$this->Day30	= new PlayerRecObj();
		$this->Day365	= new PlayerRecObj();
	}
}

class MyTeamObj{
	//隊伍編號
	var $teamid		= 0;
	//隊伍名稱
	var $teamname	= '';
	//所剩現金
	var $cash		= 0;
	//投手交易次數
	var $trade_1	= 0;
	//野手交易次數
	var $trade_2	= 0;
	//擁有選手編號
	var $pos		= array();

	//============初始所有的變數============//
    function init()
    {
    	$this->teamid		= 0; 	
		$this->teamname		= '';
		$this->cash			= 0;
		$this->trade_1		= 0;
		$this->trade_2		= 0;
		$this->pos			= array();
    }
    //投手,野手排序
    function Sort($SQLObj0)
    {
    	//排序投手(0-4)
    	$flag=1;
    	$max=5;
    	for($i=0;$i<$max;$i++)
    	{
    		$a_price[$i] = GetPlayerPrice($SQLObj0,$this->pos[$i]);
    	}
    	for($i=0;$i<$max-1&&$flag==1;$i++) 
    	{
			$flag = 0;
			for($j=0;$j<$max-$i-1;$j++) 
    	    {
    		   	if($a_price[$j+1] > $a_price[$j]) 
    		   	{
    		    	//SWAP(number[j+1], number[j]);		    	
    		    	$temp = $a_price[$j];
    		    	$a_price[$j] = $a_price[$j+1];
    		    	$a_price[$j+1] = $temp;
    		    	
    		    	$temp = $this->pos[$j];
    		    	$this->pos[$j] = $this->pos[$j+1];
    		    	$this->pos[$j+1] = $temp;
    		  
    		        $flag = 1;
    		    }
    		} 
    	}
    	
    	//排序野手(10-12)
    	$flag=1;
    	$max=3;
    	for($i=0;$i<$max;$i++)
    	{
    		$a_price[$i] = GetPlayerPrice($SQLObj0,$this->pos[$i+10]);
    	}
    	for($i=0;$i<$max-1&&$flag==1;$i++) 
    	{
			$flag = 0;
			for($j=0;$j<$max-$i-1;$j++) 
    	    {
    		   	if($a_price[$j+1] > $a_price[$j]) 
    		   	{
    		    	//SWAP(number[j+1], number[j]);		    	
    		    	$temp = $a_price[$j];
    		    	$a_price[$j] = $a_price[$j+1];
    		    	$a_price[$j+1] = $temp;
    		    	
    		    	$temp = $this->pos[$j+10];
    		    	$this->pos[$j+10] = $this->pos[$j+1+10];
    		    	$this->pos[$j+1+10] = $temp;
    		  
    		        $flag = 1;
    		    }
    		} 
    	}
    }
    //取得球隊編號
    function GetTeamID($SQLObj0,$userid)
    {
    	$str = "SELECT * FROM myteam_index WHERE user_id='".$userid."'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			return $SQLObj0->GetData('MYTEAM_ID');
		}
    }
     //取得隊伍資訊
    function GetDataByDate($SQLObj0,$teamid,$date)
    {
    	$str = "SELECT * FROM myteam_score_log WHERE teamid='".$teamid."' AND `datetime`>='".$date." 00:00:00' AND `datetime`<='".$date." 24:00:00'";
    	//echo $str;
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$this->teamid = $teamid;
			//$this->teamname = $SQLObj0->GetData('NAME');
			$this->cash = $SQLObj0->GetData('CASH');
			$this->trade_1 = $SQLObj0->GetData('TRADE_1');
			$this->trade_2 = $SQLObj0->GetData('TRADE_2');
			$this->pos[0] = $SQLObj0->GetData('P1');
			$this->pos[1] = $SQLObj0->GetData('P2');
			$this->pos[2] = $SQLObj0->GetData('P3');
			$this->pos[3] = $SQLObj0->GetData('P4');
			$this->pos[4] = $SQLObj0->GetData('P5');
			$this->pos[5] = $SQLObj0->GetData('C');
			$this->pos[6] = $SQLObj0->GetData('1B');
			$this->pos[7] = $SQLObj0->GetData('2B');
			$this->pos[8] = $SQLObj0->GetData('SS');
			$this->pos[9] = $SQLObj0->GetData('3B');
			$this->pos[10] = $SQLObj0->GetData('OF1');
			$this->pos[11] = $SQLObj0->GetData('OF2');
			$this->pos[12] = $SQLObj0->GetData('OF3');
			$this->pos[13] = $SQLObj0->GetData('DH');
		}
    }
    //取得隊伍資訊
    function GetData($SQLObj0,$teamid)
    {
    	$str = "SELECT * FROM myteam_data WHERE id='".$teamid."'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$this->teamid = $teamid;
			$this->teamname = $SQLObj0->GetData('NAME');
			$this->cash = $SQLObj0->GetData('CASH');
			$this->trade_1 = $SQLObj0->GetData('TRADE_1');
			$this->trade_2 = $SQLObj0->GetData('TRADE_2');
			$this->pos[0] = $SQLObj0->GetData('P1');
			$this->pos[1] = $SQLObj0->GetData('P2');
			$this->pos[2] = $SQLObj0->GetData('P3');
			$this->pos[3] = $SQLObj0->GetData('P4');
			$this->pos[4] = $SQLObj0->GetData('P5');
			$this->pos[5] = $SQLObj0->GetData('C');
			$this->pos[6] = $SQLObj0->GetData('1B');
			$this->pos[7] = $SQLObj0->GetData('2B');
			$this->pos[8] = $SQLObj0->GetData('SS');
			$this->pos[9] = $SQLObj0->GetData('3B');
			$this->pos[10] = $SQLObj0->GetData('OF1');
			$this->pos[11] = $SQLObj0->GetData('OF2');
			$this->pos[12] = $SQLObj0->GetData('OF3');
			$this->pos[13] = $SQLObj0->GetData('DH');
		}
    }
    //新增球員
    function AddPlayer($SQLObj0,$id,$pos)
    {
		//檢查陣中是否已經有此球員
		for($i=0;$i<14;$i++)
		{
			if($this->pos[$i] == $id)
				return '您的隊伍中已經有這名球員';
		}
    	//檢查有無空位
    	$space = FALSE;
    	//echo $pos;
    	switch($pos)
    	{
    		case 'P':
			{
				for($i=0;$i<5;$i++)
				{
					//如果是空的
					if(!$this->pos[$i])
					{
						$space = TRUE;
						$i_pos = $i;
						break;
					}
				}
				break;
			}
			case 'C':
			{
				//如果是空的
				if(!$this->pos[5])
				{
					$space = TRUE;
					$i_pos = 5;
					break;
				}
				break;
			}
			case '1B':
			{
				//如果是空的
				if(!$this->pos[6])
				{
					$space = TRUE;
					$i_pos = 6;
					break;
				}
				break;
			}
			case '2B':
			{
				//如果是空的
				if(!$this->pos[7])
				{
					$space = TRUE;
					$i_pos = 7;
					break;
				}
				break;
			}
			case 'SS':
			{
				//如果是空的
				if(!$this->pos[8])
				{
					$space = TRUE;
					$i_pos = 8;
					break;
				}
				break;
			}
			case '3B':
			{
				//如果是空的
				if(!$this->pos[9])
				{
					$space = TRUE;
					$i_pos = 9;
					break;
				}
				break;
			}
			case 'OF':
			{
				for($i=10;$i<13;$i++)
				{
					//如果是空的
					if(!$this->pos[$i])
					{
						$space = TRUE;
						$i_pos = $i;
						break;
					}
				}
				break;
			}
			case 'DH':
			{
				//如果是空的
				if(!$this->pos[13])
				{
					$space = TRUE;
					$i_pos = 13;
					break;
				}
				break;
			}
			default:
			{
				$str = "SELECT * FROM player_base_data WHERE id=".$id;
				$SQLObj0->RunSQL($str);
				$SQLObj0->LinkNext();
				//取得所有的守備位置
				if($SQLObj0->GetData('P'))
				{
					for($i=0;$i<5;$i++)
					{
						//如果是空的
						if(!$this->pos[$i])
						{
							$space = TRUE;
							$i_pos = $i;
							break;
						}
					}
				}
				else
				{
					//如果是空的
					if($SQLObj0->GetData('C') && !$this->pos[5])
					{
						$space = TRUE;
						$i_pos = 5;
						break;
					}
					if($SQLObj0->GetData('1B') && !$this->pos[6])
					{
						$space = TRUE;
						$i_pos = 6;
						break;
					}
					if($SQLObj0->GetData('2B') && !$this->pos[7])
					{
						$space = TRUE;
						$i_pos = 7;
						break;
					}
					if($SQLObj0->GetData('SS') && !$this->pos[8])
					{
						$space = TRUE;
						$i_pos = 8;
						break;
					}
					if($SQLObj0->GetData('3B') && !$this->pos[9])
					{
						$space = TRUE;
						$i_pos = 9;
						break;
					}
					if($SQLObj0->GetData('OF'))
					{
						for($i=10;$i<13;$i++)
						{
							//如果是空的
							if(!$this->pos[$i])
							{
								$space = TRUE;
								$i_pos = $i;
								break;
							}
						}
					}
					if($SQLObj0->GetData('DH') && !$this->pos[13])
					{
						$space = TRUE;
						$i_pos = 13;
						break;
					}
				}
				break;
			}
    	}
    	//echo "POS=".$pos;
    	if(!$space)
    		return '您的球隊已無空位可購入此球員';
    		
    	//檢查球員有無這個守備位置
    	$str = "SELECT * FROM player_base_data WHERE id = '".$id."'";
    	//echo $str;
		$SQLObj0->RunSQL($str);
		$nows = $SQLObj0->LinkNext();

		if($pos)
		{
			if(!$SQLObj0->GetData($pos))
				return '您要購買的球員不能防守這個位置';
		}
			
    	//取得球員價錢
    	$price = GetPlayerPrice($SQLObj0,$id);
		//檢查餘額是否足夠
		if($this->cash >= $price)
		{
			$this->pos[$i_pos] = $id;
			$this->cash -= $price;
			return;
		}
    	return '您的球隊無法負擔此球員費用';
    }
    //移除球員
    function DelPlayer($SQLObj0,$id)
    {
    	//是否為投手
    	$picher = IsPicher($SQLObj0,$id);
    	//echo $pitcher
    	if($picher)
    	{
    		//檢查交易次數
    		if(!$this->trade_1)
    			return '交易次數不足';
    	}
    	else
    	{
    		//檢查交易次數
    		if(!$this->trade_2)
    			return '交易次數不足';
    	}
		//取得球員價錢
    	$price = GetPlayerPrice($SQLObj0,$id);
		//清除該球員
		$delOK = FALSE;
		for($i=0;$i<14;$i++)
		{
			if($this->pos[$i] == $id)
			{
				$delOK = TRUE;
				$this->pos[$i] = 0;
				break;
			}
		}
		if(!$delOK)
			return '您的陣容中無此球員';
			
		//檢查是否ready,(7/24)
		if(IsReady($SQLObj0,$this->teamid) && IsSeasonStart())
		{
			//扣交易次數(3/24)
			if($picher)
	    		$this->trade_1--;
	    	else
	    		$this->trade_2--;
		}
		//計算現金餘額
		$this->cash += $price;
    	return;
    }

    //更新資料庫
    function UpdateDB($SQLObj0)
    {
    	$str = "UPDATE myteam_data SET cash=".$this->cash.",trade_1=".$this->trade_1.",trade_2=".$this->trade_2.",
    	p1=".$this->pos[0].",p2=".$this->pos[1].",p3=".$this->pos[2].",p4=".$this->pos[3].",
    	p5=".$this->pos[4].",c=".$this->pos[5].",1b=".$this->pos[6].",2b=".$this->pos[7].",
    	ss=".$this->pos[8].",3b=".$this->pos[9].",of1=".$this->pos[10].",of2=".$this->pos[11].",
    	of3=".$this->pos[12].",dh=".$this->pos[13]." WHERE id='".$this->teamid."'";
		$SQLObj0->RunSQL($str);
		
		$str = "INSERT INTO myteam_roster_log (team_id,datetime,cash,trade_1,trade_2,p1,p2,p3,p4,p5,c,1b,2b,ss,3b,of1,of2,of3,dh)
		VALUES (".$this->teamid.",'".NOW()."',".$this->cash.",".$this->trade_1.",".$this->trade_2.",".$this->pos[0].",".$this->pos[1].
		",".$this->pos[2].",".$this->pos[3].",".$this->pos[4].",".$this->pos[5].",".$this->pos[6].",".$this->pos[7]."
		,".$this->pos[8].",".$this->pos[9].",".$this->pos[10].",".$this->pos[11].",".$this->pos[12].",".$this->pos[13].")";
		$SQLObj0->RunSQL($str);
    }
}
?>