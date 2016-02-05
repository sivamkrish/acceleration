<?php
	$con=mysqli_connect("phonelabsorg.ipowermysql.com","wrdbKxB6VLc","fIT3d0VEbx","wrd_h156hmma46") or die("cannot connect");
	$q=mysqli_query($con,"SELECT * FROM catchit where id='".$_GET['id']."'");
	if($q)
	{
		$row=mysqli_fetch_row($q);
		$data=$row[1];
		$id=$row[0];
	}else{
		print "Error";
	}
?>
<!Doctype html>
<html lang="en">
<head>
	<meta name="viewport" container="user-scalable=no, initial-scale=1.0,maximum-scale=1.0, width=device-width, height=device-height">
	<meta name="apple-mobile-web-app-capable" container="yes">
	<meta http-equiv="container-type" container="text/html; charset=utf-8" />
	<title>Catchit Web App</title>
	<link rel="icon"  type="image/x-icon" href="img/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<!--<script type="text/javascript" src="js/main.js"></script>-->
	 <script type="text/javascript"
          src="https://www.google.com/jsapi?autoload={
            'modules':[{
              'name':'visualization',
              'version':'1',
              'packages':['corechart']
            }]
          }"></script>
	<script type="text/javascript">	
		var json="<?php print $data ?>";
		dataRefId="<?php print $id ?>";
		json=Base64.decode(json);
		json=$.parseJSON(json);
		var x,y,z,t;
		x=y=z=t=[];


		var ddd=[];
		// $.each(json.data,function(k,v)
		// {
		// 	x.push([v.t,v.x]);
		// 	y.push([v.t,v.y]);
		// 	z.push([v.t,v.z]);
		// });
		ddd.push(['Time MilSec', 'X Meters/Sec2', 'Y Meters/Sec2','Z Meters/Sec2']);
		$.each(json.data,function(k,v)
		{
			ddd.push([v.t,v.x,v.y,v.z]);
			rec_array.push({"t":v.t,"x":v.x,"y":v.y,"z":v.z});
		});

		google.setOnLoadCallback(drawChart);

      function drawChart() {
        // var data = google.visualization.arrayToDataTable([
        //   ['Year', 'Sales', 'Expenses'],
        //   ['2004',  1000,      400],
        //   ['2005',  1170,      460],
        //   ['2006',  660,       1120],
        //   ['2007',  1030,      540]
        // ]);

		var data = google.visualization.arrayToDataTable(ddd);

        var options = {
          title: 'Chatch-it : PhoneLabs WebApp\'s Data',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
	</script>
	<script type="text/javascript">
	$(document).ready(function()
	{
		$("#chart_email").click(function()
		{
			$("#emailpopup").show();
			$("#loader").hide();
			if(localStorage.getItem("PL_Email")!=null)
			{
				$("#EMAIL_FIELD").val(localStorage.getItem("PL_Email"));
			}
		});
		$("#emailButtonSend").click(function()
		{
			var address = document.getElementById('EMAIL_FIELD').value;
			sendmail(address);
		});
		$("#popup-inner").click(function(e)
		{
			if($(e.target).attr("id")=="popup-inner")
			{
				$("#emailpopup").hide();
			}
		});
		$("#emailclose").click(function()
		{
			$("#emailpopup").hide();
		});
	});
	</script>
	<style type="text/css">
		body,.container-fluid{
			padding: 0;
			margin:0;
		}
		body,html,.container-fluid,#curve_chart{
			height:100%;
			background-color: #ffffff !important;
		}	
		.h100{
			height: 75%;
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div style="margin-top:20px" class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<img style="margin:auto" src="img/xl_logo.png" class="img-responsive">
			</div>
		</div>
		<div class="h100 row m20">
			<div class="h100 col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="curve_chart" style="width: 100%; height: 100%"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 text-center">
				<input style="font-size: 20px;padding: 5px 20px;" id="chart_email" type="button" class="btn button" value="Email Data">
			</div>
		</div>
	</div>
	<div id="emailpopup" style="display:none;width:100%;height:100%;background-color:rgba(255,255,255,0.5);z-index:9999;position:fixed;top:0;left:0">
		<div id="popup-inner" style="position:relative;height:100%;width:100%">
			<div style="border-radius:20px;background-color:#eee;padding:50px;width:450px;height:180px;position:absolute;margin:auto;border:5px solid rgba(0,0,0,0.4);top:0;bottom:0;left:0;right:0">
				<!-- <span style="cursor:pointer;position: absolute;top:10px;right:10px;color: rgba(0,0,0,0.4);" id="emailclose">
					<i class="glyphicon glyphicon-remove"></i>
				</span> -->
				<div class="row">
					<div class="col-md-12 col-xs-12 text-center">
						<input id="EMAIL_FIELD" type="text" placeholder="Email" class="form-control">
					</div>
				</div>
				<div class="row m20">
					<div class="col-md-12 col-xs-12 text-center">
						<input id="emailButtonSend" type="button" class="btn button" value="Send Email">
						<input style="margin-left:20px" id="emailclose" type="button" class="btn button" value="Close">
						<!-- <input id="linkGraph" type="button" class="btn button" value="See Graph"> -->
					</div>
					<div style="display:none;" id="loader" class="col-md-12 col-xs-12 text-left">
						<img id="loader-img" src="img/loading.gif" style="max-width:20px;">
						<span style="color:silver" id="status">Sending Email...</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>