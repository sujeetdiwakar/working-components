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
<input type="text" id="latitude" name="latitude">
<input type="text" id="longitude" name="longitude">
</div>
<div id="map">
</div>
</body>
</html>
<script type="text/javascript">
	function myfunction(){
		if(navigator.geolocation){
			navigator.geolocation.getCurrentPosition(showPostion);
		}else{
			alert('Not support');
		}
		
		function showPostion(position){
			
			document.getElementById('latitude').value = position.coords.latitude;
			document.getElementById('longitude').value = position.coords.longitude;
			
		}
	}
</script>
<!-- google map api -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR API KEY&libraries=places"></script>