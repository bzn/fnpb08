<?php
include_once(dirname(__FILE__)."/connect.php");
//矯正lea的人數
$str = "SELECT * FROM lea_data";
$SQLObj0->RunSQL($str);
$nrows = $SQLObj0->LinkAll();
$a_id = $SQLObj0->GetData("ID");
for($i=0;$i<$nrows;$i++)
{
	$count = GetLeaMemCountByID($SQLObj0,$a_id[$i]);
	$str = "UPDATE lea_data SET count='".$count."' WHERE id='".$a_id[$i]."'";
	$SQLObj0->RunSQL($str);
}
?>