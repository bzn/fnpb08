var MyTab = {
    TabCount : 1,
    DefaultSelected : 1,
    NowSelected : 0,
    IndexElement : '',
    Initial : function(TabCount, TabDefault)
    {
        if(TabCount > 0) MyTab.TabCount = TabCount;
        if(TabDefault  > TabCount) MyTab.DefaultSelected = TabCount
        else if(TabDefault < 1) MyTab.DefaultSelected = 1;
        else MyTab.DefaultSelected = TabDefault;
        MyTab.Switch(MyTab.DefaultSelected);
    },
    /*切換Tab標籤*/
    Switch : function(TabIndex)
    {
        if(MyTab.NowSelected == TabIndex) return;
        else MyTab.NowSelected   = TabIndex;
        for(var i = 1 ; i <= MyTab.TabCount ; i++)
        {
            var BtnId   = 'TabBtn' + i;
            var TabBtn  = $(BtnId.toString());
            var PageId  = 'TabPage' + i;
            var TabPage = $(PageId.toString());
            if(TabBtn)
            {
                if(i == TabIndex)
                {
                    TabBtn.className = 'Selected';
                    TabBtn.blur();
                    TabPage.show();
                    //將看不見的iframe的display變更，以便於在GoUrl.js的時候判斷該iframe是否有顯示，如果有顯示才更新//
                    var TabIframe = TabPage.getElementsByTagName("IFRAME");
                    if(TabIframe && TabIframe.length > 0)
                    {
                        document.frames(TabIframe[0].name).document.body.style.display = '';
                    }
                }
                else
                {
                    TabBtn.className = '';
                    TabPage.hide();
                    //將看不見的iframe的display變更，以便於在GoUrl.js的時候判斷該iframe是否有顯示，如果有顯示才更新//
                    var TabIframe = TabPage.getElementsByTagName("IFRAME");
                    if(TabIframe && TabIframe.length > 0)
                    {
                        document.frames(TabIframe[0].name).document.body.style.display = 'none';
                    }
                    MyTab.setClick(TabBtn);
                }
            }
        }
    },
    setClick : function(TabBtn)
    {
        var index = eval(TabBtn.id.substr(6));
        TabBtn.onclick = function(){
            MyTab.Switch(index);
        }
    }
};