<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<title>Google Map</title>
</head>
<style type="text/css">
	#map{
		height: 80%;
	}
	html , body {
		height: 100%;
	}
</style>
<body onload="myfunction();">
<div class="container-fluid upper">
	<div class="row">
		<div class="col-md-2">
			<input type="button" value="Get Direction" name="btn" class="form-control" id="getdirection" />
		</div>
	</div>
</div>
<div id="map">
</div>
</body>
</html>
<script type="text/javascript">
	function myfunction(){
		var map;
		var swabi = new google.maps.LatLng(34.0718684,72.4731529);
		var peshawar = new google.maps.LatLng(34.0151366,71.5249154);
		var option ={
			zoom : 10,
			center : swabi 
		};
		map = new google.maps.Map(document.getElementById('map'),option);
		var display = new google.maps.DirectionsRenderer();
		var services = new google.maps.DirectionsService();
		display.setMap(map);
		function calculateroute(){
			var request ={
				origin : swabi,
				destination:peshawar,
				travelMode: 'DRIVING'
			};
			services.route(request,function(result,status){
				//console.log(result,status);
				if(status =='OK'){
					display.setDirections(result);
				}
			});
		}
		document.getElementById('getdirection').onclick= function(){
			calculateroute();
		}
	}
</script>
<!-- google map api -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR API KEY&libraries=places"></script>