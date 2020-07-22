<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css' rel='stylesheet' />
<div id="home">
    <div class="home_item">
        <img class="tut_links" id="tut1" src="./Picture/pin.PNG" alt="tut1">
        <div class="home_beschreibung">
            <div class="home_beschreibung_title">Search your flight</div>
            Beispiel Beispiel Beispiel Beispiel Beispiel Beispiel Beispiel Beispiel
        </div>
    </div>
    <div class="home_item">
        <div class="home_beschreibung">
            <div class="home_beschreibung_title">Radar</div>
            <p id="anzFlug"></p>
        </div>
        <div id='map' style='width: 100%; height: 500px; margin-top: 50px;color: black;'></div>
        <script>
            //erstellen der Grundkomponenten für die Map
            mapboxgl.accessToken = "pk.eyJ1IjoidHJhZmFsZ2FyMSIsImEiOiJja2JrbmxuOG8wN2F5MnRyNWg2OHZtMmh6In0.PvtUAJD4oh43WPqofs_XZA";
            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [7, 46.907],
                zoom: 4.20
            });

            //Sobald die Map geladen wird fügt der Map die Icons an den aus der API ausgelesenen Koordinaten hinzu mit den zusätzlichen Infos (hier nur ICAO) Intervall alle 2 Sekunden
            map.on('load', function() {
                window.setInterval(async function() {
                    response = await getFlights();
                    var flightListComplete={
                        'type': 'FeatureCollection',
                        'features': []};
                    for (var flight in response) {
                        if(response[flight][5]!=null && response[flight][6]!=null) {

                            flightListComplete["features"]
                                .push({
                                    "type": "Feature",
                                    "properties": {
                                        "description":
                                            response[flight][0]
                                        ,
                                        "icon": "airport",

                                    },
                                    "geometry": {
                                        "type": "Point",
                                        "coordinates": [response[flight][5], response[flight][6]]
                                    }
                                });
                        }
                    }
                    map.getSource('places').setData(flightListComplete);
                    document.getElementById("anzFlug").innerHTML = "Es sind "+response.length+" Flugzeuge unterwegs";
                    console.log(flightListComplete);

                },2000);
                map.addSource('places', {
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': [
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description':
                                        "<strong>A Little Night Music</strong><p>The Arlington Players' production of Stephen Sondheim's <em>A Little Night Music</em> comes to the Kogod Cradle at The Mead Center for American Theater (1101 6th Street SW) this weekend and next. 8:00 p.m.</p>",
                                    'icon': 'music'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [-77.020945, 38.878241]
                                }
                            }
                        ]
                    }
                });
// Fügt der Map einen Layer mit Symbolen hinzu
                map.addLayer({
                    'id': 'places',
                    'type': 'symbol',
                    'source': 'places',
                    'layout': {
                        'icon-image': '{icon}-15',
                        'icon-allow-overlap': true
                    }
                });

// Kreiert ein Popup
                var popup = new mapboxgl.Popup({
                    closeButton: false,
                    closeOnClick: false
                });

                map.on('mouseenter', 'places', function(e) {
// Cursorstyle
                    map.getCanvas().style.cursor = 'pointer';

                    var coordinates = e.features[0].geometry.coordinates.slice();
                    var description = e.features[0].properties.description;

// Ist für den overlap beim Zoom nötig
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

// setzt die Popups
                    popup
                        .setLngLat(coordinates)
                        .setHTML(description)
                        .addTo(map);
                });

                map.on('mouseleave', 'places', function() {
                    map.getCanvas().style.cursor = '';
                    popup.remove();
                });
            });
//macht die Anfrage an die Api und liefer die Response
            async function getFlights() {
                var targetUrl="http://fet.local/API.php";
                var response=await fetch(targetUrl)
                    .then( response => response.text())
                response = JSON.parse(response);
                response = response["states"];
                return response;
            }



        </script>
    </div>
</div>