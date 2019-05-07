function SwitchComboList(ComboListId, InputId)
{
    var ComboListElement = $(ComboListId);
    var InputElement     = $(InputId);
    if(ComboListElement.style.display != 'none')
    {
        ComboListElement.hide();
    }
    else
    {
        SetPosition(ComboListElement, InputElement);
        ComboListElement.show();
    }
}

function SetPosition(ComboListElement, InputElement)
{
    var InputPos = findPos(InputElement);
    ComboListElement.style.left  = InputPos[0];
    ComboListElement.style.top   = InputPos[1] + InputElement.offsetHeight;
    ComboListElement.style.width = InputElement.offsetWidth;
}

function GetListVal(SetVal, InputId, ComboListId)
{
    var ComboListElement = $(ComboListId);
    var InputElement     = $(InputId);
    if(InputElement) InputElement.value = SetVal;
    ComboListElement.hide();
}

function findPos(obj)
{
	var curleft = curtop = 0;
	if (obj.offsetParent)
	{
		curleft = obj.offsetLeft
		curtop = obj.offsetTop
		while (obj = obj.offsetParent)
		{
			curleft += obj.offsetLeft
			curtop += obj.offsetTop
		}
	}
	return [curleft,curtop];
}