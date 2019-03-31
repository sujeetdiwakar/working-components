<div id="map" style="height:300px;width:300px;"></div>
<script type="text/javascript">
    var locationsw = [
        ['Bondi Beach', -33.890542, 151.274856, 4],
        ['Coogee Beach', -33.923036, 151.259052, 5],
    ];

    var mapw = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: new google.maps.LatLng(-33.92, 151.25),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var myOptions = {

        autoScroll: false,
        boxStyle: {
            opacity: 0.75,
            width: "280px"
        }
    };

    var infowindow = new google.maps.InfoWindow(myOptions);
    var i, marker;
    for (i = 0; i < locationsw.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locationsw[i][1], locationsw[i][2]),
            map: mapw,
            borderRadius: 20,
            animation: google.maps.Animation.DROP
        });

        google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
            return function () {
                infowindow.setContent(locationsw[i][0]);
                infowindow.open(mapw, marker);
            }
        })(marker, i));
    }
</script>