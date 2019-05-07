<?php
session_start();
extract($_POST);
extract($_GET);
include_once(dirname(__FILE__)."/connect.php");

//聯盟最大人數
$maxmember = MAXMEMBER;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
</head>
<?php
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
	
if(empty($leaid))
{
	echo "沒有leaid";
	exit;
}
//檢查密碼
$str = "SELECT * FROM lea_data WHERE id='".$leaid."'";
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$leapwd = $SQLObj0->GetData("PWD");
	if(!empty($pwd) && $pwd!==$leapwd)
	{
		?>
		<script language="javascript">
		alert("密碼錯誤");
		self.location.href='lea_nolea.php';
		</script>
		<?php
	}
}
else 
{
	?>
	<script language="javascript">
	alert("沒有這個聯盟");
	self.location.href='lea_nolea.php';
	</script>
	<?php
}

//檢查聯盟人數
$count = GetLeaMemCountByID($SQLObj0,$leaid);
if($count >= $maxmember)
{
	?>
	<script language="javascript">
	alert("這個聯盟已經達到<?php echo $maxmember;?>隊的上限，請您選擇其他的聯盟");
	self.location.href='lea_nolea.php';
	</script>
	<?php
}

$teamid = $_SESSION['myteamid0801'];
//檢查目前是否有leaid了
$str = "SELECT * FROM lea_index WHERE team_id='".$teamid."'";
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

if($oldleaid != $leaid)
{
	//重新計算兩聯盟人數
	if(!empty($oldleaid))
	{
		$count = GetLeaMemCountByID($SQLObj0,$oldleaid);
		if($count)
		{
			$str = "UPDATE lea_data SET count='".$count."' WHERE id='".$oldleaid."'";
			$SQLObj0->RunSQL($str);
		}
		else 
		{
			//所有人離開聯盟,聯盟被刪除
			$str = "DELETE FROM lea_data WHERE id='".$oldleaid."'";
			$SQLObj0->RunSQL($str);
		}
	}
	$count = GetLeaMemCountByID($SQLObj0,$leaid);
	$str = "UPDATE lea_data SET count='".$count."' WHERE id='".$leaid."'";
	$SQLObj0->RunSQL($str);
}

?>
<script language="javascript">
alert("加入聯盟成功");
self.location.href='lea_index.php';
</script>
