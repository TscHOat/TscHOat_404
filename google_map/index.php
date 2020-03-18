<!DOCTYPE html>
<html>

<head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #map {
            height: 550px;
        }

        /* Optional: Makes the sample page fill the window. */
        html,
        body {
            /* height: 100%; */
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
<table>
        <tr>
            <td>
                Masukan Radius (meter) :
            </td>
            <!-- input radius -->
            <td><input type="text" id="rad"></td>
        </tr>

        <tr>
            <td>Jumlah bangunan di area : </td>
            <td>
                <div id="radt">
                    <!-- hasil perhitungan -->
                    <div id="count">
                    </div>

                </div>
            </td>
        </tr>

        <div id="point">
        </div>

    </table>
    <div id="map"></div>
    <script>
        // INITIALIZATION
        var pointT = document.getElementById('point');

        var radiusT = document.getElementById('radt');
        var lat;
        var long;
        var radius;
        var buildings;


        //AJAX
        var response;
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // processing data response dari overpass
                response = this.responseText;
                response = response.replace("@id\n", "");
                buildings = response.split("\n")
                document.getElementById('count').innerHTML = buildings.length-1;
            }
        };


        var map;
        var circle;

        function initMap() {
            // init map
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: -6.175520,
                    lng: 106.827185
                },
                mapTypeId: 'satellite',
                zoom: 15
            });
            map.addListener('click', function(e) {
                //get radius from input where id = rad
                pointT.innerHTML = e.latLng;
                var radius = document.getElementById('rad');
                radius = radius.value;

                // AJAX
                xhttp.open("GET", "http://overpass-api.de/api/interpreter?data=%5Bout%3Acsv%28%3A%3Aid%29%5D%5Btimeout%3A25%5D%3B%0A%28%0A%20%20way%0A%20%20%20%20%5B%22building%22%5D%28around%3A" +
                    radius +
                    "%2C" +
                    e.latLng.lat() +
                    "%2C" +
                    e.latLng.lng() +
                    "%29%3B%0A%29%3B%0Aout%20body%3B",
                    true);
                xhttp.send();

                // clear all circle if exist
                if(circle!=null){
                    clear_circle();
                }
                // create circle
                circle = new google.maps.Circle({
                    strokeColor: "#FF0000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: "#FF0000",
                    fillOpacity: 0.35,
                    center: {
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng()
                    },
                    radius: parseInt(radius)
                });
                circle.setMap(map);
            });
        }
        // clear circle function
        function clear_circle(){
            circle.setMap(null);
        }
    </script>
    <!-- import google map javascript -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOLBRaw85VRXq1kwX41-3IRKk22XHMD0Y&callback=initMap" async defer></script>
</body>

</html>