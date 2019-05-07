/*
檢查日期格式(YYYY-MM-DD)
*/
function CheckDateFormat(DateVal)
{
    try
    {
        var date_pattarn = /^[0-9]{4}[\-|\/]{1}([0][0-9]|[1][0-2])[\-|\/]{1}([0][0-9]|[1-2][0-9]|[3][0-1])$/ ;
        if(date_pattarn.test(DateVal.toString()))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    catch(e)
    {
        alert(e.toString());
    }
}
/*
檢查INPUT TEXT的日期格式
*/
function CheckDateInput(srcElement,defaultText)
{
    if(srcElement.value == defaultText) srcElement.value = "";
    if(srcElement.value != "")
    {
        if(!CheckDateFormat(srcElement.value))
        {
            alert('日期格式錯誤!!');
            srcElement.focus();
        }
    }
}
/*
檢查時間格式(HH:II)
*/
function CheckTimeFormat(TimeVal)
{
    try
    {
        var time_pattern = /^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/ ;
        if(time_pattern.test(TimeVal.toString()))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    catch(e)
    {
        alert(e.toString());
    }
}
/*
檢查INPUT TEXT的日期格式
*/
function CheckTimeInput(srcElement,defaultText)
{
    if(srcElement.value == defaultText) srcElement.value = "";
    if(srcElement.value != "")
    {
        if(!CheckTimeFormat(srcElement.value))
        {
            alert('時間格式錯誤!!');
            srcElement.focus();
        }
    }
}
/*
將日期(YYYY-MM-DD)與時間(MM:II)合併成(YYYY-MM-DD HH:II)
*/
function CombineDataTime(DateId, TimeId, DatatimeId)
{
    var DateVal = $(DateId).value;
    var TimeVal = $(TimeId).value;
    try
    {
        if(DateVal != "" && TimeVal != "")
        {
            if(CheckDateFormat(DateVal) && CheckTimeFormat(TimeVal))
            {
                $(DatatimeId).value = DateVal + " " + TimeVal;
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }
    catch(e)
    {
        alert(e.toString());
    }
}
/*
預設日期INPUT TEXT (____-__-__)
*/
function MakeDateInput(srcElement)
{
    MakeDefaultInput(srcElement,"____-__-__");
}
/*
預設時間INPUT TEXT (__:__)
*/
function MakeTimeInput(srcElement)
{
    MakeDefaultInput(srcElement,"__:__");
}