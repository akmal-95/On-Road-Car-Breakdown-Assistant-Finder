<?php
include('../function/functions.php');

if (!isWorkshop()) {
	$_SESSION['msg'] = "You must log in first";
	header('location: ../login.php');
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: ../login.php");
}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Workshop</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/navstyle.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<style>
	input{
		border: 0px;
	}

	input:disabled {
background: white;
 }

 textarea:disabled{
	background: white;
	border: 0px;
 }

	</style>
</head>
<body>
	<div class="header">
		<h2>Workshop - Location Page</h2>
	</div>
	<div class="content">
		<!-- notification message -->
		<?php if (isset($_SESSION['success'])) : ?>
			<div class="error success" >
				<h3>
					<?php
						echo $_SESSION['success'];
						unset($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>

		<!-- logged in user information -->
		<div class="profile_info">
			<img src="../images/workshop_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>

					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
						<br>
					</small>
				<?php endif ?>
			</div>
		</div>
	</div>
	<nav class="navbar">
		<span class="open-slide">
			<a href="#" onclick="openSlideMenu()">
				<svg width="30" height="30">
						<path d="M0,5 30,5" stroke="#fff" stroke-width="5"/>
						<path d="M0,14 30,14" stroke="#fff" stroke-width="5"/>
						<path d="M0,23 30,23" stroke="#fff" stroke-width="5"/>
				</svg>
			</a>
		</span>

		<ul class="navbar-nav">
			<li><a href="whome.php">Profile</a></li>
			<li><a href="mechanic.php">List Mechanic</a></li>
			<li><a href="location.php">Location</a></li>
			<li><a href="feedback.php">Report</a></li>
			<li><a href="addmechanic.php">Add Mechanic</a></li>
			<li><a href="whome.php?logout='1'" style="margin-left: 1200px">Logout</a></li>
		</ul>
	</nav>

	<div id="side-menu" class="side-nav">
		<div class="profile_info_1">
			<img src="../images/workshop_profile.png"  >

			<div>
			<?php  if (isset($_SESSION['user'])) : ?>
					<i  style=" margin-left:70px;color: #888;"><?php echo ucfirst($_SESSION['user']['username']); ?></i></p>
					<small>
						<i  style="margin-left:70px; color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i></p>
						<i  style="margin-left:70px; color: #888;">(<?php echo ucfirst($_SESSION['user']['firstname']); ?>)</i></p>
						<i  style="margin-left:70px; color: #888;">(<?php echo ucfirst($_SESSION['user']['lastname']); ?>)</i></p>
					<br>
					</small>
				</br>
				<?php endif ?>
			</div>
		</div>
		<a href="#" class="btn-close" onclick="closeSlideMenu()">&times;</a>
		<a href="whome.php">Profile</a>
		<a href="mechanic.php">List Mechanic</a>
		<a href="location.php">Location</a>
		<a href="feedback.php">Feedback</a>
		<a href="addmechanic.php">Add Mechanic</a>
		<a href="whome.php?logout='1'" style="color: red;margin-left: 250px">logout</a>
	</div>

	<div id="main">
		<div class="row">
	<div class="column side">
				<img src="../images/workshop_profile.png" class="centerr" ></br>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
				</br><i class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['firstname']); ?>)</i>
				</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['lastname']); ?>)</i>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['phonenumber']); ?>)</i>
		</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['workshopname']); ?>)</i>
	</br><i  class="centerr" style="color: #888;"><?php echo ucfirst($_SESSION['user']['address']); ?></i>
	</div>
	<div class="column middle">
		<form>
				<script type="text/javascript"
								src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBkN8FOWtIP6kWKDjCtQrz7Ude96XNCZxA">
				</script>

				<div id="map"></div>
				<script>
						/**
						 * Create new map
						 */
						var infowindow;
						var map;
						var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
						var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
						var locations = <?php get_confirmed_workshop_locations() ?>;
						var myOptions = {
								zoom: 15,
								center: new google.maps.LatLng(1.8635, 103.1089),
								mapTypeId: 'roadmap'
						};
						map = new google.maps.Map(document.getElementById('map'), myOptions);

						/**
						 * Global marker object that holds all markers.
						 * @type {Object.<string, google.maps.LatLng>}
						 */
						var markers = {};

						/**
						 * Concatenates given lat and lng with an underscore and returns it.
						 * This id will be used as a key of marker to cache the marker in markers object.
						 * @param {!number} lat Latitude.
						 * @param {!number} lng Longitude.
						 * @return {string} Concatenated marker id.
						 */
						var getMarkerUniqueId= function(lat, lng) {
								return lat + '_' + lng;
						};

						/**
						 * Creates an instance of google.maps.LatLng by given lat and lng values and returns it.
						 * This function can be useful for getting new coordinates quickly.
						 * @param {!number} lat Latitude.
						 * @param {!number} lng Longitude.
						 * @return {google.maps.LatLng} An instance of google.maps.LatLng object
						 */
						var getLatLng = function(lat, lng) {
								return new google.maps.LatLng(lat, lng);
						};

						/**
						 * Binds click event to given map and invokes a callback that appends a new marker to clicked location.
						 */
						var addMarker = google.maps.event.addListener(map, 'click', function(e) {
								var lat = e.latLng.lat(); // lat of clicked point
								var lng = e.latLng.lng(); // lng of clicked point
								var markerId = getMarkerUniqueId(lat, lng); // an that will be used to cache this marker in markers object.
								var marker = new google.maps.Marker({
										position: getLatLng(lat, lng),
										map: map,
										animation: google.maps.Animation.DROP,
										id: 'marker_' + markerId,
										html: "    <div id='info_"+markerId+"'>\n" +
										"        <table class=\"map1\">\n" +
										"            <tr>\n" +
										"           <td><input type='text'  id='workshopusername' value='<?php echo $_SESSION['user']['username'];?>' hidden></textarea></td></tr>\n" +
										"           <td><input type='text'  id='firstname' value='<?php echo $_SESSION['user']['firstname'];?>' hidden></textarea></td></tr>\n" +
										"           <td><input type='text'  id='lastname' value='<?php echo $_SESSION['user']['lastname'];?>' hidden></textarea></td></tr>\n" +
										"           <td><input type='text'  id='phonenumber' value='<?php echo $_SESSION['user']['phonenumber'];?>' hidden></textarea></td></tr>\n" +
										"           <td><input type='text'  id='workshopname' value='<?php echo $_SESSION['user']['workshopname'];?>' disabled></textarea></td></tr>\n" +
										"           <tr><td><textarea  id='manual_description' placeholder='Address'></textarea></td></tr>\n" +
										"           <tr><td><textarea  id='wphonenumber' placeholder='Phonenumber'></textarea></td></tr>\n" +
										"           <tr><td><input id='towing' type='checkbox' name='towing'><a>Towing</a></td></tr>\n"+
										"           <tr><td><input id='tyres' type='checkbox' name='tyres'><a>Tyres</a></td></tr>\n"+
										"           <tr><td><input id='battery' type='checkbox' name='battery'><a>Battery</a></td></tr>\n"+
										"           <tr><td><input id='mechanic' type='checkbox' name='mechanic'><a>Mechanic</a></td></tr>\n"+
										"            <tr><td><input type='button' value='Save' class=btn onclick='saveData("+lat+","+lng+")'/></td></tr>\n" +
										"        </table>\n" +
										"    </div>"
								});
								markers[markerId] = marker; // cache marker in markers object
								bindMarkerEvents(marker); // bind right click event to marker
								bindMarkerinfo(marker); // bind infowindow with click event to marker
						});


						/**
						 * Binds  click event to given marker and invokes a callback function that will remove the marker from map.
						 * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
						 */
						var bindMarkerinfo = function(marker) {
								google.maps.event.addListener(marker, "click", function (point) {
										var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
										var marker = markers[markerId]; // find marker
										infowindow = new google.maps.InfoWindow();
										infowindow.setContent(marker.html);
										infowindow.open(map, marker);
										// removeMarker(marker, markerId); // remove it
								});
						};

						/**
						 * Binds right click event to given marker and invokes a callback function that will remove the marker from map.
						 * @param {!google.maps.Marker} marker A google.maps.Marker instance that the handler will binded.
						 */
						var bindMarkerEvents = function(marker) {
								google.maps.event.addListener(marker, "rightclick", function (point) {
										var markerId = getMarkerUniqueId(point.latLng.lat(), point.latLng.lng()); // get marker id by using clicked point's coordinate
										var marker = markers[markerId]; // find marker
										removeMarker(marker, markerId); // remove it
								});
						};

						/**
						 * Removes given marker from map.
						 * @param {!google.maps.Marker} marker A google.maps.Marker instance that will be removed.
						 * @param {!string} markerId Id of marker.
						 */
						var removeMarker = function(marker, markerId) {
								marker.setMap(null); // set markers setMap to null to remove it from map
								delete markers[markerId]; // delete marker instance from markers object
						};


						/**
						 * loop through (Mysql) dynamic locations to add markers to map.
						 */
						var i ; var confirmed = 0;
						for (i = 0; i < locations.length; i++) {
								marker = new google.maps.Marker({
										position: new google.maps.LatLng(locations[i][1], locations[i][2]),
										map: map,
										icon :   locations[i][4] === '1' ?  red_icon  : purple_icon,
										html: "<div>\n" +
										"<table class=\"map1\">\n" +
										"<tr>\n" +
										"<td><textarea disabled type='text'  id='workshopname' placeholder='workshopname'>"+locations[i][5]+"</textarea></td></tr>\n" +
										"<td><textarea disabled id='manual_description' placeholder='Description'>"+locations[i][6]+"</textarea></td></tr>\n" +
										"<td><textarea disabled id='wphonenumber' placeholder='wphonenumbern'>"+locations[i][3]+"</textarea></td></tr>\n" +
										"</table>\n" +
										"</div>"
								});

								google.maps.event.addListener(marker, 'click', (function(marker, i) {
										return function() {
												infowindow = new google.maps.InfoWindow();
												confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
												$("#confirmed").prop(confirmed,locations[i][4]);
												$("#id").val(locations[i][0]);
												$("#workshopname").val(locations[i][5]);
												$("#description").val(locations[i][3]);
												$("#form").show();
												infowindow.setContent(marker.html);
												infowindow.open(map, marker);
										}
								})(marker, i));
						}

						/**
						 * SAVE save marker from map.
						 * @param lat  A latitude of marker.
						 * @param lng A longitude of marker.
						 */
						function saveData(lat,lng) {
								var workshopusername = document.getElementById('workshopusername').value;
								var firstname = document.getElementById('firstname').value;
								var lastname = document.getElementById('lastname').value;
								var phonenumber = document.getElementById('phonenumber').value;
								var workshopname = document.getElementById('workshopname').value;
								var description = document.getElementById('manual_description').value;
								var wphonenumber = document.getElementById('wphonenumber').value;
								var towing = document.getElementById('towing').checked ? 1 : 0;
								var tyres = document.getElementById('tyres').checked ? 1 : 0;
								var battery = document.getElementById('battery').checked ? 1 : 0;
								var mechanic = document.getElementById('mechanic').checked ? 1 : 0;
								var url = '../function/functions.php?add_workshop_location&description=' + description + '&lat=' + lat + '&lng=' + lng + '&towing=' + towing + '&tyres=' + tyres + '&battery=' + battery + '&mechanic=' + mechanic + '&workshopusername=' + workshopusername + '&firstname=' + firstname + '&lastname=' + lastname + '&phonenumber=' + phonenumber + '&workshopname=' + workshopname + '&wphonenumber=' + wphonenumber;
								downloadUrl(url, function(data, responseCode) {
										if (responseCode === 200  && data.length > 1) {
												var markerId = getMarkerUniqueId(lat,lng); // get marker id by using clicked point's coordinate
												var manual_marker = markers[markerId]; // find marker
												manual_marker.setIcon(purple_icon);
												infowindow.close();
												infowindow.setContent("<div style=' color: purple; font-size: 25px;'> Waiting for admin confirm!!</div>");
												infowindow.open(map, manual_marker);

										}else{
												console.log(responseCode);
												console.log(data);
												infowindow.setContent("<div style='color: red; font-size: 25px;'>Inserting Errors</div>");
										}
								});
						}

						function downloadUrl(url, callback) {
								var request = window.ActiveXObject ?
										new ActiveXObject('Microsoft.XMLHTTP') :
										new XMLHttpRequest;

								request.onreadystatechange = function() {
										if (request.readyState == 4) {
												callback(request.responseText, request.status);
										}
								};

								request.open('GET', url, true);
								request.send(null);
						}


				</script>
		</form>
			</div>
		<div class="column side">
			<img width="100%" height="100%" src="../images/workshopguideline.jpg" alt="">
		</div>
	</div>
		</div>


	<script>
		function openSlideMenu(){
			document.getElementById('side-menu').style.width = '250px';
			document.getElementById('main').style.marginLeft = '250px';
		}

		function closeSlideMenu(){
			document.getElementById('side-menu').style.width = '0';
			document.getElementById('main').style.marginLeft = '0';
		}
	</script>


</body>
</html>
