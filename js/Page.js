function FisrtPage(frm)
{
    var page = frm.page.value;
    page = 1;
    frm.page.value = page;
    frm.submit();
}

function PrevPage(frm)
{
    var page = frm.page.value;
    if(page > 1)
    {
        page--;
    }
    else
    {
        page = 1;
    }
    frm.page.value = page;
    frm.submit();
}

function NextPage(frm, maxpage)
{
    var page = frm.page.value;
    if(page < maxpage)
    {
        page++;
    }
    else
    {
        page = maxpage;
    }
    frm.page.value = page;
    frm.submit();    
}

function LastPage(frm, maxpage)
{
    var page = frm.page.value;
    page = maxpage;
    frm.page.value = page;
    frm.submit();    
}