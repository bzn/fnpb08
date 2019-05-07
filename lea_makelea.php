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
	$leaname = $_POST['textfield'];
	$leapwd = $_POST['textfield2'];
	$leatxt = $_POST['textfield3'];

	if(strlen($leaname) > 60)
	{
		$errmsg = "聯盟名稱不能超過20個字";
	}
	if(strlen($leapwd) > 60)
	{
		$errmsg = "密碼不能超過20個字";
	}
	if(strlen($leatxt) > 150)
	{
		$errmsg = "聯盟描述不能超過50個字";
	}
	elseif(strlen($leaname)==0) 
	{
		$errmsg = "必須輸入一個聯盟名稱";
	}
	else 
	{
		$str = "SELECT * FROM lea_data WHERE name ='".$leaname."'";		
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			$errmsg = "這個聯盟名稱已經有人使用了";
		else 
		{
			$str = "INSERT INTO lea_data (name,pwd,isauto,txt,count) VALUES ('".$leaname."','".$leapwd."',0,'".$leatxt."',1)";
			$SQLObj0->RunSQL($str);
			$str = "SELECT * FROM lea_data WHERE name='".$leaname."'";
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			//取得id
			$leaid = $SQLObj0->GetData('ID');
			$teamid = $_SESSION['myteamid0801'];
			//檢查目前是否有leaid了
			$str = "SELECT * FROM lea_index WHERE team_id=".$teamid;
			$SQLObj0->RunSQL($str);
			if($SQLObj0->LinkNext())
			{
				$oldleaid = $SQLObj0->GetData("LEA_ID");
				//更新到index
				$str = "UPDATE lea_index SET lea_id=".$leaid." WHERE team_id=".$teamid;
				$SQLObj0->RunSQL($str);
			}
			else 
			{
				//加入到index
				$str = "INSERT INTO lea_index (team_id,lea_id) VALUES (".$teamid.",".$leaid.")";
				$SQLObj0->RunSQL($str);
			}
			
			//重新計算兩聯盟人數
			if(!empty($oldleaid))
			{
				$count = GetLeaMemCountByID($SQLObj0,$oldleaid);
				$str = "UPDATE lea_data SET count='".$count."' WHERE id='".$leaid."'";
				$SQLObj0->RunSQL($str);
			}
			$count = GetLeaMemCountByID($SQLObj0,$leaid);
			$str = "UPDATE lea_data SET count='".$count."' WHERE id='".$leaid."'";
			$SQLObj0->RunSQL($str);
			?>
			<script language="javascript">
			alert("新增聯盟成功");
			//轉址
			self.location.href='lea_index.php';
			</script>
			<?php
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
    <span class="pageTitle">建立你的聯盟</span>
    <p class="dottedLine">&nbsp;</p>
    自創一個聯盟，並記住您的密碼(如果有設置的話)，以便邀請其他的隊伍加入</div>  
<p class="line">&nbsp;</p>
    
<br />
<form name="form1" method="post" action="">
<input type="hidden" name="action" value="1">
<div class="v12 black b">&raquo; 聯盟名稱 
  
    <label>
    <input type="text" name="textfield" id="textfield">
      </label>
  
  </div>
&nbsp;&nbsp; <span class="v12">您想建立的聯盟名稱</span><br />

<br />
<div class="lh20"><span class="v12 black b">&raquo; 聯盟密碼
    <label>
    <input type="text" name="textfield2" id="textfield2">
    </label>
</span></div>
&nbsp;&nbsp; <span class="v12">其他玩家必需要輸入密碼才可以加入這個聯盟，如果不希望限制的話此欄請留白</span><br />
<br />
    <div class="lh20"><span class="v12 black b">&raquo; 聯盟描述</span>
      <label>
      </label>

      <label>
      <input name="textfield3" type="text" id="textfield3" size="50" maxlength="50">
              </label>
	</div>
&nbsp;&nbsp; <span class="v12">關於此聯盟的文字描述</span>（中文25字）<br />
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