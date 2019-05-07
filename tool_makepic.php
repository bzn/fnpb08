<?php
session_start();

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

extract($_POST);
extract($_GET);
//include(dirname(__FILE__)."/check.php");
//include_once(dirname(__FILE__)."/connect.php");
include_once(dirname(__FILE__)."/paint.class.php");
//$str = "#7fbfff+#7fbfff+#7fbfff+#7fbfff+#7fbfff+#7fbfff+#00FFFF+#00FFFF+#FFFFFF+#FFFFFF+#FFFFFF+#FFFFFF";

$LsfPaintObj = new LsfPaintObj();
$LsfPaintObj->NewPaper(16,16);
$LsfPaintObj->LoadLsfPic($canavasData);
$LsfPaintObj->Save($file_name);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Fantasy NPB!!</title>
</head>
<body>
<img src="myteamicon/<?php echo $file_name;?>.png">
<a href="http://npb.ohdada.com/season2/color/makepic_demo.php">重新畫圖</a>
</body>
</html>
