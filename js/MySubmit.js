function EnterToSubmit(btn)
{
    //如果按下的是enter//
    //F2(113)
    if(event.keyCode == 113)
    {
        if(typeof(event.srcElement) != "textarea")
        {
            btn.click();
        }
    }
}

function MySubmit(frm, action)
{
    var isSubmit     = true;
    //檢查表單的欄位函式寫再每一支程式//
    if(!checkform(frm, action)) isSubmit = false;
    //表單送出//
    if(isSubmit)
    {
        frm.action.value = action;
        frm.submit();
    }
}