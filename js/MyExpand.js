function DoFrameSwitch(srcElement,targetId)
{
    var targetElement = $(targetId);
    var srcValue      = srcElement.value.toString();
    if(targetElement)
    {
        if(targetElement.style.display != 'none')
        {
            targetElement.hide();
            srcElement.value = srcValue.substr(0,(srcValue.length - 1)) + "開"; 
        }
        else
        {
            targetElement.show();
            srcElement.value = srcValue.substr(0,(srcValue.length - 1)) + "關"; 
        }
    }
}

function IncFrameHeight()
{
    var AllFrame = document.getElementsByTagName("iframe");
    if(AllFrame && AllFrame.length > 0)
    {
        var destFrame        = "";
        var destOffsetHeight = 0;
        for(var i = 0 ; i < AllFrame.length ; i++)
        {
            destFrame = AllFrame[i];
            if(destFrame.name != 'queryFrame' && destFrame.name != 'listFrame')
            {
                if(destFrame.offsetHeight > 0)
                {
                    destOffsetHeight = destFrame.offsetHeight;
                    break;
                }
            }
        }
        for(var i = 0 ; i < AllFrame.length ; i++)
        {
            destFrame = AllFrame[i];
            if(destFrame.name != 'queryFrame' && destFrame.name != 'listFrame')
            {
                if(destFrame.offsetHeight > 0) destOffsetHeight = destFrame.offsetHeight;
                destFrame.height = destOffsetHeight + 20;
            }
        }
    }
}

function DecFrameHeight()
{
    var AllFrame = document.getElementsByTagName("iframe");
    if(AllFrame && AllFrame.length > 0)
    {
        var destFrame        = "";
        var destOffsetHeight = 0;
        for(var i = 0 ; i < AllFrame.length ; i++)
        {
            destFrame = AllFrame[i];
            if(destFrame.name != 'queryFrame' && destFrame.name != 'listFrame')
            {
                if(destFrame.offsetHeight > 0)
                {
                    destOffsetHeight = destFrame.offsetHeight;
                    break;
                }
            }
        }
        for(var i = 0 ; i < AllFrame.length ; i++)
        {
            destFrame = AllFrame[i];
            if(destFrame.name != 'queryFrame' && destFrame.name != 'listFrame')
            {
                if(destFrame.offsetHeight > 200)
                {
                    destFrame.height = destOffsetHeight - 20;
                }
            }
        }
    }
}