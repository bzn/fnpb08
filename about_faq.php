<?php
session_start();
extract($_POST);
extract($_GET);
//測試初始數據====================

//==============================
include_once(dirname(__FILE__)."/connect.php");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Fantasy NPB!! 夢幻NPB棒球</title> 	<META NAME="description" content="japan baseball fantasy game"> 	<META NAME="keywords" content="日本職棒,羅德,歐力士,大榮,火腿,西武,近鐵,巨人,養樂多,廣島,中日,橫濱,阪神,羅國輝,楊仲壽,陳金鋒,張誌家,許銘傑,林威助,陳偉殷,鈴木一朗,松井秀喜,棒球,baseball,風雲總教頭,fantasy game,大聯盟,mlb,日本職棒,npb,中華職棒,cpbl,遊戲,game">
	<link rel="stylesheet" href="css/fantasygames.css" type="text/css">
	<link rel="stylesheet" href="css/style2007.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">	
<style type="text/css">
<!--
.style18 {font-size: 12px}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
}
.style24 {color: #FFFFFF; font-size: 14px; }
.style26 {font-size: 12}
.style27 {color: #FF0000}
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
  <br>
  <table width="600" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
      <td height="20" bgcolor="#<?php echo COLOR2;?>"><span class="style24 style26">■ 什麼是Fantasy NPB</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="style26"><br>
        在Fanstasy NPB裡你可以組織一支你的夢幻球隊，你選擇的球員在現實比賽中表現，會影響到你球隊當日的積分，只要球隊資金足夠，你可以買進任何喜愛的球員來為你的隊伍效力。<br>
          <br>
      </span></td>
    </tr>
    <tr>
      <td height="20" bgcolor="#<?php echo COLOR2;?>"><span class="style24 style26"> ■ FNPB'08有什麼新東西? </span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="style18"><br>
        新的一季，我們更新了球員的資料，並調整球員身價，讓遊戲更有挑戰性。我們還新增加了榮譽系統，上一季得到好名次的玩家，現在可以看到自己的隊伍前面多了幾顆星星
，另外新增的聯盟系統，玩家現在可以組織自己的小型聯盟，邀請你的好友或是其他玩家來相互較勁。<br>
        <br>
      </span></td>
    </tr>
    <tr>
      <td height="20" bgcolor="#<?php echo COLOR2;?>"><span class="style24 style26">■ 積分是怎麼計算的</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="style26"><br>
        你旗下球員的當日表現，會被運算為積分加到你的隊伍分數裡面，積分越高你的球隊排名也就越前面，當然球員表現不好也是會有負分的情形，而投手和打者積分的算法是不一樣的。</span> <br>
        <br>
          <table width="400" border="0">
            <tr>
              <td><div align="center">
                <table width="100" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                  <tr>
                    <td colspan="2"><div align="center">打者</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">出局數</td>
                    <td bgcolor="#FFFFFF"><div align="right">-2</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">得分</td>
                    <td bgcolor="#FFFFFF"><div align="right">5</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">一壘打</td>
                    <td bgcolor="#FFFFFF"><div align="right">5</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">二壘打</td>
                    <td bgcolor="#FFFFFF"><div align="right">10</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">三壘打</td>
                    <td bgcolor="#FFFFFF"><div align="right">15</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">本壘打</td>
                    <td bgcolor="#FFFFFF"><div align="right">20</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">打點</td>
                    <td bgcolor="#FFFFFF"><div align="right">5</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">四死球</td>
                    <td bgcolor="#FFFFFF"><div align="right">3</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">三振</td>
                    <td bgcolor="#FFFFFF"><div align="right">-1</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">盜壘</td>
                    <td bgcolor="#FFFFFF"><div align="right">10</div></td>
                  </tr>
                </table>
              </div></td>
              <td><div align="center">
                <table width="100" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
                  <tr>
                    <td colspan="2"><div align="center">投手</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">勝投</td>
                    <td bgcolor="#FFFFFF"><div align="right">30</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">救援成功</td>
                    <td bgcolor="#FFFFFF"><div align="right">30</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">敗投</td>
                    <td bgcolor="#FFFFFF"><div align="right">-15</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">投球一局</td>
                    <td bgcolor="#FFFFFF"><div align="right">15</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">被安打</td>
                    <td bgcolor="#FFFFFF"><div align="right">-5</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">責失分</td>
                    <td bgcolor="#FFFFFF"><div align="right">-10</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">四死球</td>
                    <td bgcolor="#FFFFFF"><div align="right">-3</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">三振</td>
                    <td bgcolor="#FFFFFF"><div align="right">3</div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">&nbsp;</td>
                    <td bgcolor="#FFFFFF"><div align="right"></div></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF">&nbsp;</td>
                    <td bgcolor="#FFFFFF"><div align="right"></div></td>
                  </tr>
                </table>
              </div></td>
            </tr>
          </table>
            <br>
            舉例來說<br>
            A打者<span class="style26">今日4打數(出局數是<span class="style27">3</span>)，<span class="style27">1</span>支二壘打，有<span class="style27">2</span>分的打點和<span class="style27">2</span>次三振<br>
      -2 x <span class="style27">3</span> + 10 x<span class="style27"> 1</span> + 5 x <span class="style27">2</span>  - 1 x <span class="style27">2</span> = <strong>12 分</strong> <br>
            <br>
            B投手今日投球<span class="style27">6</span>局，被安打<span class="style27">3</span>支，自責分<span class="style27">2</span>分，並拿下<span class="style27">8</span>次三振<br>
15 x<span class="style27"> 6</span> - 5 x <span class="style27">3</span> - 10 x <span class="style27">2</span>  + 3 x <span class="style27">8</span> = <strong>79 分</strong> <br>
<br>
<span class="style27"><strong>[注意!!] 你必須買滿球隊所有的球員空位，系統才會幫你計分</strong></span><br>
      <br>
      </span></td>
    </tr>
    <tr>
      <td height="20" bgcolor="#<?php echo COLOR2;?>"><span class="style24 style26">■ 要怎麼交易球員</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="style26"><br>
        有的球員可能表現不佳，系統每個禮拜會發放有限的交易次數，讓你在金額許可的情形下交易出去，每週三(pm19:00)會發放3次投手交易次數，週五(pm19:00)發送3次打者交易，沒用完的交易次數是可以累積的，但是要注意的是，交易目前沒有辦法反悔到上一步。而在3/24開賽之前是可以任意交易的，並不會扣交易次數。<br>
          <br>
      </span></td>
    </tr>
    <tr>
      <td height="20" bgcolor="#<?php echo COLOR2;?>"><span class="style24 style26">■ 關於交易凍結</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="style26"><br>
        如果某名球員當天有比賽，那麼球員在比賽開始之後就會進入凍結狀態，在球賽開始到系統計算球員價錢漲跌的這段時間，球員的購買連結會失效，這個時候玩家不能夠買賣此名球員。因此你如果看準了某名球員要買(或賣)，必須在該場球賽開始之前就進行交易，這樣才會納入計分。<br>
        <br>
      </span></td>
    </tr>
    <tr>
      <td height="20" bgcolor="#<?php echo COLOR2;?>"><span class="style24 style26"> ■ 球員價錢的變動</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="style18"><br>
        遊戲中每支球隊所做的買賣，會影響到隔日球員的身價起伏，簡單的說，你在低價的時候買進的球員，假如日後其他隊伍也跟著買進，第二天這個球員的身價就會提升，而你再將他賣出的時候，你的球隊就可以賺到這個價差，進而有更多的資金可以運用，反之如果球員跌價，球隊的資金也會跟著變少<span class="style26">。</span><br>
        <br>
      </span></td>
    </tr>
    <tr>
      <td height="20" bgcolor="#<?php echo COLOR2;?>"><span class="style24 style26"> ■ 為什麼我看不到其他玩家的球員名單</span></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF"><span class="style18"><br>
        是的，為了避免玩家的調度被窺看，你只能看到其他玩家&quot;前一日&quot;比賽的陣容<span class="style26">。</span><br>
        <br>
      </span></td>
    </tr>
  </table>  
  <br />
	<br />

	<span class="style18"><br />
</span><span class="style18"><br />
</span>
</div>

<?php include(dirname(__FILE__)."/down.php");?>
</body>
</html>