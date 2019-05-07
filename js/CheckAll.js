function CheckAll(srcElement)
{
    var allinput = document.getElementsByTagName("input");
    for(var i = 0 ; i < allinput.length ; i++)
    {
        if(allinput[i].type == "checkbox")
        {
            allinput[i].checked = srcElement.checked;
        }
    }
}