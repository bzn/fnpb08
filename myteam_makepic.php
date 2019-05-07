<?php
header("Expires: Mon, 26 May 2007 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");
require_once("paint.class.php");
$is_success = false;
if(!empty($_POST['canavasData']))
{
    $LsfPaintObj = new LsfPaintObj();
    $LsfPaintObj->NewPaper(24,24);
    $LsfPaintObj->LoadLsfPic($_POST['canavasData']);
    $LsfPaintObj->Save($_SESSION['loginid']);
    $is_success = true;
    $color = explode('_',$_POST['canavasData']);
}else
{
	$path = "../usericon/".GetUserIDByMyTeamID($SQLObj0,$_SESSION['myteamid0801']).".txt";
	//$path = "myteamicon/test.txt";
	if(file_exists($path))
	{	
		$fp = fopen($path,'r');
		$contents = fread($fp,filesize($path));
		fclose($fp);
		$color = explode('_',$contents);
	}
	
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
<script type="text/javascript" src="prototype.js"></script>
<script type="text/javascript" src="twpainter.js"></script>
<link href="twcolorpick.css" rel="stylesheet" type="text/css">
<LINK href="css/css.css" rel="stylesheet" type="text/css">

	
	<link rel="stylesheet" href="css/fantasygames.css" type="text/css">
	<link rel="stylesheet" href="css/style2007.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">	
	<link rel="stylesheet" href="css/top.css" type="text/css">
	
<script type="text/javascript">

var drawMode = true;

function check_color()
{
	if($('gridBox'))
	{
		Event.observe('gridBox','click',colorpick,false);
	}
	
	$('canavas').onmousedown = BrushDown;
	$('canavas').onmouseup = BrushUp;
	$('canavas').onmouseover = Brush;
	$('canavas').onmousemove = BrushMove;
	
}

function sendCanavas()
{
    if(!confirm("確定要送出!?\n原本的圖示將會被取代哦~!!")) return;
	var canavas_data = $("canavasData");
	var Data = $$("div#canavas .canavas_box");
	for(var index=0;index< Data.length;index++)
	{
		if(Data[index].style.backgroundColor == "" || Data[index].style.backgroundColor == null)
			Data[index].style.backgroundColor = "#ffffff";
		canavas_data.value = canavas_data.value + Data[index].style.backgroundColor + "_";
	}
	
	canavas_form.submit();
}

function drawModeChange()
{
	drawMode = drawMode ? false:true;
	if( drawMode )
	{
		$('painter').src = 'painter_using.gif';
		$('picker').src = 'picker.gif';
	}
	else
	{
		$('painter').src = 'painter.gif';		
		$('picker').src = 'picker_using.gif';
	}
}


function clearCanavas()
{
	var big = $$("div#canavas .canavas_box");
	//var small = $$("div#small .canavas_box_s");
	for(var index=0;index< big.length;index++)
	{
		big[index].style.backgroundColor = "#ffffff";
	}
}
<?php if($is_success) {?>
Event.observe(window,"load",function(){
    alert("上傳成功!!恭喜您!!");
});
<?php } ?>
</script>

</head>
<body onLoad="check_color();">
  <table width="770" border="0" align="center">
    <tr>
      <td><?php
include(dirname(__FILE__)."/include/head.inc.php");
?></td>
    </tr>
  </table>
<div style="OVERFLOW : auto;">
  <table width="770" border="0" align="center">
	<tr><td>
		<div id='BackgroundColorContainer' style="float:left">
			<?php
				$canavasDiv = "<div id='canavas'>";
				for($index=0;$index < 576;$index++)
				{
					$canavasDiv = $canavasDiv . "<div id='canavas_box_" . $index . "' class='canavas_box' name='canavas_box'  style='background-color:". $color[$index] ."' value='" . $index . "'></div>";
				}
				$canavasDiv .= "</div>";
				echo $canavasDiv;	
			?>
			<input type="button" value="清除畫布" onClick="clearCanavas();" />
			<input type="button" value="產生隊徽" onClick="sendCanavas();">
			<form id="canavas_form" name="canavas_form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
				<input type="hidden" name="canavasData" id="canavasData" />
			</form>	
		</div>
		<div id="head" style="margin:5px 5px 5px 10px">
			<div >
				<script type="text/javascript">
				CreateColorPanel();
				</script>
			</div>
			<div style="margin:0px 5px">
				<input type="text" id="color_input" name="color_input" style="border:solid 1px ;width:50px" />
			</div>
			<div style="float:left;margin:0px 5px">
				<img src="painter_using.gif" id = 'painter' name = 'painter' onclick="drawModeChange();" ></span>
			</div>
			<div style="margin:0px 5px">
				<img src="picker.gif" id = 'picker' name = 'picker' onclick="drawModeChange();" ></span>
			</div>
		</div>
		<div style="clear:both"></div>
	</td></tr>
  </table>
</div>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>
