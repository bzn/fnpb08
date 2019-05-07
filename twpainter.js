
	var colorPanel = new Array("BackgroundColorContainer","gridBox","colorBox");
	var source_button ;
	var targetInput = "color_input";
	var ff = navigator.appName == 'Netscape' ? true : false; //mozilla firefox
	var ns = document.layers ? true : false; //Netscape
	var ie = document.all ? true : false; //Microsoft Internet Explorer
	
	var drawStatus = false;
	var drawMove = false;
	var drawId = null;
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

//		var colorPanelDIV = "<div id='BackgroundColorContainer' ><div id='gridBox'>";
		var colorPanelDIV = "<div id='gridBox'>";
		for(index=0;index < colors.length;index++)
		{
			colorPanelDIV = colorPanelDIV + "<div id='colorBox' class='colorBox' style='background-color: " + colors[index] + ";'><!----></div>";
		}
//		colorPanelDIV += "</div></div>";
		colorPanelDIV += "</div>";
		document.write(colorPanelDIV);
	}

	function colorpick(e)
	{
		if(!e) var e = window.event;
		var child = Event.element(e);

		if(child.className=="colorBox"||child.className=="canavas_box"){
			var colorStyle = child.style.backgroundColor;
			//Using rgbToHex() to correct the FireFox Browser CSS property different.
			if(ff) colorStyle = rgbToHex(colorStyle);
			var bgcolor = $(targetInput);
			bgcolor.value = colorStyle;
			bgcolor.style.backgroundColor = colorStyle;
		}
		Event.stop(e);
	}

	function CreateCanavas()
	{
		var canavasDiv = "<div id='canavas'>";
		for(index=0;index < 576;index++)
		{
			canavasDiv = canavasDiv + "<div id='canavas_box_" + index + "' class='canavas_box' name='canavas_box'  style='background-color:#ffffff' value='" + index +  "'></div>";
		}
		canavasDiv += "</div>";
		document.write(canavasDiv);
	}

	function CreateSmallCanavas()
	{
		var canavasDiv = "<div id='small'>";
		for(index=0;index < 576;index++)
		{
			canavasDiv = canavasDiv + "<div id='canavas_box_" + index + "_s' class='canavas_box_s' name='canavas_box_s'></div>";
		}
		canavasDiv += "</div>";
		document.write(canavasDiv);
	}	
	
	function BrushDown(e)
	{
		if(drawMode == true)
		{
			drawStatus = true;
			if(ff)
				drawId = e.explicitOriginalTarget.id;
			else
			{
				if(!e) var e = window.event;
				if(e.target)
					drawId = e.target.id;
				else if(e.srcElement)
					drawId = e.srcElement.id;
			}
			Brush(e);
		}else
			colorpick(e);
	}
	
	function BrushUp(e)
	{
		drawStatus = false;
		drawMove = false;
	}	
	
	function BrushMove(e)
	{
		drawMove = true;
		if(drawStatus)
		{
			if(ff)
				drawId = e.explicitOriginalTarget.id;
			else
			{
				if(!e) var e = window.event;
				drawId = e.srcElement.id;
			}
		}
	}
	
	function Brush(e)
	{
		if(drawStatus == true && drawMove == true && $(drawId).className=="canavas_box")
		{
			if(ff){
				if($("color_input").value==rgbToHex($(drawId).style.backgroundColor))
					$(drawId).style.backgroundColor="#ffffff";
				else
					$(drawId).style.backgroundColor=$("color_input").value;
			}else{			
				if($(drawId).style.backgroundColor==$("color_input").value)
					$(drawId).style.backgroundColor="#ffffff";
				else
					$(drawId).style.backgroundColor=$("color_input").value;
			}
			//var small = $(drawId).id + "_s";
			//$(small).style.backgroundColor=$(drawId).style.backgroundColor;
		}
	}
	
