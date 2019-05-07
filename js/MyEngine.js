var Engine = {
    setStatus: function(message)
    {
        if($('status') != null)
        {
            $('status').parentNode.removeChild($('status'));
        }
        var body = document.getElementsByTagName("body")[0];
        var div = document.createElement("div");
        div.style.position = "absolute";
        div.style.top = "50%";
        div.style.left = "50%";
        div.style.width = "200px";
        div.style.margin = "-12px 0 0 -100px";
        div.style.border = "0px";
        div.style.padding = "20px";
        div.style.opacity = "0.85";
        div.style.backgroundColor = "#353555";
        div.style.border = "1px solid #CFCFFF";
        div.style.color = "#CFCFFF";
        div.style.fontSize = "25px";
        div.style.textAlign = "center";
        div.id = 'status';
        body.appendChild(div);
        div.innerHTML = message;
    },
    
    showLoadingImg: function(){
        if($('loading') != null)
        {
            $('loading').parentNode.removeChild($('loading'));
        }
        var body = document.getElementsByTagName("body")[0];
        var img = document.createElement("img");
        img.style.position = "absolute";
        img.style.top = "50%";
        img.style.left = "50%";
        img.style.opacity = "0.85";
        img.src = "/images/loading/indicator_square.gif";
        img.id = 'loading';
        body.appendChild(img);
    },
    
    hideStatus: function(){
        Engine.opacityDown($('status'));
    },
    
    hideLoadingImg: function(){
        Engine.opacityDown($('loading'));
    },
 
    opacityDown: function(theElement){
        if(theElement == null)
        {
            return;
        }
        var opacity = parseFloat(theElement.style.opacity);
        if(opacity < 0.08)
        {
            theElement.parentNode.removeChild(theElement);
        }
        else
        {
            opacity -= 0.07;
            theElement.style.opacity = opacity;
            setTimeout(function(){Engine.opacityDown(theElement);}, 50);
        }
        return true;
    },
  
    setContent: function(content){
        $('content').innerHTML = content;
    },
 
    showError: function(message){
        Engine.setStatus(message);
        setTimeout("Engine.hideStatus()",10000);
    }
}