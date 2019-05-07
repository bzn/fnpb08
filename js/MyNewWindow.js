function OpenNewWindow(sUrl, sParam, Width, Height, Left, Top)
{
    var width  = (Width)  ? Width  : 300 ;
    var height = (Height) ? Height : 300 ;
    var left   = (Left)   ? Left   : 200 ;
    var top    = (Top)    ? Top    : 100 ;
    window.open(
        sUrl + "?" + sParam ,
        "MyHelp",
        "height="+ height +
        ",width="+ width +
        ",left=" + left +
        ",top="  + top +
        ",status=no,toolbar=no,menubar=no,location=no");
}
