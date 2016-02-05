$(document).ready(function()
{
	// var di=1;
	// var isIOS = navigator.userAgent.match(/iPhone|iPad|iPod/i) != null;
	// if (isIOS) 
	// {
	// 	di=-1;
	// };

	// var mql = window.matchMedia("(orientation: portrait)");
	// var pre_orientation=null;
	// pre_orientation=mql.matches;
	// mql.addListener(function(m) {
	// 	if(m.matches!=pre_orientation)
	// 	{
	// 		alert("Please lock screen rotation");
	// 		pre_orientation=m.matches;
	// 	}
		
	// });
	
	var dix=1;
	var diy=1;
	window.addEventListener("orientationchange", function() {
  		// Announce the new orientation number
  		//alert(window.orientation);
  		$("#orlock").show();
	}, false);

	
	window.ondevicemotion = function(event) {
        x = (event.accelerationIncludingGravity.x*dix)*(-1);
        y = event.accelerationIncludingGravity.y*diy;
        z = event.accelerationIncludingGravity.z;
        interval = event.interval;
        time_ms = Date.now() - startTime_ms;
        current_func();
    };
	can = document.getElementById("catchit");
	ctx = can.getContext("2d");
	$(window).resize(function()
	{
		resize();
	});
	function resize()
	{
		ww = $(window).width();//screen.availWidth;
		hh = $(window).height();//screen.availHeight;
		var conww=ww/hh;
		if(conww>=1)
		{
			conww=ww/conww;
		}else{
			conww=conww*ww;
		}
		tbar=parseInt($(".tbar").css("height"));
		bbar=parseInt($(".bottom").css("height"));
		pixres = 1;
		//width = pixres*conww;
		width=parseInt($(".container-fluid").width())-((parseInt($(".container-fluid").width())*18)/100);
		height =((hh-tbar)-bbar)-((parseInt($(".container-fluid").width())*6)/100); //((hh-tbar)-parseInt($(".tbar").css("height")))+30;
		if(width>height)
		{
			height=width;
		}
		scale = width/1000;
		arthick = 20*scale;
		arlength = width*0.04;
		$("#catchit").attr("width",width);
		$("#catchit").attr("height",height);
		$("#catchit").css({"width":width});
		$("#catchit").css({"height":height});
		// alert(JSON.stringify($(".tbtn_on:visible")));
	}
	$(window).bind("load",function()
	{
		resize();
		current_func=drawDisp;
		var vivi=setInterval(function()
		{
			if(x==null)
			{
				alert("No sensor available please try it on a phone or tablet. The data you will see in the PC is randomly generated");
				rnd_desktop();
				clearInterval(vivi);
			}
		},1000);
		// if(localStorage.getItem("pl_dix")!=null)
		// {
		// 	alert(localStorage.getItem("pl_dix"));
		// 	dix=localStorage.getItem("pl_dix");
		// }
		// if(localStorage.getItem("pl_diy")!=null)
		// {
		// 	diy=localStorage.getItem("pl_diy");
		// }
	});
	$("#close_orlock").click(function()
	{
		$("#orlock").hide();
	});
	$("#emailButtonSend").click(function()
	{
		var address = document.getElementById('EMAIL_FIELD').value;
		sendmail(address);
	});
	$("#rec_off").click(function()
	{
		launchFullScreen(document.documentElement);
		rec_array=[];
		//clearTimeout(current_func);
		//drawDisp();
		fillCircle();
		startRecording();
		$(".tbtn_on").hide();
		$(".tbtn").show();
		$("#rec_off").hide();
		$("#rec_on").show();
		$("#rec_popup").show();
		
		//$("#emailpopup").show();
	});
	$("#rec_on,#rec_popup_close").click(function()
	{
		cancelFullScreen();
		stopRecording();
		$(".tbtn").show();
		$("#rec_on").hide();
		$("#rec_off").show();
		$("#emailpopup").show();
		$("#loader").hide();
		if(localStorage.getItem("PL_Email")!=null)
		{
			$("#EMAIL_FIELD").val(localStorage.getItem("PL_Email"));
		}
	});
	$("#num_off").click(function()
	{
		//alert(1);
		//clearTimeout(current_func);
		$(".tbtn_on").hide();
		$(".tbtn").show();
		$(this).hide();
		$("#num_on").show();
		xx=yy=zz=t=0;
		startTime_ms = Date.now();
		current_func=drawNum;
	});
	$("#disp_off").click(function()
	{
		//alert(1);
		//clearTimeout(current_func);
		$(".tbtn_on").hide();
		$(".tbtn").show();
		$(this).hide();
		$("#disp_on").show();
		current_func=drawDisp;
	});
	$("#graph_off").click(function()
	{
		//alert(1);
		//clearTimeout(current_func);
		ctx.clearRect(0,0,width,height);
		tpoint=0;
		ypoint_x=null;
		$(".tbtn_on").hide();
		$(".tbtn").show();
		$(this).hide();
		$("#graph_on").show();
		draw_rec=false;
		current_func=drawGraph;
	});
	$("#popup-inner").click(function(e)
	{
		if($(e.target).attr("id")=="popup-inner")
		{
			$("#emailpopup").hide();
			//clearTimeout(current_func);
			$(".tbtn_on").hide();
			$(".tbtn").show();
			$("#disp_off").hide();
			$("#disp_on").show();
			//current_func=drawDisp;
			$("#plotGraph").click();
		}
	});
	$("#plotGraph,#plotGraph2").click(function()
	{
		//clearTimeout(current_func);
		tpoint=0;
		ypoint_x=null;
		$(".tbtn_on").hide();
		$(".tbtn").show();
		$("#graph_off").hide();
		$("#graph_on").show();
		$("#emailpopup").hide();
		$("#rec_popup").hide();
		gcounter=0;
		//draw_rec=true;
		draw_rec=false;
		current_func=drawGraph;
		//drawGraph();
		//current_func=blank;
	});


	$(".tbtn").not("#rec_off").click(function()
	{
		stopRecording();
	});

	$("#linkGraph").click(function()
	{
		var req={"data":rec_array};
		var b=Base64.encode(JSON.stringify(req));
		$("#loader").show();
		$("#status").text("Please wait");
		$.ajaxSetup({async: false});
		$.post("log.php",{data:b},function(data,status){
    		if(status=="success")
    		{
    			window.open("chart.php?id="+data,"_blank");
    			//$("#_anchor").attr("href",link);
    			//$("#_span").click();
    		}
    		$("#status").text(status);
    		$("#loader-img").hide();
  		});
	});
	$("#setting_btn").click(function()
	{
		$("#setting_popup").show();

	});
	$("#setting_popup_close").click(function()
	{
		$("#setting_popup").hide();	
	});
	$("#y_flip").click(function()
	{
		if(diy==1)
		{
			diy=-1;
			// localStorage.setItem("pl_diy",diy);
		}else{
			diy=1;
			// localStorage.setItem("pl_diy",diy);
		}
	});
	$("#x_flip").click(function()
	{
		if(dix==1)
		{
			dix=-1;
			// localStorage.setItem("pl_dix",dix);
		}else{
			dix=1;
			// localStorage.setItem("pl_dix",dix);
		}
	});
});
			