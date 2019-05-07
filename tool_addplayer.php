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
  球隊id
  <input name="teamid" type="text" size="4" /></label><br />
  <label>
  全名（需與yahoo上資料完全符合）
  <input name="name" type="text" size="4" /></label><br />  
  <label>
  價錢(350為基準)
  <input name="price" type="text" size="4" /></label><br />
  <label>
  背號
  <input name="no" type="text" size="4" /></label>
  <br />
  <label>
  生日(xxxx-xx-xx)
  <input name="birth" type="text" size="4" /></label><br />
  <label>
  投球利手（大寫R或L）
  <input name="pitch" type="text" size="4" /></label><br />
  <label>
  打擊利手（大寫R或L或S）
  <input name="bat" type="text" size="4" /></label><br />
  <label>
  投手(1或0)
  <input name="p" type="text" size="4" /></label><br />
  <label>
  1B(1或0)
  <input name="fb" type="text" size="4" /></label><br />
  <label>
  2B(1或0)
  <input name="sb" type="text" size="4" /></label><br />
  <label>
  3B(1或0)
  <input name="tb" type="text" size="4" /></label><br />
  <label>
  SS(1或0)
  <input name="ss" type="text" size="4" /></label><br />
  <label>
  OF(1或0)
  <input name="ss" type="text" size="4" /></label><br />
  <label>
  DH(1或0)
  <input name="dh" type="text" size="4" /></label><br />
  
  <input type="submit" name="Submit" value="新增球員" />
</form>