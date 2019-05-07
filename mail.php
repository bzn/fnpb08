<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
set_time_limit(1000);
include_once(dirname(__FILE__)."/connect.php");

$str = "SELECT * FROM ".$ini_array['system']['dbpublic'].".user_data WHERE active='Y'";
$SQLObj0->RunSQL($str);
$nrows = $SQLObj0->LinkAll();
$a_account = $SQLObj0->GetData("ACCOUNT");
$a_nickname = $SQLObj0->GetData("NICKNAME");
$a_email = $SQLObj0->GetData("EMAIL");
for($i=0;$i<$nrows;$i++)
{
	echo $a_account[$i]."	".$a_email[$i]."<BR>";

$subject = "Fantasy NPB 08 回來了！";

$name = $a_account[$i];
$to = $a_email[$i];

//送發email
$txt = "嗨 ".$name."：

■■■■■■■■■■■■■■■■
2008年球季即將開始
Fantasy NPB 08 回來了！
■■■■■■■■■■■■■■■■

全新的一季
新的球員的資料和身價以及玩家榮譽系統
另外
玩家現在可以利用聯盟系統，組織自己的小型聯盟
邀請你的好友或是其他玩家來相互較勁
趕快回來Fantasy NPB看看吧！

別忘了
遊戲將在3月20日開始
在這之前選好你的球員喔 ^_^

---------------------------------------------------------
Fantay NPB 08
http://npb.ohdada.com/
請勿回覆這封信，我也不知道會寄到哪裡呢
聯絡請使用npb@ohdada.com
---------------------------------------------------------";

//轉成Big5編碼
//$title = iconv("UTF-8", "Big5", $title);
//$str = iconv("UTF-8", "Big5", $str);
//mail($email,$title,$str,"From:".$myemail);

mb_internal_encoding("UTF-8");

$headers = 'From: npb@ohdada.com' . "\r\n"; // 請自行替換寄件地址  
mb_send_mail("$to", "$subject", "$txt", $headers);
echo "<OK><BR>";
}
?>

?>
<script language="javascript">
alert("寄出成功！！<?php echo $nrows;?>封");
window.close();
</script>

