<?php
include("dbconnect.php"); 
?>
<html>
<head>
<meta charset="utf-8">
<title>Goal 7</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://gitcdn.link/cdn/Stiffcliff/AC31007-AC51003-Agile-Software-Engineering---Group-1/main/Software_Code/style.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!--nav links-->
    <nav class = "nav">
        <ul>
        <li><a href = "frontendhome"><img src="https://raw.githubusercontent.com/Stiffcliff/AC31007-AC51003-Agile-Software-Engineering---Group-1/main/Software_Code/resources/sustainable800.png" height="56.3" alt="Sustainable dundee logo"></a></li>
        <li style= "float: right"><a href="contactus">Contact Us</a></li>
	<li style= "float: right"><a href="map">Interactive Map</a></li>
    </ul>  
    </nav>
</head>
<body>
<div class="row mt-5">
    <div class="col d-flex justify-content-center">
	    <!--header-->
        <br>
        <h2>Making Dundee A Better Place</h2>
        <br>
    </div>
</div>
<hr>
<div class="row">
    <div class="col d-flex mt-2 px-5">
	    <!--info about specific goal-->
        <h3>Goal 7: Affordable and Clean Energy</h3>
    </div>
</div>
<div class="row mt-3 px-5">
    <div class="col">
	<p>
          Ensure access to affordable, reliable, sustainable and modern energy for all.
        </p>
        <h4>Things to do</h4>
        <br>
        <ul>Switch off your appliances at the socket. Turn off the lights when you’re not using them.</ul>
        <br>
        <ul>
          Buy rechargable electronics
        </ul>
        <br>
        <ul>
          Don’t use multiple devices at the same time. Be mindful about this and only several devices when absolutely necessary.
        </ul>
        <br>
    </div>
</div>
<hr>
</body>
<h4>Get involved locally</h4>
<br>
<!--local attractions from DB-->

<?php
$sql = "SELECT EventID,EventName,EventLocation,EventContact,EventDescription FROM cleanenergyevents";
$result = $db->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> Name: ". $row["EventName"]. " Location:" . $row["EventLocation"] . " Contact:". $row["EventContact"]. " Description:". $row["EventDescription"]. "<br>";
    }
} else {
    echo "0 results";
}

$db->close();

?>
<hr>
<div id="map">
<style>
body { margin: 20; padding: 0; }
#map { position: relative; top: 0; bottom: 0; width: 500px; height: 375px}
 #marker {
        background-image: url(https://raw.githubusercontent.com/Stiffcliff/AC31007-AC51003-Agile-Software-Engineering---Group-1/main/Software_Code/marker.png);
        background-size: cover;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        cursor: pointer;
    }

    .mapboxgl-popup {
        max-width: 200px;
    }    
	</style>
<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoibGVpYWVhIiwiYSI6ImNrejRhbncwaTA3djIydXVzcXZ1NzBvcWIifQ.BsUBVvQX-SQoNoJ5HdDOpw';
    //initialise map
    const map = new mapboxgl.Map({
        container: 'map',
	    //map with SD colours
        style: 'mapbox://styles/leiaea/ckz4avyp0001414p9t4mzt7c1',
        center: [-2.9668332, 56.4746004],
        zoom: 9
    });

    //adds navigation tools to map - zoom etc
    const nav = new mapboxgl.NavigationControl();
    map.addControl(nav, 'top-left');

	//control to track user location if requested
    map.addControl(
        new mapboxgl.GeolocateControl({
        positionOptions: {
            enableHighAccuracy: true
        },
        // When active the map will receive updates to the device's location as it changes.
        trackUserLocation: true,
        // Draw an arrow next to the location dot to indicate which direction the device is heading.
        showUserHeading: true
        })
    );
//full screen option
    map.addControl(new mapboxgl.FullscreenControl());

    //set location
    
	const msip = [-2.89078641, 56.48251343];
	const prince_charging = [-2.962418, 56.465627];
	const queen_charging = [-2.875365, 56.468087];
	
	
    // create the popup
    
	const msip_popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
        '<h3>MSIP</h3><p>Michelin Scotland Innovation Parc - world class innovation parc in Dundee for sustainable mobility and decarbonisation</p>'
    );
	const prince_charging_popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
        '<h3>Princes Street Charging Hub</h3><p>EV charging hub with solar canopies.</p>'
    );
	const queen_charging_popup = new mapboxgl.Popup({ offset: 25 }).setHTML(
        '<h3>Queen Street Charging Hub</h3><p>EV charging hub with solar canopies.</p>'
    );
	

    // create DOM element for the marker
    
	const el18 = document.createElement('div');
    el18.id = 'marker';
	const el20 = document.createElement('div');
    el20.id = 'marker';
	const el21 = document.createElement('div');
    el21.id = 'marker';
	

    // create the marker
    
	new mapboxgl.Marker(el18)
        .setLngLat(msip)
        .setPopup(msip_popup) // sets a popup on this marker
        .addTo(map);
	new mapboxgl.Marker(el20)
        .setLngLat(prince_charging)
        .setPopup(prince_charging_popup) // sets a popup on this marker
        .addTo(map);	
	new mapboxgl.Marker(el21)
        .setLngLat(queen_charging)
        .setPopup(queen_charging_popup) // sets a popup on this marker
        .addTo(map);
	
		
</script>
</div>
<hr>	
</html>
