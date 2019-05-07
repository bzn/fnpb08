/*******************************************************************************
/* 瀏覽器判斷
*******************************************************************************/
var isDOM = document.getElementById ? 1 : 0;
var isIE  = document.all ? 1 : 0;
var isNS4 = (navigator.appName=='Netscape' && !isDOM) ? 1 : 0;
var isIE4 = (isIE && !isDOM) ? 1 : 0;
var isDyn = (isDOM||isIE||isNS4);
/*******************************************************************************
/* 浮動訊息欄顯示
*******************************************************************************/
var MyMenu = {
    theTop    : 0,
    theLeft   : 0,
    theHeight : 0,
    theWidth  : 0,
    //初始訊息欄(按鈕文字，選單iframe內容連結頁面)//
    initMyMenu: function(headText, iFrameSrc)
    {
        //DOM產生Element//
        var body     = document.getElementsByTagName("body")[0];
        var MenuDiv  = document.createElement("div");
        var MenuTab  = document.createElement("div");
        var MenuBody = document.createElement("div");
        //設定目錄選單屬性//
        MenuDiv.id         = 'MenuDiv';
        MenuDiv.className  = 'MenuDiv';
        MenuTab.id         = 'MenuTab';
        MenuTab.className  = 'MenuTab';
        MenuBody.id        = 'MenuBody';
        MenuBody.className = 'MenuBody';
        //設定目錄按鈕，設定目錄內容//
        MenuTab.innerHTML   = headText;
        MenuBody.innerHTML = '<iframe id="menuFrame" name="menuFrame" src="' + iFrameSrc + '" frameborder="no"></iframe>';
        //設訂固定位置//
        if(isIE)
        {
            MenuDiv.style.position = "absolute";
        }
        else
        {
            MenuDiv.style.position = "fixed";
        }
        //DOM加入Element//
        body.appendChild(MenuDiv);
        MenuDiv.appendChild(MenuBody);
        MenuDiv.appendChild(MenuTab);
        //設定MENU位置//
        this.setLocation();
        //設定動態屬性//
        this.setMethod();
    },
    //設定動態屬性//
    setMethod: function()
    {
        var MenuDiv = $('MenuDiv');
        var MenuTab = $('MenuTab');
        //滑鼠在目錄按鈕時變手指//
        MenuTab.onmouseover = function()
        {
            if(isIE)
            {
                MenuTab.style.cursor = 'hand';
            }
            else
            {
                MenuTab.style.cursor = 'pointer';
            }
        }
        //滑鼠在目錄按鈕時按下時，切換目錄//
        MenuTab.onclick = function() {MyMenu.SwitchMyMenu();};
    },
    //設定位置//
    setLocation: function()
    {
        var MenuDiv   = $('MenuDiv');
        var menuFrame = $('menuFrame');
        //取得視窗顯示內高度及寬度//
        if(isIE)
        {
        	this.theTop    = document.body.scrollTop;
        	this.theLeft   = document.body.scrollLeft;
            this.theHeight = document.body.clientHeight;
            this.theWidth  = document.body.clientWidth;
        }
        else
        {
        	this.theTop    = self.pageYOffset;
        	this.theLeft   = self.pageXOffset;
            this.theHeight = self.innerHeight;
            this.theWidth  = self.innerWidth;
        }
        menuFrame.style.height = this.theHeight - MenuTab.offsetHeight;
        MenuDiv.style.top  = "0px";
        MenuDiv.style.left = "0px";
    },
    //檢查目錄是否開啟//
    isMenuOpen: function()
    {
        var MenuBody = $('MenuBody');
        if(MenuBody)
        {
            if(MenuBody.style.display == 'none')
            {
                return 0;
            }
            else
            {
                return 1;
            }
        }
    },
    //開啟目錄//
    OpenMenu: function()
    {
        var MenuBody = $('MenuBody');
        MenuBody.show();
    },
    //關閉目錄//
    CloseMenu: function()
    {
        var MenuBody = $('MenuBody');
        MenuBody.hide();
    },
    //切換目錄//
    SwitchMyMenu: function()
    {
        //檢查目錄是否開啟//
        if(this.isMenuOpen())
        {
            //關閉目錄//
            this.CloseMenu();
        }
        else
        {
            //開啟目錄//
            this.OpenMenu();
        }
    }
};
//視窗開啟時執行//
/*
window.onload = function()
{
    MyMenu.initMyMenu('目錄選單','/include/MyMenu.php');
}
*/
//框架目錄開關//
function SwitchFrame()
{
    var MenuBtn = $('menubtn');
    /*取得第二個框架*/
    var allElement = window.top.document.getElementsByTagName('FRAMESET');
    var FramePage = allElement[1];
    /*控制框架*/
    if(FramePage)
    {
        var FrameCols = FramePage.cols;
        var arrayFrameCols = FrameCols.split(/,/);
        if(arrayFrameCols[0] == 0)
        {
            arrayFrameCols[0] = 160;
            MenuBtn.src = "../images/index/menu_i.gif";
        }
        else
        {
            arrayFrameCols[0] = 0;
            MenuBtn.src = "../images/index/menu_o.gif";
        }
        FramePage.cols = arrayFrameCols.toString();
    }
}