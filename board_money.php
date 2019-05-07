<?php
session_start();
extract($_POST);
extract($_GET);
include_once(dirname(__FILE__)."/connect.php");

//取得最近一次的score_log
$str = "SELECT * FROM myteam_data ORDER BY money DESC LIMIT 0,20";
$SQLObj0->RunSQL($str);
if($nrows = $SQLObj0->LinkAll())
{
	$a_id = $SQLObj0->GetData('ID');
	$a_teamname = $SQLObj0->GetData('NAME');
	$a_point = $SQLObj0->GetData('POINTS');
	$a_money = $SQLObj0->GetData('MONEY');
}
//取得最新的資料
$str = "SELECT * FROM log_pricemove ORDER BY datetime DESC";
$SQLObj0->RunSQL($str);
$SQLObj0->LinkNext();
$datetime = $SQLObj0->GetData('DATETIME');
//echo $datetime."<BR>";
$date = substr($datetime,0,10);
$mm = substr($datetime,5,2);
$dd = substr($datetime,8,2);
for($i=0;$i<$nrows;$i++)
{
	if($a_id[$i])
	{
		//取得玩家id
		$str = "SELECT * FROM myteam_index WHERE myteam_id=".$a_id[$i];
		$SQLObj0->RunSQL($str);
		$SQLObj0->LinkNext();
		$user_id = $SQLObj0->GetData('USER_ID');

		if(!empty($user_id))
		{
			$str = "SELECT * FROM ".$ini_array['system']['dbpublic'].".user_data WHERE id=".$user_id;
			$SQLObj0->RunSQL($str);
			$SQLObj0->LinkNext();
			$a_username[$i] = $SQLObj0->GetData('nickname');
			$a_userid[$i] = $SQLObj0->GetData('ID');
		}
		$a_teamname[$i] = "<a href='res_roster.php?myteamid=".$a_id[$i]."&mm=".$mm."&dd=".$dd."'>".$a_teamname[$i]."</a>";
		//echo $a_teamname[$i]."<BR>";
		$a_money[$i] = ShowPrice1($a_money[$i]);
		if(empty($a_point[$i]))
			$a_point[$i] = 0;
		if(empty($a_money[$i]))
			$a_money[$i] = 0;
			
		$a_honor[$i] = GetHonor($SQLObj0,$user_id);
	}
}
//var_dump($a_teamname);
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

<div id="headerSection"><span class="pageTitle">資產排行榜</span><br/>
</div>
<p class="line">&nbsp;</p><br>
	



<div class="bgbox">
    <div class="pad5"><!--|
        <a href="/baseball/fullseason/ultimate/rts/rts.html" class=red target=_blank>Live Standings</a>-->
    </div>
<table class="v12 infotable">
       <tr>             
        <th class="tleft border">Rank</th>
        <th class="tleft">隊徽</th>
        <th class="tleft"><span class="tcenter border">球隊名稱</span></th>
        <th class="tcenter border">榮譽</th>
        <th>玩家名稱</th>

        <th>▽球隊資產</th>
	    <th class="border tcenter">本季積分</th>
        </tr>		
     <?php
		 for($i=0;$i<20;$i++)
		 {
		 //避免同分情形
		if($i>0 && $a_money[$i] == $a_money[$i-1])
		{
			//不做任何事以延續上一個rank
		}
		else
		{
			$nowrank = $i+1;
		}
		$rankmove = '';
		$m_rank = GetMoneyRank($SQLObj0,$a_id[$i]);
		$last_m_rank = GetLastMoneyRank($SQLObj0,$a_id[$i]);
		$rankmove=" (";
		
		  if($m_rank > $last_m_rank && $last_m_rank != 0)
		  {
			$rankmove=$rankmove."<img src='images/down.gif'>".($m_rank-$last_m_rank);
		  }
		  else if($m_rank < $last_m_rank)
		  {
			$rankmove=$rankmove."<img src='images/up.gif'>".($last_m_rank-$m_rank);
		  }
		  else
		  {
			$rankmove=$rankmove."<img src='images/up.gif'>-";
		  }
		
		  $rankmove=$rankmove.") ";
	 	if($i%2)
		{
	 		?><tr class="even"><?php
		}
		else
		{
			?><tr class="odd"><?php
		}	
		?>
            <td class="tleft border nowrap"><?php echo $nowrank.$rankmove;?></td>
            <td class="tleft nowrap"><?php echo GetIcon24($a_userid[$i]);?></td>
            <td class="tleft nowrap"><?php echo $a_teamname[$i];?></td>
      		<td class="tcenter border nowrap"><?php            		     
                     	 for($j=0;$j<$a_honor[$i];$j++)
                         	echo "<img src=images/star.gif>";
                         ?></td>
            <td><?php echo $a_username[$i];?></td>
            <td><?php echo $a_money[$i];?></td>
    		<td class="border"><?php echo $a_point[$i];?></td>
   		</tr>
        <?php
		}
		?>
</table>

</div>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>