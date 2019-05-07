<?php
//=================================================
//PHP語法範例
//=================================================

//輸出陣列
var_dump();

//字串轉小寫
strtolower($str);

//更換斷行符號
$str = nl2br($str);
    	
//看看有幾筆
count( $array );

//取得id
$Qid = mysql_insert_id();

//切開字串
$pizza = "第一片 第二片 第三片 第四片 第五片 第六片";
$pieces = explode(" ", $pizza);

//替換字串
$str = str_replace( " ' " , " \' " ,$str);

//顯示001
sprintf("%03d",1);

//無條件捨去
floor();
//無條件進位
ceil();
//四捨五入
round();

//連結至網頁
header("location:left.php");

//php帶入兩組變數
$url = "http://www.study123.com.tw/test.php?testid=bd010003&account=bluezhin";

//讀取txt並用iconv轉碼
while(!feof($fp))
{
	$news[$newscount] = fgets($fp,999);
	$news[$newscount] = iconv("Big5", "UTF-8", $news[$newscount]);
	$newscount++;
}
fclose($fp);

//清除所有的session
$_SESSION = array();
//停止session作用
session_destroy();

//md5加密
$enc_text = md5_encrypt($str, "大俠愛吃漢堡飽");
//md5解密
$plain_text2 = md5_decrypt($str, "大俠愛吃漢堡飽");

//以逗號拆解str2到str陣列
$str = explode(",",$str2);

//big5轉成unicode編碼
mb_convert_encoding($str, "UTF-8", "Big5");

//把POST全部轉出成變數
foreach($_POST as $key => $value)
{
    ${$key} = $value;
}

//以流水號取5個排序
$str = "SELECT * FROM XXX ORDER BY 流水號 DESC LIMIT 0,5;";

//取得字串中第二個字元開始取三個字元,然後把他轉成整數型態
$unit[$i] = intval(substr($a_id[$i], 2, 3));

?>

//按下disabled
onMouseDown="this.disabled=true;document.form1.submit();"

//自動reload
<head>
<meta http-equiv="refresh" content="秒數">
</head>

//重填
<a onclick="form.reset()">

//藍色字
<font color="#0000FF"><u>→閱卷</u></font>

<form name="form1" action="http://192.168.1.184/study123/vip/login.php" method="POST">
<input type="hidden" name="str" value="<?php echo $enc_text?>">
</form>
<script language="javascript">
	//到最上端
	parent.scroll(0,0); 

	//轉址
	self.location.href='left.php';

	//送出整個表單
	<!--
	window.form1.submit();
	//-->
	
	//列印
	window.print();
	
	//if(confirm("確認要觀賞本片?"))
	{
		self.location.href="runmovie.php?movieid="+"<?echo $movieid;?>"+"";
	}
</script>

<a href="javascript:history.back()">上一頁</a> 

	
	
<script language="javascript">
	//底頁reload
	<!--
	top.location.href="http://192.168.1.184/study123/vip/index.php";
	//-->
</script>


//送一整個form過去
<form name="form1" action="http://192.168.1.184/study123/vip/login.php" method="POST">
<input type="hidden" name="str" value="<?php echo $enc_text?>">
</form>
<script language="javascript">
<!--
window.form1.submit();
//-->
</script>