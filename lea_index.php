<?php
session_start();
extract($_POST);
extract($_GET);
include(dirname(__FILE__)."/check.php");
include_once(dirname(__FILE__)."/connect.php");

//取得聯盟名稱
$str = "SELECT * FROM lea_data WHERE id=".$_SESSION['leaid'];
$SQLObj0->RunSQL($str);
if($SQLObj0->LinkNext())
{
	$leaname = $SQLObj0->GetData("NAME");
	$txt = $SQLObj0->GetData("TXT");
}
	
//取得所有的隊伍id
$str = "SELECT * FROM lea_index WHERE lea_id=".$_SESSION['leaid'];
$SQLObj0->RunSQL($str);
if($count = $SQLObj0->LinkAll())
	$a_teamid = $SQLObj0->GetData("TEAM_ID");

for($i=0;$i<$count;$i++)
{
	$str = "SELECT * FROM myteam_data WHERE ID =".$a_teamid[$i];
	$SQLObj0->RunSQL($str);
	$SQLObj0->LinkNext();
	$a_teamname[$i] = $SQLObj0->GetData("NAME");
	$a_points[$i] = $SQLObj0->GetData("POINTS");
	$a_money[$i] = $SQLObj0->GetData("MONEY");
	$a_lastpoints[$i] = GetTeamLastPoints($SQLObj0,$a_teamid[$i]);
	$a_userid[$i] = GetUserIDByMyTeamID($SQLObj0,$a_teamid[$i]);
	$a_nickname[$i] = GetUserNameByMyTeamID($SQLObj0,$a_teamid[$i]);
	$a_honor[$i] = GetHonor($SQLObj0,$a_userid[$i]);
}
//依據積分排序資料
array_multisort($a_points,SORT_DESC,SORT_NUMERIC,$a_teamid,$a_teamname,$a_money,$a_lastpoints,$a_userid,$a_nickname,$a_honor);

//取得最新的資料時間
$str = "SELECT * FROM log_pricemove ORDER BY datetime DESC";
$SQLObj0->RunSQL($str);
$SQLObj0->LinkNext();
$datetime = $SQLObj0->GetData('DATETIME');
//echo $datetime."<BR>";
$date = substr($datetime,0,10);
$yy = substr($datetime,0,4);
$mm = substr($datetime,5,2);
$dd = substr($datetime,8,2);

//論壇 玩家討論區前五筆//
$array_discuz = get_threads_by_fid($SQLObj0, 2);
$array_news   = get_threads_by_fid($SQLObj0, 5, 10);

//取得最近5則聯盟msg
$str = "SELECT * FROM lea_msg WHERE lea_id=".$_SESSION['leaid']." ORDER BY `datetime` DESC LIMIT 0,5";
$SQLObj0->RunSQL($str);
if($msgcount = $SQLObj0->LinkAll())
{
	$a_msg['datetime'] = $SQLObj0->GetData('DATETIME');
	$a_msg['userid']= $SQLObj0->GetData('USER_ID');
	$a_msg['txt'] = $SQLObj0->GetData('TXT');
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

<p class="line">&nbsp;</p>
<div id="headerSection">
    <span class="pageTitle"><?php echo $leaname;?></span>
    <p class="dottedLine">&nbsp;</p>
    <div class="v12"><?php echo $txt;?></div>
</div>  
<p class="line">&nbsp;</p>
<div id="frontoffice">
<div class="leftCol">
        
    
<div id="standings" class="bgbox">
    <div id="standings_1" class="active_body">
  <table cellspacing="0" cellpadding="0" class="data_header">
            <tr>
                <td class="title">聯盟排行榜                </td>
<td align="right"><?php echo $yy."-".$mm."-".$dd;?>的成績</td>
        </tr>
        </table>            
        <div class="standings_inside">        
            <table class="data topLine" style="table-layout: fixed">
                <col width="10%" />
                <col width="10%" />
                <col width="auto" />
                <col width="10%" />
                <col width="15%" />

               	<tr>
            		<th class="tcenter border">排名</th>
                    <th class="tcenter border">隊徽</th>
            		<th class="tleft border">隊伍名稱</th>
            		<th class="tcenter border">榮譽</th>
            		<th class="tright border">最新積分</th>
            		<th class="tright">總積分</th>
              	</tr>
              	<?php
              	for($i=0;$i<$count;$i++)
              	{
              		if($i%2){
              			?><tr class="even"><?php
              		} else {
              			?><tr class="odd"><?php
              		}
              		?>
              		<td class="tcenter border"><?php echo ($i+1);?></td>
               		     <td class="tcenter border"><?php echo GetIcon24($a_userid[$i]);?></td>
            		     <td class="ellipsis border"><?php echo "<a href='res_roster.php?myteamid=".$a_teamid[$i]."&mm=".$mm."&dd=".$dd."'>".$a_teamname[$i]."</a>";?></td>
            		     <td class="tcenter border">
            		     <?php            		     
                     	 for($j=0;$j<$a_honor[$i];$j++)
                         	echo "<img src=images/star.gif>";
                         ?>
                        </td>
            		     <td class="tright border"><?php echo $a_lastpoints[$i];?></td>
            		     <td class="tright"><?php echo $a_points[$i];?></td>
            		</tr>
            		<?php
              	}
              	?>
            		     
            </table>
            
        	 
        </div>
    </div>

    
<table border="0" cellspacing="0" cellpadding="0" id="footnote" class="standings">
<tr>
    <td class="tleft i">&nbsp;</td>

    <td align="right"></td>
</tr>
</table>

</div>

<br />
    
</div>
<div class="rightCol"> 

    
<table class="tableTitle">
    <tr class="dark">

        <td class="title">系統公告</td>
        <td class="titleLink">&nbsp;</td>
  </tr>

</table>

<table class="inbox">
    
            <tr>
                <td style="padding-top: 6px" class="b">時間</td>
                <td style="padding-top: 6px" class="b">標題</td>
            </tr>        
         <?php
         for($i=0;$i<5;$i++)
		 {
		 ?>
            <tr>
                <td class="i"><?php echo $array_news[$i]['lastpost'];?></td>

                <td><?php echo "<a href='".$array_news[$i]['link']."'>".$array_news[$i]['subject']."</a>";?></td>
            </tr>
          <?php
		  }
		  ?>
</table>
<BR>
<script type="text/javascript"><!--
google_ad_client = "pub-9317450467103032";
/* 聯盟首頁300x250, 已建立 2008/3/10 */
google_ad_slot = "3713341484";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<BR>

<BR>
<table class="tableTitle">
    <tr class="dark">

        <td class="title">
            聯盟留言板
        </td>
        <td class="titleLink"><a href="lea_msg.php">進入聯盟留言板</a> </td>
  </tr>

</table>

<table class="inbox">
    <col width="15%" />
    <col width="30%" />
    <col width="auto" />
            <tr>
                <td style="padding-top: 6px" class="b">時間</td>
              <td style="padding-top: 6px" class="b">發言人</td>
              <td style="padding-top: 6px" class="b">標題</td>
  </tr>        
  <?php 
  for($i=0;$i<$msgcount;$i++)
  {
  	?>
  	<tr>
        <td class="i"><?php echo substr($a_msg['datetime'][$i],5,5);?></td>
        <td><?php echo GetNickname($SQLObj0,$a_msg['userid'][$i]);?></td>
        <td><?php echo strip_tags(substr($a_msg['txt'][$i],0,20));?>...</td>
    </tr>
    <?php
  }
   ?>         
</table>
<BR>
<table class="tableTitle">
    <tr class="dark">

<td class="title">
            連結</td>
        <td class="titleLink">&nbsp;</td>
    </tr>

</table>

<table class="inbox">
    
            <tr>
                <td class="b" style="padding-top: 6px">● <a href="http://npb.club.tw/">日本職棒促進會<br>
                  <br>
                </a>● <a href="http://npb.club.tw/89ch.php">一平大的先発予想<br>
                <br>
                </a>● <a href="http://baseball.yahoo.co.jp/npb/">Yahoo!プロ野球</a></td>
            </tr>
</table>

</div>
<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>