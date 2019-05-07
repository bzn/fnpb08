<?php
session_start();
extract($_POST);
extract($_GET);
include_once(dirname(__FILE__)."/connect.php");

//取得球隊id
$str = "SELECT * FROM myteam_index WHERE user_id=".$_SESSION['loginid'];
$SQLObj0->RunSQL($str);
//如果沒有隊伍則轉址到新增隊伍
if(!$SQLObj0->LinkNext())
{
	?>
	<script language="javascript">
	//轉址
	self.location.href='myteam_addteam.php';
	</script>
	<?php
}
else 
	$_SESSION['myteamid0801'] = $SQLObj0->GetData('myteam_id');	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
	<link rel="stylesheet" href="css/fantasygames.css" type="text/css">
	<link rel="stylesheet" href="css/style2007.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">	
	<link rel="stylesheet" href="css/top.css" type="text/css">
    <style type="text/css">
<!--
.style18 {font-size: 12px}
-->
    </style>
</head>
<!--- needed for carlo init func for fs popup to rollover -->
<body id="body_centered">

<div id="content">
   <table width="770" border="0" align="center">
    <tr>
      <td><?php
include(dirname(__FILE__)."/include/head.inc.php");
?></td>
    </tr>
  </table>
<br />
   
<p class="line">&nbsp;</p>
<div id="headerSection">
    <span class="pageTitle">選擇你的聯盟</span>
    <p class="dottedLine">&nbsp;</p>
    您還沒有加入任何聯盟，建議您加入一個聯盟，和聯盟其他玩家互相較勁（季賽中可以隨時更換聯盟）</div>  
<p class="line">&nbsp;</p>
    
<br /><div class="lh20">&raquo;&nbsp; <a href="lea_autolea.php" class="v12 black b">系統自動分配聯盟（推薦）</a></div>
&nbsp;&nbsp; <span class="v12">系統會依據你加入的時間，自動幫你的球隊分配到適當的20人聯盟</span>
<br />

<br />
<div class="lh20">&raquo;&nbsp; <a href="lea_makelea.php" class="v12 black b">建立一個聯盟</a></div>
&nbsp;&nbsp; <span class="v12">自己建立一個聯盟，並邀請其他的朋友來參加你的聯盟，人數上限<?php echo MAXMEMBER;?>人，聯盟可以是公開的，也可以設立私人密碼只允許你的好友加入</span>
<br />
<br />
<div class="lh20">&raquo;&nbsp; <a href="lea_findlea.php" class="v12 black b">加入別人建立的聯盟</a></div>
&nbsp;&nbsp; <span class="v12">加入到一個已經建立好的聯盟，如果是私人聯盟的話，你必需要輸入密碼才可以加入</span>
    <br />
<br />
<br class="cboth" />  
    <br class="cboth" />
    
        <br style="clear: both" />
<br />

<div style="width:780px; background-color:#eeeeee; height:12px; line-height:12px;">&nbsp;</div>

<div style="width:780px; background-color: #FFF" align="left"></div>
        
        <div style="background-color:#eeeeee; padding:10px 23px 13px 23px;"><br />
        
  </div>        
        <br />
        <br />    
</div>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>