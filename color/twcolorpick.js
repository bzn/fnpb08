
	var colorPanel = new Array("BackgroundColorContainer","gridBox","colorBox");
	var source_button ;
	var targetInput;
	var ff = navigator.appName == 'Netscape' ? true : false; //mozilla firefox
	var ns = document.layers ? true : false; //Netscape
	var ie = document.all ? true : false; //Microsoft Internet Explorer
	
	function rgbToHex (array)
	{
		var re=new RegExp("[\\d]{1,3}","g");
		var rgb = array.match(re);
		if(rgb[3] && rgb[3]==0) 
			return 'transparent';
		var hex=[];
		for(var i=0;i<3;i++){
			var bit=(rgb[i]-0).toString(16);
			hex.push(bit.length==1?'0'+bit:bit);
		}
		var hexText='#'+hex.join('');
		return hexText;
	}

	
	function CreateColorPanel()
	{
		var color = new Array('00','33','66','99','CC','FF');
		var colors = new Array();
		for(i=0;i < 6;i++)
		{		
			for(j=0;j<6;)
			{
				for(l=0;l<3;l++)
				{
					for(k=0;k<6;k++)
					{
						colors.push('#'+color[i]+color[j+l]+color[k]);
					}
				}
				j+=3;
			}
		}
						
//		var colors = new Array("#000000","#000033","#000066","#000099","#0000CC","#0000FF","#330000","#330033","#330066","#330099","#3300CC","#3300FF","#660000","#660033","#660066","#660099","#6600CC","#6600FF","#990000","#990033","#990066","#990099","#9900CC","#9900FF","#CC0000","#CC0033","#CC0066","#CC0099","#CC00CC","#CC00FF","#FF0000","#FF0033","#FF0066","#FF0099","#FF00CC","#FF00FF","#003300","#003333","#003366","#003399","#0033CC","#0033FF","#333300","#333333","#333366","#333399","#3333CC","#3333FF","#663300","#663333","#663366","#663399","#6633CC","#6633FF","#993300","#993333","#993366","#993399","#9933CC","#9933FF","#CC3300","#CC3333","#CC3366","#CC3399","#CC33CC","#CC33FF","#FF3300","#FF3333","#FF3366","#FF3399","#FF33CC","#FF33FF","#006600","#006633","#006666","#006699","#0066CC","#0066FF","#336600","#336633","#336666","#336699","#3366CC","#3366FF","#666600","#666633","#666666","#666699","#6666CC","#6666FF","#996600","#996633","#996666","#996699","#9966CC","#9966FF","#CC6600","#CC6633","#CC6666","#CC6699","#CC66CC","#CC66FF","#FF6600","#FF6633","#FF6666","#FF6699","#FF66CC","#FF66FF","#009900","#009933","#009966","#009999","#0099CC","#0099FF","#339900","#339933","#339966","#339999","#3399CC","#3399FF","#669900","#669933","#669966","#669999","#6699CC","#6699FF","#999900","#999933","#999966","#999999","#9999CC","#9999FF","#CC9900","#CC9933","#CC9966","#CC9999","#CC99CC","#CC99FF","#FF9900","#FF9933","#FF9966","#FF9999","#FF99CC","#FF99FF","#00CC00","#00CC33","#00CC66","#00CC99","#00CCCC","#00CCFF","#33CC00","#33CC33","#33CC66","#33CC99","#33CCCC","#33CCFF","#66CC00","#66CC33","#66CC66","#66CC99","#66CCCC","#66CCFF","#99CC00","#99CC33","#99CC66","#99CC99","#99CCCC","#99CCFF","#CCCC00","#CCCC33","#CCCC66","#CCCC99","#CCCCCC","#CCCCFF","#FFCC00","#FFCC33","#FFCC66","#FFCC99","#FFCCCC","#FFCCFF","#00FF00","#00FF33","#00FF66","#00FF99","#00FFCC","#00FFFF","#33FF00","#33FF33","#33FF66","#33FF99","#33FFCC","#33FFFF","#66FF00","#66FF33","#66FF66","#66FF99","#66FFCC","#66FFFF","#99FF00","#99FF33","#99FF66","#99FF99","#99FFCC","#99FFFF","#CCFF00","#CCFF33","#CCFF66","#CCFF99","#CCFFCC","#CCFFFF","#FFFF00","#FFFF33","#FFFF66","#FFFF99","#FFFFCC","#FFFFFF");
		var colorPanelDIV = "<div id='BackgroundColorContainer' style='display:none;'><div id='gridBox'>";
		for(index=0;index < colors.length;index++)
		{
			colorPanelDIV = colorPanelDIV + "<div id='colorBox' class='colorBox' style='background-color: " + colors[index] + ";'><!----></div>";
		}
		colorPanelDIV += "</div></div>";
		document.write(colorPanelDIV);
	}

	function colorpick(e)
	{
		var child = Event.element(e);

		if(child.className=="colorBox"){
			var colorStyle = child.style.backgroundColor;
			//Using rgbToHex() to correct the FireFox Browser CSS property different.
			if(ff) colorStyle = rgbToHex(colorStyle);
			var bgcolor = $(targetInput);
			bgcolor.value = colorStyle;
			bgcolor.style.backgroundColor = colorStyle;
			$("BackgroundColorContainer").style.display="none";
		}
		Event.stop(e);
	}
	
	function showColorPick(e,button,target)
	{
		if(ie) e = event;
		sourceObj = $(button);
		source_button = button
		targetInput = target;
		var showpick = 1;
		if(ie)
		{
			if(e.srcElement.id!=button && e.srcElement.id!="BackgroundColorContainer" && e.srcElement.id!="colorBox" && e.srcElement.id!="gridBox")
			{
				$("BackgroundColorContainer").style.display="none";
				showpick = 0;
			}
		}
		if(ff)
		{
			if(e.explicitOriginalTarget.id!=button && e.explicitOriginalTarget.id!="BackgroundColorContainer" && e.explicitOriginalTarget.id!="colorBox" && e.explicitOriginalTarget.id!="gridBox")
			{
				$("BackgroundColorContainer").style.display="none";
				showpick = 0;
			}
		}
		
		if(showpick)
		{
			var colorpick = $("BackgroundColorContainer");
			var x =Position.get(button).left;
			var y =Position.get(button).top;
			if(colorpick.style.display=='none')
			{
				colorpick.style.position='absolute';
				//Using Position Object to set the correct coordinate
				//set style will be error.
				Position.set(colorpick,x,y+sourceObj.offsetHeight);
				colorpick.style.zIndex = "3";
				colorpick.style.visibility='visible';
				colorpick.style.display='block';
			}
		}
	}
	
	function closeColorPick(e)
	{
		if(ie) e = event;
		if(ie)
		{
			if(e.srcElement.id!=source_button && e.srcElement.id!="BackgroundColorContainer" && e.srcElement.id!="colorBox" && e.srcElement.id!="gridBox")
				$("BackgroundColorContainer").style.display="none";
		}
		else if(ff)
		{
			if(e.explicitOriginalTarget.id!=source_button && e.explicitOriginalTarget.id!="BackgroundColorContainer" && e.explicitOriginalTarget.id!="colorBox" && e.explicitOriginalTarget.id!="gridBox")
			{
				$("BackgroundColorContainer").style.display="none";
			}
		}
	}

CreateColorPanel();

Event.observe(document,"click",closeColorPick);

