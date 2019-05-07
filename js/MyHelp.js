function OpenHelpWindow(destProgram, KeyColName, ValColName, TableName, Statement, targetId)
{
    var sUrl     = destProgram + 
                   "?keycolname=" + encodeURI(KeyColName) + 
                   "&valcolname=" + encodeURI(ValColName) +
                   "&tablename="  + encodeURI(TableName) +
                   "&statement="  + encodeURI(Statement) +
                   "&targetid="   + encodeURI(targetId);
    window.open(sUrl,"MyHelp",
    "height=300,width=300,left=200,top=100,status=no,toolbar=no,menubar=no,location=no");
}

function DoSelect(srcVal)
{
    var targetid = $('targetid').value;
    var targetElement = window.opener.document.getElementById(targetid);
    if(targetElement.type == 'text')
    {
        if(targetElement.className == 'combine')
        {
            if(targetElement.value != "")
            {
                targetElement.value = targetElement.value + "," + srcVal;
            }
            else
            {
                targetElement.value = srcVal;
            }
        }
        else
        {
            targetElement.value = srcVal;
        }
    }
    else if(targetElement.type == 'textarea')
    {
        if(targetElement.className == 'combine')
        {
            if(targetElement.innerHTML != "")
            {
                targetElement.innerHTML = targetElement.innerHTML + "," + srcVal;
            }
            else
            {
                targetElement.innerHTML = srcVal;
            }
        }
        else
        {
            targetElement.innerHTML = srcVal;
        }
    }
    targetElement.focus();
    targetElement.blur();
    window.close();
}