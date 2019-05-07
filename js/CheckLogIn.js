function CheckLogIn()
{
    var errmsg    = "";
    var pattern   = /^[0-9a-zA-Z]*$/;
    var loginname = $("loginname").value;
    var password  = $("password").value;
    if(loginname.length <= 0 || loginname == "")
    {
        errmsg += '帳號不可空白!!\n';
    }
    else
    if(!pattern.test(loginname))
    {
        errmsg += '帳號必須為(英文字與數字)之組合!!\n';
        loginname.value = '';
    }
    if(password <= 0 || password == "")
    {
        errmsg += '密碼不可空白!!\n';
    }
    else
    if(!pattern.test(password))
    {
        errmsg += '密碼必須為(英文字與數字)之組合!!\n';
    }
	if(errmsg.length > 0)
	{
		alert(errmsg);
		password.value = '';
	}
	else
	{
	    document.form1.submit();
	}
}