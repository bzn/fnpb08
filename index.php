<?php
/*********************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
*********************************************************************************************/

/*********************************************************************************************
SESSION
*********************************************************************************************/
if ($_COOKIE['PHPSESSID'])	session_id($_COOKIE['PHPSESSID']);
session_start();
header("Cache-control: private");
header("Content-type: text/html; charset=UTF-8");

/*********************************************************************************************
INCLUDE
*********************************************************************************************/
include_once("connect.php");

/*********************************************************************************************
BASIC SETTINGS
*********************************************************************************************/

/*********************************************************************************************
ACTION
*********************************************************************************************/
if($_POST['action'])
{
    switch ($_POST['action'])
    {
        case LOGIN :
            $sqlstr = '
            SELECT * FROM `'.$ini_array['system']['dbpublic'].'`.`user_data` 
            WHERE 1 AND `account` = \''.$_POST['account'].'\'';
            $SQLObj0->RunSQL($sqlstr);
            //檢查帳號是否存在//
            if($SQLObj0->LinkNext())
            {
                //取得資料//
                $id          = $SQLObj0->GetData('id');
                $password    = $SQLObj0->GetData('password');
                $nickname    = $SQLObj0->GetData('nickname');
                //MD5解密//
                $password = md5_decrypt($password, $ini_array['system']['md5']);
                //比對密碼//
                if($password === $_POST['password'])
                {
                    //使用者資訊//
                    $_SESSION['USERDATA'] = $SQLObj0->GetData1(0);
                    //註冊SESSION//
                    if($_POST['remember'] == 'Y')
                    {
                        setcookie("loginid", md5_encrypt($id, $ini_array['system']['md5']),time()+60*60*24*365,"",$_SERVER['HTTP_HOST']);
                        setcookie("account", md5_encrypt($_POST['account'], $ini_array['system']['md5']),time()+60*60*24*365,"",$_SERVER['HTTP_HOST']);
                    }
                    $_SESSION['loginid']  = $id;
                    $gmnow = gmdate("Y-m-d H:i:s",gmmktime(gmdate("H")+8,gmdate("i"),gmdate("s"),gmdate("m"),gmdate("d"),gmdate("Y")));
                    $sqlstr = "
		            SELECT * FROM `mumutoys_npb0801`.`myteam_index` 
		            WHERE 1 AND `user_id` = '".$_SESSION['loginid']."'";
		            $SQLObj0->RunSQL($sqlstr);
		            //避免不活躍
		            if($SQLObj0->LinkNext())
		            {
                        if($_POST['remember'] == 'Y')
                        {
                            setcookie("myteamid0801", md5_encrypt($SQLObj0->GetData('myteam_id'), $ini_array['system']['md5']),time()+60*60*24*365,"",$_SERVER['HTTP_HOST']);
                        }
		                $_SESSION['myteamid0801'] = $SQLObj0->GetData('myteam_id');
                    	$sqlstr = "UPDATE `mumutoys_npb0801`.`myteam_data` SET `lastlogin`='".$gmnow."' 
                        	       WHERE 1 AND `id`='".$_SESSION['myteamid0801']."'";
                    	$SQLObj0->RunSQL($sqlstr);
		            }
                }
                else 
                {
                    $err_msg = '密碼不正確!!';
                }
            }
            else 
            {
                $err_msg = '無此帳號!!';
            }
            break;
        default :
            break;
    }
}

/*********************************************************************************************
HTML
*********************************************************************************************/
$htmlobj    = new html();
$title      = $ini_array['html']['title'];
$meta       = $ini_array['html']['meta'];
$css        = '
<LINK href="/css/css.css" rel="stylesheet" type="text/css">
<style type="text/css">
.spiffy{
    display:block;
}
.spiffy *{
    display:block;
    height:1px;
    overflow:hidden;
    background:#BAD1E8;
}
.spiffy1{
    border-right:1px solid #e1ebf5;
    padding-right:1px;
    margin-right:3px;
    border-left:1px solid #e1ebf5;
    padding-left:1px;
    margin-left:3px;
    background:#cbdced;
}
.spiffy2{
    border-right:1px solid #f8fafc;
    border-left:1px solid #f8fafc;
    padding:0px 1px;
    background:#c7d9ec;
    margin:0px 1px;
}
.spiffy3{
    border-right:1px solid #c7d9ec;
    border-left:1px solid #c7d9ec;
    margin:0px 1px;
}
.spiffy4{
    border-right:1px solid #e1ebf5;
    border-left:1px solid #e1ebf5;
}
.spiffy5{
    border-right:1px solid #cbdced;
    border-left:1px solid #cbdced;
}
.spiffy_content{
    padding:0px 5px;
    background:#BAD1E8;
    color: #000000;
}
.login_div{
    padding:5px;
    border: 1px solid #BAD1E8;
    /*
    background:#BAD1E8;
    */
    color: #000000;
}
.season{
    display:block;
}
.season *{
    display:block;
    height:1px;
    overflow:hidden;
    background:#336699;
}
.season1{
    border-right:1px solid #a7bdd3;
    padding-right:1px;
    margin-right:3px;
    border-left:1px solid #a7bdd3;
    padding-left:1px;
    margin-left:3px;
    background:#668cb2;
}
.season2{
    border-right:1px solid #eaeff4;
    border-left:1px solid #eaeff4;
    padding:0px 1px;
    background:#5983ac;
    margin:0px 1px;
}
.season3{
    border-right:1px solid #5983ac;
    border-left:1px solid #5983ac;
    margin:0px 1px;
}
.season4{
    border-right:1px solid #a7bdd3;
    border-left:1px solid #a7bdd3;
}
.season5{
    border-right:1px solid #668cb2;
    border-left:1px solid #668cb2;
}
.season_content{
    padding:0px 5px;
    background:#336699;
    color:#ffffff;
    font:16px bold;
    cursor:pointer;
} 
a:visited {color: #0000CC;}
a:link {color: #0000CC;}
a{text-decoration:none ; } 
a:hover {text-decoration:none ; }
</style>
';
$javascript = '
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-252630-3";
urchinTracker();
</script>
<script language="javascript" type="text/javascript" src="js/MenuSwitch.js"></script>
<script language="javascript" type="text/javascript">
<!--
function CheckAndSubmit()
{
    var error    = false;
    var errmsg   = "";
    var pattern  = /[^a-zA-Z0-9]+/;
    var account  = document.getElementById("account").value;
    var password = document.getElementById("password").value;
    if(account == "" || account.length == 0)
    {
        errmsg += "帳號不可空白!!\n";
        error   = true;
    }
    if(password == "" || password.length == 0)
    {
        errmsg += "密碼不可空白!!\n";
        error   = true;
    }
    if(pattern.test(account) || pattern.test(password))
    {
        errmsg += "帳號密碼不可含有特殊字元及空白!!\n";
        error   = true;
    }
    if(error)
    {
        //alert(errmsg);
        var err_msg_node = document.createTextNode(errmsg);
        var err_msg_div  = document.getElementById("err_msg");
        err_msg_div.appendChild(err_msg_node);
        return false;
    }
    else
    {
        document.getElementById("action").value = '.LOGIN.';
        return true;
    }
}
function GoRegister()
{
    window.location.href = "register.php";
}
function NewsSwitch(id)
{
    var content_id = "news_content_" + id;
    var content    = document.getElementById(content_id);
    if(content)
    {
        if(content.style.display == "none")
        {
            content.style.display = "";
        }
        else
        {
            content.style.display = "none";
        }
    }
}
//-->
</script>';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<form name="form1" action="'.$_SERVER['PHP_SELF'].'" method="post" onsubmit="return CheckAndSubmit();">
<input type="hidden" name="action" value="'.LOGIN.'">
<div style="padding:2px;">
    <table>
    <!--
    上排的圓邊Bar
    //-->
    <tr>
        <td width="40%"><a href="/" target="_top"><img src="/images/logo.gif" style="border:0;"></a></td>
        <td width="60%">
            <b class="spiffy">
                <b class="spiffy1"><b></b></b>
                <b class="spiffy2"><b></b></b>
                <b class="spiffy3"></b>
                <b class="spiffy4"></b>
                <b class="spiffy5"></b>
            </b>
            <div class="spiffy_content">
            <!-- Your Content Goes Here -->
            '.$ini_array['html']['title'].'
            </div>
            <b class="spiffy">
                <b class="spiffy5"></b>
                <b class="spiffy4"></b>
                <b class="spiffy3"></b>
                <b class="spiffy2"><b></b></b>
                <b class="spiffy1"><b></b></b>
            </b>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%">
            <tr>
';
if(empty($_SESSION['loginid']))
{
    $html .= '
                <td>
                    <!--
                    右邊連結區塊
                    //-->
                    <table>
                        <tr>
                            <td colspan="2">
                                <li><font color="red"><b>什麼是Fantasy NPB</b></font></li>
                                    <blockquote>
                                    在Fanstasy NPB裡你可以組織一支你的夢幻球隊，你選擇的球員在現實比賽中表現，會影響到你球隊當日的積分，
                                    只要球隊資金足夠，你可以買進任何喜愛的球員來為你的隊伍效力。
                                    </blockquote>
                                <li><font color="red"><b>08球季全新出發</b></font></li>
                                    <blockquote>
                                   新的一季，我們更新了球員的資料，並調整球員身價，讓遊戲更有挑戰性。我們還新增加了榮譽系統和聯盟系統，
                                   玩家現在可以組織自己的小型聯盟，邀請你的好友或是其他玩家來相互較勁。<font color="red"></font>
                                    </blockquote>
                                <li><font color="red"><b>歡迎新的玩家加入</b></font></li>
                                    <blockquote>
                                    Fantasy NPB是一個完全免費的遊戲，而且非常歡迎新玩家加入，也希望老鳥玩家們可以協助新手適應這個遊戲，
                                    因為球隊越多，遊戲體驗將會越好玩。<font color="red"></font>
                                    </blockquote>
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top" width="240">
                    <!--
                    登入區塊
                    //-->
                    <div class="login_div">
                        <table width="240">
                            <tr>
                                <td colspan="2"><center><img src="http://npb.ohdada.com/images/ohdada_s.gif"></td>
                            </tr>
                            <tr>
                                <td align="right">帳號：</td>
                                <td><input id="account" name="account" type="text" maxlength="12"> </td>
                            </tr>
                            <tr>
                                <td align="right">密碼：</td>
                                <td><input id="password" name="password" type="password"></td>
                            </tr>
                            <tr>
                                <td align="right"></td>
                                <td>
                                <div id="err_msg" style="color:'.COLOR_RED.';">'.$err_msg.'</div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><center><input type="checkbox" name="remember" value="Y">在這台電腦上記得我。</td>
                            </tr>
                            <tr>
                                <td colspan="2"><center><input type="submit" value="送 出" class="class_btn"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="login_div" style="margin-top:4px;">
                    <table width="240">
                        <tr>
                            <td colspan="2"><center>
                                <a href="register1.php">註冊會員</a> | 
                                <a href="password.php">忘記密碼</a>
                            </td>
                        </tr>
                    </table>
                    </div>
                </td>
                    ';
}
else 
{
    $sqlstr = "SELECT COUNT(*) AS `cnt_team` FROM `mumutoys_npb0801`.`myteam_data`";
    $SQLObj0->RunSQL($sqlstr);
    $SQLObj0->LinkNext();
    $cnt_team_season1 = $SQLObj0->GetData('cnt_team');
    
    //暫定
    //$cnt_team_season1 = 0;
    
    $sqlstr = "SELECT COUNT(*) AS `cnt_team` FROM `mumutoys_npb0801`.`myteam_data`";
    $SQLObj0->RunSQL($sqlstr);
    $SQLObj0->LinkNext();
    $cnt_team_season2 = $SQLObj0->GetData('cnt_team');

    $html .= '
                <td>
                    <!--
                    SEASON1
                    //-->
                    <a href="/0801/lea_index.php">
                    <b class="season">
                        <b class="season1"><b></b></b>
                        <b class="season2"><b></b></b>
                        <b class="season3"></b>
                        <b class="season4"></b>
                        <b class="season5"></b>
                    </b>
                    <div class="season_content">
                    <!-- Your Content Goes Here -->
                    Fantasy NPB 08 （開放參賽）
                    </div>
                    <b class="season">
                        <b class="season5"></b>
                        <b class="season4"></b>
                        <b class="season3"></b>
                        <b class="season2"><b></b></b>
                        <b class="season1"><b></b></b>
                    </b>
                    </a>
                    <div align="right">
                        目前共有<span style="color:'.COLOR_RED.';">'.$cnt_team_season1.'</span>隊伍在競爭!!
                    </div>
                    <br/>
                    <!--
                    SEASON2
                    //-->
                    
                </td>
                <td valign="top" width="240">
                    <div class="login_div">
                    <table>
                        <tr>
                            <td><span style="font:16px bold;">喔! <b>'.$_SESSION['USERDATA']['nickname'].'</b> 大大!!<span></td>
                        </tr>
                        <tr>
                            <td>
                                <li><a href="modify.php">修改個人資料</a></li>
                                <li><a href="changepwd.php">修改密碼</a></li>
                                <li><a href="mailauth.php">寄送認證信(請確認您的Email無誤)</a></li>
                                <li><a href="logout.php">登出</a></li>
                            </td>
                        </tr>
                    </table>
                    </div>
                </td>
            ';
}
$html .= '
          	</tr>
            </table>
        </td>
    </tr>
    <!--
    底下的圓邊Bar
    //-->
    <tr>
        <td colspan="2">
            <b class="spiffy">
                <b class="spiffy1"><b></b></b>
                <b class="spiffy2"><b></b></b>
                <b class="spiffy3"></b>
                <b class="spiffy4"></b>
                <b class="spiffy5"></b>
            </b>
            <div class="spiffy_content" align="center">
            <!-- Your Content Goes Here -->
                ©2007 OH!DADA - 
                <a href="http://npb.ohdada.com/about_faq.php">什麼是Fantasy NPB</a> - 
                <a href="http://npb.club.tw/viewforum.php?f=93">討論區</a> - 
                <a href="mailto:npb@ohdada.com">聯絡我們</a>
            </div>
            <b class="spiffy">
                <b class="spiffy5"></b>
                <b class="spiffy4"></b>
                <b class="spiffy3"></b>
                <b class="spiffy2"><b></b></b>
                <b class="spiffy1"><b></b></b>
            </b>
        </td>
    </tr>
</div>
</form>
';

/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
include_once("include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("index1.tpl.php");

/*season2 如果有的話
				<a href="/season2/">
                    <b class="season" onclick="location.href=\'http://'.$_SERVER['HTTP_HOST'].'/season2/\';">
                        <b class="season1"><b></b></b>
                        <b class="season2"><b></b></b>
                        <b class="season3"></b>
                        <b class="season4"></b>
                        <b class="season5"></b>
                    </b>
                    <div class="season_content">
                    <!-- Your Content Goes Here -->
                    SEASON 2 （開放參賽中,7/24正式開賽）
                    </div>
                    <b class="season">
                        <b class="season5"></b>
                        <b class="season4"></b>
                        <b class="season3"></b>
                        <b class="season2"><b></b></b>
                        <b class="season1"><b></b></b>
                    </b>
                    </a>
                    <div align="right">
                        目前共有<span style="color:'.COLOR_RED.';">'.$cnt_team_season2.'</span>隊伍在競爭!!
                    </div>*/
?>           