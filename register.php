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
$RandomText = GetRandText(4);

/*********************************************************************************************
ACTION
*********************************************************************************************/
if($_POST['action'])
{
    switch ($_POST['action'])
    {
        case REGISTER :
            //檢查是否有相同的帳號存在//
            $sqlstr = 'SELECT * FROM '.$ini_array['system']['dbname'].'.user_data 
                       WHERE 1 AND account = \''.$_POST['account'].'\'';
            $SQLObj0->RunSQL($sqlstr);
            if(!$SQLObj0->LinkNext())
            {
                $sqlstr = 'INSERT INTO '.$ini_array['system']['dbname'].'.user_data(account,password,nickname,createtime,email) 
                           VALUES(\''.$_POST['account'].'\',\''.md5_encrypt($_POST['password'],$ini_array['system']['md5']).'\',
                           \''.$_POST['nickname'].'\',NOW(),\''.$_POST['email'].'\')';
                if($SQLObj0->RunSQL($sqlstr))
                {
                    $js = '
                        top.location.href = "/";
                        alert(\'註冊成功!!\');
                    ';
                }
                
            }
            else 
            {
                $js = 'alert(\'已經有相同的帳號存在!!\');';
            }
            break;
    }
}

if(!empty($js))
{
    echo '
        <SCRIPT language="javascript">
        <!--
        '.$js.'
        //-->
        </SCRIPT>
    ';
}

/*********************************************************************************************
SELECT FROM DB
*********************************************************************************************/


/*********************************************************************************************
HTML
*********************************************************************************************/
$htmlobj    = new html();
$title      = $ini_array['html']['title'];
$meta       = $ini_array['html']['meta'];
$css        = '
<LINK href="css/css.css" rel="stylesheet" type="text/css">';
$javascript = '
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-252630-3";
urchinTracker();
</script>
<script language="javascript" type="text/javascript" src="js/prototype/prototype.js"></script>
<script language="javascript" type="text/javascript" src="js/MyEngine.js"></script>
<script language="javascript" type="text/javascript">
<!--
function CheckAndSubmit()
{
    var error    = false;
    var errmsg   = "";
    var pattern  = /^[a-zA-Z0-9]+$/;
    var pattern1 = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var account  = document.getElementById("account").value;
    var password = document.getElementById("password").value;
    var key      = document.getElementById("key").value;
    var randtext = document.getElementById("randtext").value;
    var email    = document.getElementById("email").value;
    var nickname = document.getElementById("nickname").value;
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
    if(!pattern.test(account) || !pattern.test(password))
    {
        errmsg += "帳號密碼不可含有特殊字元及空白!!\n";
        error   = true;
    }
    if(nickname == "" || nickname.length == 0)
    {
        errmsg += "暱稱不可空白!!\n";
        error   = true;
    }

    if(!pattern1.test(email))
    {
        errmsg += "E-MAIL格式錯誤!!\n";
        error   = true;
    }
    if(key != randtext)
    {
        errmsg += " 驗證碼錯誤!!\n";
        error   = true;
    }
    if(error)
    {
        alert(errmsg);
        return;
    }
    else
    {
        document.getElementById("action").value = '.REGISTER.';
        document.form1.submit();
    }
}
function CheckAccount()
{
    var account  = document.getElementById("account").value;
    if(account == "")
    {
        alert(\'帳號不可空白!!\');
        return false;
    }
    var url      = \'/ajax/CheckAccount.php\';
    var pars     = \'account=\' + encodeURI(account);
    var myAjax   = new Ajax.Request(
        url,
        {
            method : \'post\',
            parameters : pars,
            onComplete : ShowResult
        }
    );
}
function ShowResult(originalRequest)
{
    //alert(originalRequest.responseText);
    var xmldoc = originalRequest.responseXML;
    var data   = xmldoc.getElementsByTagName("data")[0];
    var result = data.getElementsByTagName("result")[0].firstChild.nodeValue;
    if(result * 1)
    {
        $("result").innerHTML = "帳號可以使用 ";
    }
    else
    {
        $("result").innerHTML = "帳號不可使用 ";
    }
}

var myGlobalHandlers = {
    onCreate : function()
    {
        Engine.showLoadingImg()
    },
    onComplete : function()
    {
        if(Ajax.activeRequestCount == 0)
        {
            Engine.hideLoadingImg();
        }
    }
}

Ajax.Responders.register(myGlobalHandlers);
//-->
</script>';
$htmlobj->settext($title, $meta, $css, $javascript);

$html = '
<div>
<form name="form1" action="'.$_SERVER['PHP_SELF'].'" method="POST">
<input type="hidden" id="action" name="action" value="0">
<input type="hidden" id="randtext" name="randtext" value="'.$RandomText.'">
<table cellspacing="1" cellpadding="2" width="350" bgcolor="#DDDDDD">
    <tr class="row-title"><th colspan="2">註冊</th></tr>
    <tr class="row-white">
        <td align="right">帳號：</td>
        <td>
            <input type="text" id="account" name="account" size="9" maxlength="8"  value="'.$_POST['account'].'">
            <span id="result" style="color:'.COLOR_ORANGERED.';"></span>
            <br><span id="CheckAccountBtn" 
                onmouseover="javascript:this.style.cursor=\'hand\';this.style.textDecoration=\'underline\';" 
                onmouseout="this.style.textDecoration=\'none\';" 
                onclick="CheckAccount();">
            檢查帳號
            </span>
        </td>
    </tr>
    <tr class="row-white">
        <td align="right">密碼：</td>
        <td><input type="password" id="password" name="password" size="9" maxlength="8"></td>
    </tr>
    <tr class="row-white">
        <td align="right">暱稱：</td>
        <td><input type="text" id="nickname" name="nickname" size="13" maxlength="12" value="'.$_POST['nickname'].'"></td>
    </tr>
    <tr class="row-white">
        <td align="right">E-MAIL：</td>
        <td>
            <input type="text" id="email" name="email" size="40" value="'.$_POST['email'].'">
            <br/>
            <span style="color:'.COLOR_ORANGERED.';">(查詢密碼用)</span>
        </td>
    </tr>
    <tr class="row-white">
        <td align="right">驗證碼：</td>
        <td valign="bottom"><input type="text" id="key" name="key" size="5" maxlength="4">
            <img src="include/ImageText.php?text='.$RandomText.'">
        </td>
    </tr>
    <tr class="row-white"><td colspan="2"><center>
        <span id="LoingBtn" 
            onmouseover="javascript:this.style.cursor=\'hand\';this.style.textDecoration=\'underline\';" 
            onmouseout="this.style.textDecoration=\'none\';" 
            onclick="CheckAndSubmit();">
        註冊
        </span>
    </td></tr>
</table>
</form>
</div>
';
/*********************************************************************************************
/* SMARTY ASSIGN
*********************************************************************************************/
$HideLoginWindow = 1;
include_once("include/SmartyAssign.inc.php");

/*********************************************************************************************
/* SMARTY DISPLAY
*********************************************************************************************/
$smarty->display("register.tpl.php");
?>