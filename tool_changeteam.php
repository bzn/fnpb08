<?php
session_start();
extract($_POST);
extract($_GET);
set_time_limit(1500);
include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/npb.class.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
/*
if(empty($_SESSION['admin']))
{
	echo '請先登入';
	exit;
}
*/
if($_POST['action'] == 1)
{
	if($_POST['active'] == 0)
	{
		$str = "UPDATE player_data SET active = 0 WHERE id='".$_POST['playerid']."'";
		$SQLObj0->RunSQL($str);
		?>
		<script language="javascript">
		<!--
		alert("移除球員成功");
		//-->
		</script>
		<?
	}
	else 
	{
		$str = "UPDATE player_data SET active = 1 WHERE id='".$_POST['playerid']."'";
		$SQLObj0->RunSQL($str);
		if($_POST['teamid']>0 && $_POST['teamid']<13)
		{
			$str = "UPDATE team_index SET team_id='".$_POST['teamid']."' WHERE player_id='".$_POST['playerid']."'";
			$SQLObj0->RunSQL($str);
		}
		?>
		<script language="javascript">
		<!--
		alert("修改資料成功");
		//-->
		</script>
		<?
	}
	//取得目前球員id
	$str = "SELECT * FROM player_base_data ORDER BY id DESC";
	$SQLObj0->RunSQL($str);
	if($SQLObj0->LinkNext())
		$id = $SQLObj0->GetData("ID")+1;
	$str = "INSERT INTO player_base_data SET id='".$id."',name_2='".$_POST['name']."',no='".$_POST['no']."',birth='".$_POST['birth']."',pitch='".$_POST['pitch']."',bat='".$_POST['bat']."',p='".$_POST['p']."',1b='".$_POST['fb']."',2b='".$_POST['sb']."',3b='".$_POST['tb']."',ss='".$_POST['ss']."',of='".$_POST['of']."',DH='".$_POST['dh']."',price='".$_POST['price']."',active=1";
	$SQLObj0->RunSQL($str);
	//新增至index
	$str = "INSERT INTO team_index SET team_id='".$_POST['teamid']."',player_id='".$id."'";
	$SQLObj0->RunSQL($str);
	?>
	<script language="javascript">
	<!--
	alert("新增球員");
	//-->
	</script>
	<?
}
?>
<form id="form1" name="form1" method="post" action="">
  <input type="hidden" name="action" value="1">
  <b>球員新增器 v1.0</b><BR>
  <font color="FFOOOO"></font>
  <BR>
  請輸入球員的資料<br />
  <label>
  球員id
  <input name="playerid" type="text" size="4" /></label><br />  
  <label>
  active(0或1)
  <input name="active" type="text" size="4" /></label><br />
  <label>
  新球隊id
  <input name="teamid" type="text" size="4" /></label><br />  
  <input type="submit" name="Submit" value="新增球員" />
</form>