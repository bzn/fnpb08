var MyFloatingImg = Class.create();
MyFloatingImg.prototype = {
    initialize : function(imgsrc)
    {
        this.isIE   = ( navigator.appVersion.match(/\bMSIE\b/) ) ? 1 : 0;
        this.Img    = document.createElement("img");
        this.Img.id = "logoutimg";
        if (this.isIE)
        {
            this.Img.style.cursor   = "hand";
            this.Img.style.position = "absolute";
        }
        else
        {
            this.Img.style.cursor   = "pointer";
            this.Img.style.position = "fixed";
        }
        this.Img.style.border = 0;
        this.Img.src          = imgsrc;
    },
    setAppend : function(destElement)
    {
        if(destElement)
        {
            this.DestElement = destElement;
            this.DestElement.appendChild(this.Img);
        }
    },
    setLocation : function(vString, hString)
    {
        if(this.isIE)
        {
        	this.theTop    = this.DestElement.scrollTop;
        	this.theLeft   = this.DestElement.scrollLeft;
            this.theHeight = this.DestElement.clientHeight;
            this.theWidth  = this.DestElement.clientWidth;
        }
        else
        {
        	this.theTop    = this.DestElement.pageYOffset;
        	this.theLeft   = this.DestElement.pageXOffset;
            this.theHeight = this.DestElement.clientHeight;
            this.theWidth  = this.DestElement.clientWidth;
        }
        switch(vString)
        {
            case "top" :
                var top = 0;
                break;
            case "middle" :
                var top = this.theHeight / 2;
                break;
            case "bottom" :
                var top = this.theHeight;
                break;
        }
        switch(hString)
        {
            case "left" :
                var left = 0;
                break;
            case "center" :
                var left = this.theWidth / 2;
                break;
            case "right" :
                var left = this.theWidth;
                break;
        }
        this.Img.style.top  = top + "px";
        if(this.isIE)
        {
            this.Img.style.left = (left - this.Img.offsetWidth) + "px";
        }
        else
        {
            this.Img.style.left = (left - this.Img.width) + "px";
        }
    }
}