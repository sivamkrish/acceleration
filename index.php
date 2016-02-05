<!Doctype html>
<html lang="en">
<head>
	<title>Catchit Web App</title>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="mobile-web-app-capable" content="yes">
	<link rel="icon"  type="image/x-icon" href="img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
</head>
<body>
	<div class="container-fluid h100">
		<div class="row tbar">
			<div class="col-md-3 col-sm-3 col-xs-3 text-center">
				<a class="tbtn"  style="display:none" id="disp_off" href="#"><img class="imgdisp img-responsive" src="img/Disp.png"></a>
				<a class="tbtn_on" id="disp_on" href="#"><img class="img-responsive" src="img/Disp_on.png"></a>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<a class="tbtn" id="num_off" href="#"><img class="img-responsive" src="img/Numbers.png"></a>
				<a class="tbtn_on" style="display:none" id="num_on" href="#"><img class="img-responsive" src="img/Numbers_on.png"></a>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<a class="tbtn" id="graph_off" href="#"><img class="img-responsive" src="img/Graph.png"></a>
				<a style="display:none" class="tbtn_on" id="graph_on" href="#"><img class="img-responsive" src="img/Graph_on.png"></a>
			</div>
			<div class="col-md-3 col-sm-3 col-xs-3">
				<a class="tbtn" id="rec_off" href="#"><img class="img-responsive" src="img/Record_off.png"></a>
				<a class="tbtn_on" id="rec_on" style="display:none" href="#"><img class="img-responsive" src="img/Record_on.png"></a>
			</div>
		</div>
		<div class="row canrow">
			<div class="text-center col-md-12 col-sm-12 col-xs-12 candiv">
				<canvas id="catchit">
					<p>Your browser does not support the canvas tag.</p>
				</canvas>
			</div>
		</div>
		<div class="row bottom">
			<div style="margin-top:2%" class="col-md-6 col-sm-6 col-xs-6">
				<img src="img/logo.png" class="img-responsive">
			</div>
			<div class="col-md-4 col-sm-4 col-xs-4">
			</div>
			<div class="col-md-2 col-sm-2 col-xs-2">
				<a id="setting_btn" href="#"><img src="img/Settings.png" class="img-responsive"></a>
			</div>
		</div>
	</div>
	<div id="emailpopup" style="display:none;width:100%;height:100%;z-index:9999;position:fixed;top:0;left:0">
		<div id="popup-inner" style="position:relative;height:100%;width:100%">
			<div style="border-radius:20px;background-color:rgb(84,52,52);padding:16px;width:550px;height:250px;position:absolute;margin:auto;border:5px solid brown;bottom:0;left:0;right:0;">
				<div class="row m20">
					<div class="col-md-12 col-xs-12 text-center">
						<p style="font-family:numberfont;color:white;font-size:44px">>&nbsp;View Graph</p><br>
						<input style="font-family:numberfont;font-size:35px" id="linkGraph" type="button" class="btn button" value="YES">
						<input style="font-family:numberfont;font-size:35px;margin-left:100px;" id="plotGraph" type="button" class="btn button" value="NO">
					</div>
					<div style="display:none;" id="loader" class="col-md-12 col-xs-12 text-left">
						<img id="loader-img" src="img/loading.gif" style="max-width:20px;">
						<span style="color:silver" id="status">Please wait...</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="rec_popup" style="display:none;width:100%;height:100%;background-color:rgba(0,0,0,1);z-index:999;position:fixed;top:0;left:0">
		<div class="row">
			<div style="margin-top:20px;margin-right:20px" class="col-md-12 col-sm-12 col-xs-12 text-right">
				<a href="#" id="rec_popup_close"><img src="img/rec_close.png"></a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<img style="width:100%;margin-top:20px" src="img/rec_popup.png">
			</div>
		</div>
	</div>

	<div id="orlock" style="display:none;width:100%;height:100%;z-index:9999;position:fixed;top:0;left:0">
		<div style="position:relative;height:100%;width:100%">
			<div style="border-radius:20px;background-color:rgb(84,52,52);padding:16px;width:550px;height:250px;position:absolute;margin:auto;border:5px solid brown;bottom:0;left:0;right:0;top:0;">
				<div class="row m20">
					<div class="col-md-12 col-xs-12 text-center">
						<p style="font-family:numberfont;color:white;font-size:30px">Please lock screen rotation</p><br>
						<input style="font-family:numberfont;font-size:35px" id="close_orlock" type="button" class="btn button" value="OK">
					</div>
					<div style="display:none;" id="loader" class="col-md-12 col-xs-12 text-left">
						<img id="loader-img" src="img/loading.gif" style="max-width:20px;">
						<span style="color:silver" id="status">Please wait...</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="setting_popup" style="display:none;width:100%;height:100%;z-index:9999;position:fixed;top:0;left:0">
		<div id="setting-popup-inner" style="position:relative;height:100%;width:100%">
			<div style="border-radius:20px;background-color:rgb(84,52,52);padding:0px 16px;width:550px;height:250px;position:absolute;margin:auto;border:5px solid brown;bottom:0;left:0;right:0;">
				<div class="row">
					<div style="margin-top:20px;padding-right:20px" class="col-md-12 col-sm-12 col-xs-12 text-right">
						<a style="color:#ffffff;font-size:30px" href="#" id="setting_popup_close" class="glyphicon glyphicon-remove"></a>
					</div>
				</div>
				<div class="row m20">
					<div class="col-md-6 col-xs-8">
						<div style="margin:auto;width:70%;border:2px solid #A4062C;margin-top:30px;"></div>
					</div>
					<div class="col-md-6 col-xs-4 text-center">
						<input style="font-family:numberfont;font-size:35px;margin-left:0px;" id="y_flip" type="button" class="btn button" value="Flip">
					</div>
					<!-- <div style="display:none;" id="loader" class="col-md-12 col-xs-12 text-left">
						<img id="loader-img" src="img/loading.gif" style="max-width:20px;">
						<span style="color:silver" id="status">Please wait...</span>
					</div> -->
				</div>
				<div class="row m20">
					<div class="col-md-6 col-xs-8">
						<div style="margin:auto;width:70%;border:2px solid #005389;margin-top:30px;"></div>
					</div>
					<div class="col-md-6 col-xs-4 text-center">
						<input style="font-family:numberfont;font-size:35px;margin-left:0px;" id="x_flip" type="button" class="btn button" value="Flip">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- <a href="http://www.google.com.ar" target="_blank" id="_anchor">
    	<span id="_span">text</span>
	</a> -->
</body>
</html>