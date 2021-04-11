<?php
include('../function/functions.php');

if (!isMechanic()) {
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
	<title>Mechanic</title>
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
		<h2>Mechanic - Request Page</h2>
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
					<img src="../images/mechanic_profile.jpg"  >

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
			<li><a  href="mhome.php">Profile</a></li>
			<li><a href="request.php">Request</a></li>
			<li><a href="feedback.php">Report</a></li>
			<li><a href="mhome.php?logout='1'" style="margin-left: 1500px;">logout</a></li>
		</ul>
	</nav>

	<div id="side-menu" class="side-nav">
		<div class="profile_info_1">
			<img src="../images/mechanic_profile.jpg"  >

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
		<a href="mhome.php">Profile</a>
		<a href="request.php">Request</a>
		<a href="feedback.php">Report</a>
		<a href="mhome.php?logout='1'">logout</a>
	</div>

	<div id="main">
		<div class="column side">
					<img src="../images/mechanic_profile.jpg" class="centerr" ></br>
				</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
					</br><i class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['firstname']); ?>)</i>
					</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['lastname']); ?>)</i>
				</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['phonenumber']); ?>)</i>
		</div>
		<div class="column middle">
			<form>


				<div id="map"></div>

				<!------ Include the above in your HEAD tag ---------->
				<script>
						var map;
						var marker;
						var infowindow;
						var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
						var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
						var green_icon =  'http://maps.google.com/mapfiles/ms/icons/green-dot.png' ;
						var blue_icon =  'http://maps.google.com/mapfiles/ms/icons/blue-dot.png' ;
						var requested = <?php get_all_requested() ?>;
						var locations = <?php get_specific_workshop() ?>;

						function initMap() {
								var france = {lat: 1.8635, lng: 103.1089};
								infowindow = new google.maps.InfoWindow();
								map = new google.maps.Map(document.getElementById('map'), {
										center: france,
										zoom: 15
								});


								var i ; var confirmed = 0;
								for (i = 0; i < requested.length; i++) {

										marker = new google.maps.Marker({
												position: new google.maps.LatLng(requested[i][1], requested[i][2]),
												map: map,
												icon :   requested[i][4] === '1' ?  blue_icon  : green_icon,
												html: document.getElementById('form')
										});


										google.maps.event.addListener(marker, 'click', (function(marker, i) {
												return function() {
														confirmed =  requested[i][4] === '1' ?  'checked'  :  0;
														$("#confirmed").prop(confirmed,requested[i][4]);
														$("#id").val(requested[i][0]);
														$("#description").val(requested[i][3]);
														$("#firstname").val(requested[i][6]);
														$("#lastname").val(requested[i][7]);
														$("#phonenumber").val(requested[i][8]);
														$("#form").show();
														infowindow.setContent(marker.html);
														infowindow.open(map, marker);
												}
										})(marker, i));
								}

								for (i = 0; i < locations.length; i++) {

										marker = new google.maps.Marker({
												position: new google.maps.LatLng(locations[i][1], locations[i][2]),
												map: map,
												icon :   locations[i][4] === '1' ?  red_icon  : purple_icon,
												html: document.getElementById('form')
										})(marker, i);
									}

						}

						function saveData() {
								var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
								var id = document.getElementById('id').value;
								var url = '../function/functions.php?confirm_location&id=' + id + '&confirmed=' + confirmed ;
								downloadUrl(url, function(data, responseCode) {
										if (responseCode === 200  && data.length > 1) {
												infowindow.close();
												window.location.reload(true);
										}else{
												infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
										}
								});
						}

						function finish() {
								var id = document.getElementById('id').value;
								var url = '../function/functions.php?finish_location&id=' + id;
								downloadUrl(url, function(data, responseCode) {
										if (responseCode === 200  && data.length > 1) {
												infowindow.close();
												window.location.reload(true);
										}else{
												infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
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

				<div style="display: none" id="form">
						<table class="map1">
							<tr>
									<input name="id" type='hidden' id='id'/>
									<td><a>First Name:</a></td>
									<td><textarea id='firstname' placeholder='Description'disabled></textarea></td>
							</tr>
							<tr>
									<input name="id" type='hidden' id='id'/>
									<td><a>lastname:</a></td>
									<td><textarea id='lastname' placeholder='Description'disabled></textarea></td>
							</tr>
							<tr>
									<input name="id" type='hidden' id='id'/>
									<td><a>Phone Number:</a></td>
									<td><textarea id='phonenumber' placeholder='Description'disabled></textarea></td>
							</tr>
								<tr>
										<input name="id" type='hidden' id='id'/>
										<td><a>Description:</a></td>
										<td><textarea id='description' placeholder='Description'disabled></textarea></td>
								</tr>
								<tr>
										<td><b>Confirm Location ?:</b></td>
										<td><input id='confirmed' type='checkbox' name='confirmed'></td>
								</tr>

								<tr><td></td><td><input type='button' class=btn value='Save' onclick='saveData()'/></td></tr>
								<tr><td></td><td><input type='button' class=btn value='Finish' onclick='finish("+id+")'/></td></tr>
						</table>
				</div>
				<script async defer
								src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBkN8FOWtIP6kWKDjCtQrz7Ude96XNCZxA&callback=initMap">
				</script>
			</form>
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
