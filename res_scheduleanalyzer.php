<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");

for($i=0;$i<12;$i++)
{
	$a_schedule[$i] = GetScheduleByPeri($SQLObj0,($i+1),28);
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
	<link rel="stylesheet" href="css/fantasygames.css" type="text/css">
	<link rel="stylesheet" href="css/style2007.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">	
	<link rel="stylesheet" href="css/top.css" type="text/css">
<script language="javascript">
//OnMouse table change backgroundColor
function OMOver(OMO){OMO.style.backgroundColor='#<?php echo COLOR1;?>';}
function OMOut(OMO){OMO.style.backgroundColor='';}
</script>
<style type="text/css">
<!--
a:visited {color: #FFFFFF;}
a:link {color: #FFFFFF;}
a{text-decoration:none ; } 
a:hover {text-decoration:underline ; }

.style17 {color: #FFFFFF}
.style18 {font-size: 12px}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
.style20 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>
<body>
<div id="container" style="OVERFLOW : auto;">
  <table width="770" border="0" align="center">
    <tr>
      <td><?php
include(dirname(__FILE__)."/include/head.inc.php");
?></td>
    </tr>
  </table>
<table width="768" border="0" align="center">
  <tr>
    <td colspan="5" class="style18"><span class="style20"><?php echo $myteamname;?></span></td>
    </tr>
</table>
<span class="style18"><br />
</span>
<table width="770" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"><span class="style17"></span></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=1'><font color='#FFFFFF'>".GetTeamName($SQLObj0,1)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=2'><font color='#FFFFFF'>".GetTeamName($SQLObj0,2)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=3'><font color='#FFFFFF'>".GetTeamName($SQLObj0,3)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=4'><font color='#FFFFFF'>".GetTeamName($SQLObj0,4)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=5'><font color='#FFFFFF'>".GetTeamName($SQLObj0,5)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=6'><font color='#FFFFFF'>".GetTeamName($SQLObj0,6)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=7'><font color='#FFFFFF'>".GetTeamName($SQLObj0,7)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=8'><font color='#FFFFFF'>".GetTeamName($SQLObj0,8)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=9'><font color='#FFFFFF'>".GetTeamName($SQLObj0,9)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=10'><font color='#FFFFFF'>".GetTeamName($SQLObj0,10)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=11'><font color='#FFFFFF'>".GetTeamName($SQLObj0,11)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=12'><font color='#FFFFFF'>".GetTeamName($SQLObj0,12)."</font></a>";?></div></td>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"></div></td>
      </tr>
      <?php 
      for($i=0;$i<7;$i++)
      {
      	?>
      <tr bgcolor="#FFFFFF" onMouseOver="OMOver(this);" onMouseOut="OMOut(this);">
      	<td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      	<?php
      	for($j=0;$j<12;$j++)
      	{
	      	?>	
	        <td><div align="center" class="style17"><font color="#000000"><?php echo $a_schedule[$j][$i]['team_name'];?></font></div></td>
			<?php
      	}
      	?>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      <?php
      }
      ?>
      </tr>
      <tr>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"><span class="style17"></span></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=1'><font color='#FFFFFF'>".GetTeamName($SQLObj0,1)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=2'><font color='#FFFFFF'>".GetTeamName($SQLObj0,2)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=3'><font color='#FFFFFF'>".GetTeamName($SQLObj0,3)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=4'><font color='#FFFFFF'>".GetTeamName($SQLObj0,4)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=5'><font color='#FFFFFF'>".GetTeamName($SQLObj0,5)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=6'><font color='#FFFFFF'>".GetTeamName($SQLObj0,6)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=7'><font color='#FFFFFF'>".GetTeamName($SQLObj0,7)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=8'><font color='#FFFFFF'>".GetTeamName($SQLObj0,8)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=9'><font color='#FFFFFF'>".GetTeamName($SQLObj0,9)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=10'><font color='#FFFFFF'>".GetTeamName($SQLObj0,10)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=11'><font color='#FFFFFF'>".GetTeamName($SQLObj0,11)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=12'><font color='#FFFFFF'>".GetTeamName($SQLObj0,12)."</font></a>";?></div></td>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"></div></td>
      </tr>
      <?php 
      for($i=7;$i<14;$i++)
      {
      	?>
      <tr bgcolor="#FFFFFF" onMouseOver="OMOver(this);" onMouseOut="OMOut(this);">
      	<td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      	<?php
      	for($j=0;$j<12;$j++)
      	{
	      	?>	
	        <td><div align="center" class="style17"><font color="#000000"><?php echo $a_schedule[$j][$i]['team_name'];?></font></div></td>
			<?php
      	}
      	?>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      <?php
      }
      ?>
      <tr>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"><span class="style17"></span></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=1'><font color='#FFFFFF'>".GetTeamName($SQLObj0,1)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=2'><font color='#FFFFFF'>".GetTeamName($SQLObj0,2)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=3'><font color='#FFFFFF'>".GetTeamName($SQLObj0,3)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=4'><font color='#FFFFFF'>".GetTeamName($SQLObj0,4)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=5'><font color='#FFFFFF'>".GetTeamName($SQLObj0,5)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=6'><font color='#FFFFFF'>".GetTeamName($SQLObj0,6)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=7'><font color='#FFFFFF'>".GetTeamName($SQLObj0,7)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=8'><font color='#FFFFFF'>".GetTeamName($SQLObj0,8)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=9'><font color='#FFFFFF'>".GetTeamName($SQLObj0,9)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=10'><font color='#FFFFFF'>".GetTeamName($SQLObj0,10)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=11'><font color='#FFFFFF'>".GetTeamName($SQLObj0,11)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=12'><font color='#FFFFFF'>".GetTeamName($SQLObj0,12)."</font></a>";?></div></td>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"></div></td>
      </tr>
      <?php 
      for($i=14;$i<21;$i++)
      {
      	?>
      <tr bgcolor="#FFFFFF" onMouseOver="OMOver(this);" onMouseOut="OMOut(this);">
      	<td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      	<?php
      	for($j=0;$j<12;$j++)
      	{
	      	?>	
	        <td><div align="center" class="style17"><font color="#000000"><?php echo $a_schedule[$j][$i]['team_name'];?></font></div></td>
			<?php
      	}
      	?>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      <?php
      }
      ?>
      </tr>
      <tr>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"><span class="style17"></span></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=1'><font color='#FFFFFF'>".GetTeamName($SQLObj0,1)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=2'><font color='#FFFFFF'>".GetTeamName($SQLObj0,2)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=3'><font color='#FFFFFF'>".GetTeamName($SQLObj0,3)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=4'><font color='#FFFFFF'>".GetTeamName($SQLObj0,4)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=5'><font color='#FFFFFF'>".GetTeamName($SQLObj0,5)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=6'><font color='#FFFFFF'>".GetTeamName($SQLObj0,6)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=7'><font color='#FFFFFF'>".GetTeamName($SQLObj0,7)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=8'><font color='#FFFFFF'>".GetTeamName($SQLObj0,8)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=9'><font color='#FFFFFF'>".GetTeamName($SQLObj0,9)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=10'><font color='#FFFFFF'>".GetTeamName($SQLObj0,10)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=11'><font color='#FFFFFF'>".GetTeamName($SQLObj0,11)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=12'><font color='#FFFFFF'>".GetTeamName($SQLObj0,12)."</font></a>";?></div></td>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"></div></td>
      </tr>
      <?php 
      for($i=21;$i<28;$i++)
      {
      	?>
      <tr bgcolor="#FFFFFF" onMouseOver="OMOver(this);" onMouseOut="OMOut(this);">
      	<td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      	<?php
      	for($j=0;$j<12;$j++)
      	{
	      	?>	
	        <td><div align="center" class="style17"><font color="#000000"><?php echo $a_schedule[$j][$i]['team_name'];?></font></div></td>
			<?php
      	}
      	?>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo $a_schedule[0][$i]['datetime'];?></div></td>
      <?php
      }
      ?>
      </tr>
      <tr>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"><span class="style17"></span></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=1'><font color='#FFFFFF'>".GetTeamName($SQLObj0,1)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=2'><font color='#FFFFFF'>".GetTeamName($SQLObj0,2)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=3'><font color='#FFFFFF'>".GetTeamName($SQLObj0,3)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=4'><font color='#FFFFFF'>".GetTeamName($SQLObj0,4)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=5'><font color='#FFFFFF'>".GetTeamName($SQLObj0,5)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=6'><font color='#FFFFFF'>".GetTeamName($SQLObj0,6)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=7'><font color='#FFFFFF'>".GetTeamName($SQLObj0,7)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=8'><font color='#FFFFFF'>".GetTeamName($SQLObj0,8)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=9'><font color='#FFFFFF'>".GetTeamName($SQLObj0,9)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=10'><font color='#FFFFFF'>".GetTeamName($SQLObj0,10)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=11'><font color='#FFFFFF'>".GetTeamName($SQLObj0,11)."</font></a>";?></div></td>
        <td width="58" bgcolor="#<?php echo COLOR2;?>"><div align="center" class="style17"><?php echo "<a href='res_teamschedule.php?teamid=12'><font color='#FFFFFF'>".GetTeamName($SQLObj0,12)."</font></a>";?></div></td>
        <td bgcolor="#<?php echo COLOR2;?>"><div align="center"></div></td>
      </tr>
  </table>
	<span class="style18"><br />
</span><span class="style18"><br />
</span>
</div>

<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>