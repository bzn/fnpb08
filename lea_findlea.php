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

if($_POST['action'] == 1)
{
	$errmsg = NULL;
	$leaid = $_POST['textfield'];
	$leaname = $_POST['textfield2'];
	$leapwd = $_POST['textfield3'];
	//是否有這個聯盟
	$islea = FALSE;
	if(!empty($leaid))
	{
		$str = "SELECT * FROM lea_data WHERE id='".$leaid."'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$leaid = $SQLObj0->GetData("ID");
			$leaname = $SQLObj0->GetData("NAME");
			$isauto = $SQLObj0->GetData("ISAUTO");	
			$islea = TRUE;
		}
	}
	if(!$islea && !empty($leaname))
	{		
		$str = "SELECT * FROM lea_data WHERE name='".$leaname."'";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$leaid = $SQLObj0->GetData("ID");
			$leaname = $SQLObj0->GetData("NAME");
			$isauto = $SQLObj0->GetData("ISAUTO");			
			$islea = TRUE;
		}
	}
	if(!$islea)
	{
		$errmsg = "沒有這個聯盟";
	}
	else 
	{
		if($isauto)
		{
			//聯盟最大人數
			$maxmember = AUTOMAXMEMBER;
		}
		else 
		{
			//聯盟最大人數
			$maxmember = MAXMEMBER;
		}

		$count = GetLeaMemCountByID($SQLObj0,$leaid);
		if($count <= $maxmember)
		{					
			?>
			<script language="javascript">
			if(confirm("您確認要加入《<?php echo $leaname;?>》嗎?"))
			{
				self.location.href="lea_joinlea.php?leaid="+"<?php echo $leaid;?>"+"&pwd="+"<?php echo $leapwd;?>";
			}
			</script>
			<?php
		}
		else 
		{
			$errmsg = "聯盟人數已到達".$maxmember."人上線";
		}
	}
}
if(strlen($errmsg))
{
	?>
	<script language="javascript">
	alert("<?php echo $errmsg;?>");
	</script>
<?php
}	
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
    <span class="pageTitle">加入別人建立的聯盟</span>
    <p class="dottedLine">&nbsp;</p>
    您可以在這裡加入其他玩家建立的聯盟</div>  
<p class="line">&nbsp;</p>
    
<br />
<form name="form1" method="post" action="">
<input type="hidden" name="action" value="1">
<div class="v12 black b">&raquo; 聯盟編號 
  
    <label>
    <input type="text" name="textfield" id="textfield" value="<?php echo $leaid;?>">
      </label>
  
  或 聯盟名稱 
  <input type="text" name="textfield2" id="textfield2" value="<?php echo $leaname;?>">
</div>
&nbsp;&nbsp; <span class="v12">您想加入的聯盟名稱或編號，或是<a href="lea_alllea.php">查看所有的聯盟</a></span><br />

<br />
<div class="lh20"><span class="v12 black b">&raquo; 聯盟密碼
    <label>
    <input type="text" name="textfield3" id="textfield3">
    </label>
</span></div>
&nbsp;&nbsp; <span class="v12">私人聯盟需要輸入密碼方能加入，公開聯盟此欄請留白</span><br />
<br />
<input type="submit" name="Submit" value="送出" class="v11">
<br>
<br />
</form>
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