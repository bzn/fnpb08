<?php
/*******************************************************************************************
DATE      : 2007/6/12
AUTHOR    : bluezhin
LsfPaint Class 
******************************************************************************************/

class LsfPaintObj{
    var $w			= 0;		//畫布寬
	var $h			= 0;		//畫布高
	var $im			= 0;		//畫布
	var $str		= 0;		//繪圖字串
	var $a_pix		= array();	//像素資訊
	
	//============初始所有的變數============//
    function Init()
    {
		$this->w		= 0;
		$this->h		= 0;
		$this->im		= 0;
		$this->a_pix	= array();
    }
    
    //===========新增一張畫紙============//
    function NewPaper($w,$h)
    {
    	$this->init();
    	$this->w = $w;
    	$this->h = $h;
		//$this->im = imagecreate($this->w,$this->h);
		$this->im = imagecreatetruecolor($this->w,$this->h);
    }
    
    //===========讀取小連圖檔============//
    function LoadLsfPic($str)
    {
    	$this->str = $str;
    	//解析小連字串
    	$this->a_pix = explode('_',$str);
    	for($y=0;$y<$this->w;$y++)
    	{
    		for($x=0;$x<$this->h;$x++)
    		{
    			//取得顏色
    			$str = $this->a_pix[$y*$this->h+$x];
    			//換算為RGB
    			$rr = hexdec(substr($str,1,2));
    			$gg = hexdec(substr($str,3,2));
    			$bb = hexdec(substr($str,5,2));
    			//echo $rr." ".$gg." ".$bb."<BR>";
    			$col = ImageColorAllocate($this->im,$rr,$gg,$bb);
    			//畫點
    			imagesetpixel($this->im,$x,$y,$col);	
    			//echo $x.",".$y."<BR>";
    		}
    	}
    	//exit;
    }
    
    //==========儲存============//
    function Save($userid)
    {
    	if(!$userid)
    		return;
    	//顯示圖形
	    //header('Content-type:image/png');
	    //儲存圖形TXT
	    $path = "../usericon/".$userid.".txt";
	    @unlink($path);
		//寫入檔案
		$fp = fopen($path,'w');
		//鎖住檔案
		if(flock($fp, LOCK_EX))
		{
			fwrite($fp,$this->str);
			//解除封鎖
			flock($fp, LOCK_UN);
		}	
		fclose($fp);
		//儲存圖形PNG
	    $path = "../usericon/".$userid.".png";
	    @unlink($path);
		imagepng($this->im,$path);
    }
}
?>