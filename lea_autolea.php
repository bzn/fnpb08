<?php
session_start();
extract($_POST);
extract($_GET);
include_once(dirname(__FILE__)."/connect.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
</head>
<?php
//聯盟最大人數
$maxmember = AUTOMAXMEMBER;

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

$str = "SELECT * FROM lea_data WHERE isauto=1 ORDER BY id DESC";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$leaid = $SQLObj0->GetData("ID");
	$leaname = $SQLObj0->GetData("NAME");
	//檢查聯盟人數
	$count = GetLeaMemCountByID($SQLObj0,$leaid);
	if($count < $maxmember)
	{
		$teamid = $_SESSION['myteamid0801'];
		//檢查目前是否有leaid了
		$str = "SELECT * FROM lea_index WHERE team_id=".$teamid;
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$oldleaid = $SQLObj0->GetData("LEA_ID");
			//加入聯盟
			$str = "UPDATE lea_index SET lea_id=".$leaid." WHERE team_id=".$teamid;	
		}
		else 
		{
			//加入聯盟
			$str = "INSERT INTO lea_index SET lea_id=".$leaid.", team_id=".$teamid;	
		}
		$SQLObj0->RunSQL($str);
		
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
	}
	else
	{
		$count = substr($leaname,12,strlen($leaname)-12);
		/*//檢查auto lea數量
		$str = "SELECT * FROM lea_data WHERE isauto = 1";
		$SQLObj0->RunSQL($str);
		$count = $SQLObj0->LinkAll();*/
		$leaname = "系統聯盟".($count+1);
		//開新聯盟
		$str = "INSERT INTO lea_data SET name='".$leaname."',isauto=1,txt=''";
		$SQLObj0->RunSQL($str);
		$str = "SELECT * FROM lea_data WHERE name='".$leaname."' AND isauto=1";
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
			$leaid = $SQLObj0->GetData("ID");
		
		$teamid = $_SESSION['myteamid0801'];
		//檢查目前是否有leaid了
		$str = "SELECT * FROM lea_index WHERE team_id=".$teamid;
		$SQLObj0->RunSQL($str);
		if($SQLObj0->LinkNext())
		{
			$oldleaid = $SQLObj0->GetData("LEA_ID");
			//加入聯盟
			$str = "UPDATE lea_index SET lea_id=".$leaid." WHERE team_id=".$teamid;	
		}
		else 
		{
			//加入聯盟
			$str = "INSERT INTO lea_index SET lea_id=".$leaid.", team_id=".$teamid;	
		}
		$SQLObj0->RunSQL($str);
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
	}
	
}
else 
{
	//檢查auto lea數量
	$str = "SELECT * FROM lea_data WHERE isauto = 1";
	$SQLObj0->RunSQL($str);
	$count = $SQLObj0->LinkAll();
	$leaname = "系統聯盟".($count+1);
	//開新聯盟
	$str = "INSERT INTO lea_data SET name='".$leaname."',isauto=1,txt=''";
	$SQLObj0->RunSQL($str);
	$str = "SELECT * FROM lea_data WHERE name='".$leaname."' AND isauto=1";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		$leaid = $SQLObj0->GetData("ID");
	
	$teamid = $_SESSION['myteamid0801'];
	//檢查目前是否有leaid了
	$str = "SELECT * FROM lea_index WHERE team_id=".$teamid;
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
	{
		$oldleaid = $SQLObj0->GetData("LEA_ID");
		//加入聯盟
		$str = "UPDATE lea_index SET lea_id=".$leaid." WHERE team_id=".$teamid;	
	}
	else 
	{
		//加入聯盟
		$str = "INSERT INTO lea_index SET lea_id=".$leaid.", team_id=".$teamid;	
	}
	$SQLObj0->RunSQL($str);
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
}

if(empty($leaname))
{
	?>
	<script language="javascript">
	alert("<?php echo "加入聯盟失敗";?>");
	//轉址
	self.location.href='lea_index.php';
	</script>
	<?
}
else 
{
	?>
	<script language="javascript">
	alert("您加入了<?php echo $leaname;?>");
	//轉址
	self.location.href='lea_index.php';
	</script>
	<?
}
?>