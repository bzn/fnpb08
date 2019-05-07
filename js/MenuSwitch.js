function MenuSwitch(subno)
{
	var menu_id  = "";
	var menu_div = "";
	for(var i = 1 ; i <= 5 ; i++)
	{
		menu_id  = "menu-sub-" + i ;
		menu_div = document.getElementById(menu_id);
		if(i == subno)
		{
			menu_div.style.display = "block";
		}
		else
		{
			menu_div.style.display = "none";
		}
	}
	/*
    var AllDiv = document.getElementsByTagName("div");
    if(AllDiv.length > 0)
    {
        var Div   = "";
        var DivId = "";
        for(var i = 0 ; i < AllDiv.length ; i++)
        {
            Div = AllDiv[i];
            if(Div && Div.id)
            {
                DivId = Div.id.toString();
                if(DivId.substr(0,9) == "menu-sub-")
                {
                    if(DivId == "menu-sub-"+subno)
                    {
                        Div.style.display = "";
                    }
                    else
                    {
                        Div.style.display = "none";
                    }
                }
            }
        }
    }
    */
}