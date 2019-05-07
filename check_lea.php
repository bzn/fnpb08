<?php
session_start();
extract($_POST);
extract($_GET);
include_once(dirname(__FILE__)."/connect.php");
//取得聯盟id
$str = "SELECT * FROM lea_index WHERE team_id=".$_SESSION['myteamid0801'];
$SQLObj0->RunSQL($str);
//如果沒有隊伍則轉址到新增隊伍
if(!$SQLObj0->LinkNext())
{
	?>
	<script language="javascript">
	//轉址
	self.location.href='lea_nolea.php';
	</script>
	<?php
}
else 
	$_SESSION['leaid'] = $SQLObj0->GetData('lea_id');
?>