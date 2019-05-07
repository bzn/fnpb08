<?php
session_start();
extract($_POST);
extract($_GET);
include_once(dirname(__FILE__)."/connect.php");

$str = "SELECT * FROM lea_data ORDER BY id";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_id = $SQLObj0->GetData("ID");
	$a_name = $SQLObj0->GetData("NAME");
	$a_isauto = $SQLObj0->GetData("ISAUTO");	
	$a_pwd = $SQLObj0->GetData("PWD");
	$a_txt = $SQLObj0->GetData("TXT");
	$a_count = $SQLObj0->GetData("COUNT");
}
for($i=0;$i<$nrows;$i++)
{
	$count = GetLeaMemCountByID($SQLObj0,$a_id[$i]);
	$maxmember = MAXMEMBER;
	if($a_isauto[$i])
	{
		$maxmember = AUTOMAXMEMBER;
	}
	
	if($count >= $maxmember)
	{
		$a_fullstr[$i] =" <font color=#FF0000>滿!</font>";
	}
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

<div id="headerSection"><span class="pageTitle">檢視所有聯盟</span><br/>
</div>
<p class="line">&nbsp;</p><br>
	



<div class="bgbox">
    <div class="pad5"><!--|
        <a href="/baseball/fullseason/ultimate/rts/rts.html" class=red target=_blank>Live Standings</a>-->
    </div>
<table class="v12 infotable">
       <tr>             
        <th class="tleft border">聯盟名稱</th>
        <th class="tleft">聯盟描述</th>
        <th class="tcenter">聯盟人數</th>
        <th class="tcenter">是否需要密碼</th>
        <th class="tcenter border">加入此聯盟</th>
        </tr>		
     <?php
		 for($i=0;$i<$nrows;$i++)
		 {	
	 	if($i%2)
		{
	 		?><tr class="even"><?php
		}
		else
		{
			?><tr class="odd"><?php
		}	
		?>
            <td class="tleft border nowrap"><a href="lea_point.php?leaid=<?php echo $a_id[$i];?>"><?php echo $a_name[$i];?></a><?php echo $a_fullstr[$i];?></td>
            <td class="tleft nowrap"><?php echo $a_txt[$i];?></td>
            <td class="tcenter nowrap"><?php echo $a_count[$i]?></td>
            <td class="tcenter"><?php if(!empty($a_pwd[$i])) echo "需要密碼";?></td>
      		<td class="tcenter border nowrap"><a href='lea_findlea.php?leaid=<?php echo $a_id[$i];?>&leaname=<?php echo $a_name[$i];?>'>加入</a></td>
   		</tr>
        <?php
		}
		?>
</table>

</div>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>