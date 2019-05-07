<?php /* Smarty version 2.6.16, created on 2007-07-03 02:36:11
         compiled from login.tpl.php */ ?>
<div id="login">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="class_table">
    <?php if ($_SESSION['loginid']): ?>
    <tr class="row-white">
        <td align="right" valign="bottom">
            帳號：<?php echo $_SESSION['USERDATA']['account']; ?>
 | 
            <!--
            <span id="" 
                onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                onmouseout="this.style.textDecoration='none';" 
                onclick="javascript:top.location.href = '/changepwd.php';" >
            修改密碼
            </span> | 
            //-->
            <span id="LoingBtn" 
                onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                onmouseout="this.style.textDecoration='none';" 
                onclick="javascript:top.location.href = '/logout.php';" >
            登出
            </span>
        </td>
    </tr>
    <?php else: ?>
    <form name="form1" action="<?php echo $_SERVER['PHP_SELF']; ?>
" method="POST" onkeypress="if(event.keyCode == 13) CheckAndSubmit();">
    <input type="hidden" id="action" name="action" value="0" />
    <tr class="row-white">
        <td align="right" valign="bottom">
            <!--
    		帳號：<input id="account" name="account" type="text" size="6" maxlength="12"> 
			密碼：<input id="password" name="password" type="password" size="6" maxlength="8"> 
            <span id="LoingBtn" 
                onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                onmouseout="this.style.textDecoration='none';" 
                onclick="CheckAndSubmit();">
            登入
            </span>
             | 
             //-->
            <span id="RegisterBtn" 
                onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                onmouseout="this.style.textDecoration='none';" 
                onclick="top.location.href='/';">
            登入
            </span>
            <!--
             | 
            <span id="RegisterBtn" 
                onmouseover="javascript:this.style.cursor='hand';this.style.textDecoration='underline';" 
                onmouseout="this.style.textDecoration='none';" 
                onclick="ForgetPwd();">
            忘記密碼
            </span>
            //-->
        </td>
    </tr>
    </form>
    <?php endif; ?>
    </table>
</div>
<?php echo '
<script language="javascript">
<!--
function ForgetPwd()
{
    window.location.href = "password.php";
}
//-->
</script>
'; ?>