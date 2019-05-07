function GoUrl(sUrl, tFrame)
{
    if(tFrame && tFrame != self)
    {
        /*
        if(tFrame.document.body.style.display != 'none')
        {
            tFrame.location.href = sUrl;
        }
        */
        tFrame.location.href = sUrl;
    }
}