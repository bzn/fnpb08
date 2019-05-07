<?php
session_start();
extract($_POST);
extract($_GET);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
$_SESSION['loginid'] = 4;
//檢查登入
if(!$_SESSION['loginid'])
{
	?>
	<script language="javascript">
	alert("請先登入");
	//轉址
	self.location.href='../index.php';
	</script>
	<?php
}
//檢查認證
include_once("connect.php");
if(!CheckReg($SQLObj0,$_SESSION['loginid']))
{
	//警告認證
	?>
	<script language="javascript">
	//警告
	alert('您的帳號尚未經過認證,請於首頁點擊"寄送認證信"連結');
	//轉址
	self.location.href='../index.php';
	</script>
	<?php
}
else
{
	echo $_SESSION['loginid'];
}

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

//檢查聯盟
include(dirname(__FILE__)."/check_lea.php");

?>