<?php
include('../function/functions.php');

if (!isDriver()) {
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
	<title>Driver</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" type="text/css" href="../css/navstyle.css">
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

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
<body>
	<div class="header">
		<h2>Driver - Request Towing Page</h2>
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
			<img src="../images/driver_profile.png"  >

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
			<li><a href="dhome.php">Profile</a></li>
			<li><a href="request.php">Request</a></li>
			<li><a href="feedback.php">Report</a></li>
			<li><a href="dhome.php?logout='1'" style="margin-left: 1500px;" >logout</a></li>
		</ul>
	</nav>

	<div id="side-menu" class="side-nav">
		<div class="profile_info_1">
			<img src="../images/driver_profile.png"  >

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
		<a href="dhome.php">Profile</a>
		<a href="request.php">Request</a>
		<a href="feedback.php">Report</a>
		<a href="dhome.php?logout='1'">logout</a>
	</div>

	<div id="main">

	</div>

	<div id="main">
		<div class="row">
	<div class="column side">
				<img src="../images/driver_profile.png" class="centerr" ></br>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
				</br><i class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['firstname']); ?>)</i>
				</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['lastname']); ?>)</i>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['phonenumber']); ?>)</i>
	</div>
	<div class="column middle">
		<form>
				<input type="text" name="username" value="<?php echo $_SESSION['user']['username']; ?>" hidden>

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
						var blue_icon =  'http://maps.google.com/mapfiles/ms/icons/blue-dot.png' ;
						var green_icon =  'http://maps.google.com/mapfiles/ms/icons/green-dot.png' ;
						var located = <?php get_user_location() ?>;
						var requested = <?php get_confirmed_towing_requested() ?>;
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
										"                <td><a>Description:</a></td>\n" +
										"                <td><textarea  id='manual_description' placeholder='Description'></textarea></td></tr>\n" +
										"         	  <td><input type='text'  id='service_type' value='towing' hidden></textarea></td></tr>\n" +
										"             <td><input type='text'  id='username' value='<?php echo $_SESSION['user']['username'];?>' hidden></textarea></td></tr>\n" +
										"             <td><input type='text'  id='firstname' value='<?php echo $_SESSION['user']['firstname'];?>' hidden></textarea></td></tr>\n" +
										"             <td><input type='text'  id='lastnme' value='<?php echo $_SESSION['user']['lastname'];?>' hidden></textarea></td></tr>\n" +
										"             <td><input type='text'  id='phonenumber' value='<?php echo $_SESSION['user']['phonenumber'];?>' hidden></textarea></td></tr>\n" +
										"            <tr><td></td><td><input type='button' value='Save' class=btn onclick='saveData("+lat+","+lng+")'/></td></tr>\n" +
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
						 * loop through (Mysql) dynamic requested to add markers to map.
						 */
						var i ; var confirmed = 0;
						for (i = 0; i < requested.length; i++) {
								marker = new google.maps.Marker({
										position: new google.maps.LatLng(requested[i][1], requested[i][2]),
										map: map,
										icon :   requested[i][4] === '1' ?  red_icon  : purple_icon,
										html: "<div>\n" +
										"<table class=\"map1\">\n" +
										"<td><textarea disabled id='workshopname' placeholder='workshopname'>"+requested[i][7]+"</textarea></td></tr>\n" +
										"<td><textarea disabled id='wphonenumber' placeholder='wphonenumbere'>"+requested[i][8]+"</textarea></td></tr>\n" +
										"<td><textarea hidden id='workshopusername' placeholder='workshopusername'>"+requested[i][6]+"</textarea></td></tr>\n" +
										"<td><textarea disabled id='manual_description' placeholder='Description'>"+requested[i][3]+"</textarea></td></tr>\n" +
										"<td><input type='button' value='Request' class=btn onclick='saveReq()'/></td></tr>\n" +
										"</table>\n" +
										"</div>"
								});

								google.maps.event.addListener(marker, 'click', (function(marker, i) {
										return function() {
												infowindow = new google.maps.InfoWindow();
												confirmed =  requested[i][4] === '1' ?  'checked'  :  0;
												$("#confirmed").prop(confirmed,requested[i][4]);
												$("#id").val(requested[i][0]);
												$("#workshopusername").val(requested[i][6]);
												$("#workshopname").val(requested[i][7]);
												$("#wphonenumber").val(requested[i][8]);
												$("#description").val(requested[i][3]);
												$("#form").show();
												infowindow.setContent(marker.html);
												infowindow.open(map, marker);
										}
								})(marker, i));
						}

						var i ; var confirmed = 0;
						for (i = 0; i < located.length; i++) {
								marker = new google.maps.Marker({
										position: new google.maps.LatLng(located[i][1], located[i][2]),
										map: map,
										icon :   located[i][4] === '1' ?  blue_icon  : green_icon,
										html: "<div>\n" +
										"<table class=\"map1\">\n" +
										"<tr>\n" +
										"<td><textarea disabled id='workshopname' placeholder='workshopname'>"+requested[i][7]+"</textarea></td></tr>\n" +
										"<td><textarea disabled id='wphonenumber' placeholder='wphonenumbere'>"+requested[i][8]+"</textarea></td></tr>\n" +
										"<td><textarea hidden id='workshopusername' placeholder='workshopusername'>"+requested[i][6]+"</textarea></td></tr>\n" +
										"<td><textarea disabled id='manual_description' placeholder='Description'>"+requested[i][3]+"</textarea></td></tr>\n" +
										"<td><input type='button' value='Request' class=btn  onclick='saveReq()'/></td></tr>\n" +
										"</table>\n" +
										"</div>"
								});
							}

						/**
						 * SAVE save marker from map.
						 * @param lat  A latitude of marker.
						 * @param lng A longitude of marker.
						 */
						 function saveReq() {
							 var workshopusername = document.getElementById('workshopusername').value;
							 var url = '../function/functions.php?add_request&workshopusername=' + workshopusername;
							 downloadUrl(url, function(data, responseCode) {
									if (responseCode === 200  && data.length > 1) {
											infowindow.close();
											window.location.reload(true);
											infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting SUccess</div>");
									}else{
											infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
									}
							 });
						 }

						function saveData(lat,lng) {
								var description = document.getElementById('manual_description').value;
								var service_type = document.getElementById('service_type').value;
								var username = document.getElementById('username').value;
								var firstname = document.getElementById('firstname').value;
								var lastname = document.getElementById('lastnme').value;
								var phonenumber = document.getElementById('phonenumber').value;
								var url = '../function/functions.php?add_towing_location&description=' + description + '&lat=' + lat + '&lng=' + lng + '&service_type=' + service_type + '&username=' + username + '&firstname=' + firstname + '&lastname=' + lastname + '&phonenumber=' + phonenumber;
								downloadUrl(url, function(data, responseCode) {
										if (responseCode === 200  && data.length > 1) {
												var markerId = getMarkerUniqueId(lat,lng); // get marker id by using clicked point's coordinate
												var manual_marker = markers[markerId]; // find marker
												manual_marker.setIcon(green_icon);
												infowindow.close();
												infowindow.setContent("<div style=' color: red; font-size: 25px;'> location saved!!</div>");
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
		<img width="100%" height="100%" src="../images/driverguideline.jpg" alt="">
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
<?php
//<td><button style="margin-left:auto;margin-right:auto;display:block;margin-top:5%;margin-bottom:0%" type="submit" class="btn" name="requestservice_bt">Send Request</button></td>
 ?>
