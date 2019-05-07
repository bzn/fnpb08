/*
反白字元
*/
function TextRangeSelect(srcElement, mStart, mEnd)
{
    if(srcElement)
    {
    	var MyRange = srcElement.createTextRange();
    	MyRange.collapse(true);
    	MyRange.moveStart("character", mStart);
        MyRange.moveEnd("character", mEnd); 
    	MyRange.select();
    	return MyRange.text;
    }
}
/*
反白後設定文字
*/
function TextRangeSet(srcElement, mStart, mEnd, defaultText)
{
    if(srcElement)
    {
    	var MyRange = srcElement.createTextRange();
    	MyRange.collapse(true);
    	MyRange.moveStart("character", mStart);
        MyRange.moveEnd("character", mEnd); 
    	MyRange.select();
    	MyRange.text = defaultText;
    }
}
/*
取得游標位置
*/
function GetTextPos(srcElement)
{
    var DocumentRange = document.selection.createRange();
    srcElement.select();
    var SelectionRange = document.selection.createRange();
    DocumentRange.setEndPoint("StartToStart", SelectionRange);
    var Pos = DocumentRange.text.length;
    DocumentRange.collapse(false);
    DocumentRange.select();
    return Pos;
}
/*
反白字元
*/
function MarkUpText(srcElement, charset, defaultText)
{
    //如果是Tab鍵//
    if(event.keyCode == 9) return;
    var Pos = GetTextPos(srcElement);
    var MarkUpText = "";
    //BackSpace//
    if(event.keyCode == 8)
    {
    }
    //Delete//
    else if(event.keyCode == 46)
    {
        
    }
    //左鍵//
    else if(event.keyCode == 37)
    {
        MarkUpPrev(srcElement,charset);
    }
    else
    {
        MarkUpNext(srcElement,charset);
    }
}
/*
反白打字的下一個的字元
*/
function MarkUpNext(srcElement,charset)
{
    //如果是Tab鍵//
    if(event.keyCode == 9) return;
    var Pos = GetTextPos(srcElement);
    //反白字元//
    var MarkUpText = TextRangeSelect(srcElement,Pos,1);
    //如果遇到跳過的字就再往後//
    if(MarkUpText == charset && charset != "")
    {
        Pos = GetTextPos(srcElement);
        //反白字元//
        TextRangeSelect(srcElement,Pos,1);
    }
}
/*
反白打字的前一個的字元
*/
function MarkUpPrev(srcElement,charset)
{
    var Pos = GetTextPos(srcElement);
    var MarkUpText = "";
    if(Pos > 0)
    {
        //往前移動mark前一個字元//
        Pos--;
        MarkUpText = TextRangeSelect(srcElement,Pos,1);
        //如果遇到跳過的字就再往前//
        if(MarkUpText == charset && charset != "") Pos--;
    }
    //反白字元//
    TextRangeSelect(srcElement,Pos,1);
}
/*
預設INPUT TEXT的文字，並將第一碼反白
*/
function MakeDefaultInput(srcElement,defaultText)
{
    if(srcElement.type == "text")
    {
        if(srcElement.value == "")
        {
           srcElement.value = defaultText; 
        }
        TextRangeSelect(srcElement,0,1);
    }
}