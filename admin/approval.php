<?php
include('../function/functions.php');

if (!isAdmin()) {
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
	<title>Admin</title>
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
</head>
<body>
	<div class="header">
		<h2>Admin - Approve Workshop Location</h2>
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
			<img src="../images/admin_profile.png"  >

			<div>
				<?php  if (isset($_SESSION['user'])) : ?>
					<strong><?php echo $_SESSION['user']['username']; ?></strong>
					<small>
						<i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
						<br>
					</small>
				</br>
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
      <li><a href="home.php">Profile</a></li>
      <li><a href="approval.php">Approval</a></li>
      <li><a href="workshop.php">Workshop</a></li>
      <li><a href="mechanic.php">Mechanic</a></li>
			<li><a href="driver.php">Driver</a></li>
			<li><a href="resolve.php">Issues</a></li>
			<li><a href="addadmin.php">Add Admin</a></li>
			<li><a href="approval.php?logout='1'" style="margin-left: 1070px;" >logout</a></li>
    </ul>
  </nav>

  <div id="side-menu" class="side-nav">
		<div class="profile_info_1">
			<img src="../images/admin_profile.png"  >

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
		<a href="home.php">Profile</a>
		<a href="approval.php">Approval</a>
		<a href="workshop.php">Workshop</a>
		<a href="mechanic.php">Mechanic</a>
		<a href="driver.php">Driver</a>
		<a href="resolve.php">Issues</a>
		<a href="addadmin.php">Add Admin</a>
		<a href="approval.php?logout='1'">logout</a>
  </div>

	<div id="main">
		<div class="row">
  <div class="column side">
				<img src="../images/admin_profile.png" class="centerr" ></br>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
				</br><i class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['firstname']); ?>)</i>
				</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['lastname']); ?>)</i>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['phonenumber']); ?>)</i>
  </div>
  <div class="column middle">
		<form>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

			<div id="map"></div>

			<!------ Include the above in your HEAD tag ---------->
			<script>
			    var map;
			    var marker;
			    var infowindow;
			    var red_icon =  'http://maps.google.com/mapfiles/ms/icons/red-dot.png' ;
			    var purple_icon =  'http://maps.google.com/mapfiles/ms/icons/purple-dot.png' ;
			    var locations = <?php get_all_workshop_locations() ?>;

			    function initMap() {
			        var paritraja = {lat: 1.8635, lng: 103.1089};
			        infowindow = new google.maps.InfoWindow();
			        map = new google.maps.Map(document.getElementById('map'), {
			            center: paritraja,
			            zoom: 15
			        });


			        var i ; var confirmed = 0;
			        for (i = 0; i < locations.length; i++) {

			            marker = new google.maps.Marker({
			                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
			                map: map,
			                icon :   locations[i][4] === '1' ?  red_icon  : purple_icon,
			                html: document.getElementById('form')
			            });

			            google.maps.event.addListener(marker, 'click', (function(marker, i) {
			                return function() {
			                    confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
			                    $("#confirmed").prop(confirmed,locations[i][4]);
			                    $("#id").val(locations[i][0]);
			                    $("#description").val(locations[i][3]);
													$("#workshopusername").val(locations[i][5]);
													$("#firstname").val(locations[i][6]);
													$("#lastname").val(locations[i][7]);
													$("#phonenumber").val(locations[i][8]);
													$("#workshopname").val(locations[i][9]);
													$("#wphonenumber").val(locations[i][10]);
			                    $("#form").show();
			                    infowindow.setContent(marker.html);
			                    infowindow.open(map, marker);
			                }
			            })(marker, i));
			        }
			    }

			    function saveData() {
			        var confirmed = document.getElementById('confirmed').checked ? 1 : 0;
			        var id = document.getElementById('id').value;
			        var url = '../function/functions.php?confirm_workshop_location&id=' + id + '&confirmed=' + confirmed ;
			        downloadUrl(url, function(data, responseCode) {
			            if (responseCode === 200  && data.length > 1) {
			                infowindow.close();
			                window.location.reload(true);
			            }else{
			                infowindow.setContent("<div style='color: purple; font-size: 25px;'>Inserting Errors</div>");
			            }
			        });
			    }

					function deletelocation() {
							var id = document.getElementById('id').value;
							var url = '../function/functions.php?delete_location&id=' + id;
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
								<td><a>username</a></td>
								<td><textarea disabled id='workshopusername' placeholder='Description'></textarea></td>
						</tr>
						<tr>
								<input name="id" type='hidden' id='id'/>
								<td><a>First Name</a></td>
								<td><textarea disabled id='firstname' placeholder='Description'></textarea></td>
						</tr>
						<tr>
								<input name="id" type='hidden' id='id'/>
								<td><a>Last Name</a></td>
								<td><textarea disabled id='lastname' placeholder='Description'></textarea></td>
						</tr>
						<tr>
								<input name="id" type='hidden' id='id'/>
								<td><a>Phone Number</a></td>
								<td><textarea disabled id='phonenumber' placeholder='Description'></textarea></td>
						</tr>
						<tr>
								<input name="id" type='hidden' id='id'/>
								<td><a>Workshop Name</a></td>
								<td><textarea disabled id='workshopname' placeholder='Description'></textarea></td>
						</tr>
						<tr>
								<input name="id" type='hidden' id='id'/>
								<td><a>Workshop Phone Number</a></td>
								<td><textarea disabled id='wphonenumber' placeholder='Description'></textarea></td>
						</tr>
			        <tr>
			            <input name="id" type='hidden' id='id'/>
			            <td><a>Address</a></td>
			            <td><textarea disabled id='description' placeholder='Description'></textarea></td>
			        </tr>
			        <tr>
			            <td><b>Confirm Location ?:</b></td>
			            <td><input id='confirmed' type='checkbox' name='confirmed'></td>
			        </tr>

			        <tr><td></td><td><input type='button' value='Save' class=btn onclick='saveData()'/></td></tr>
							<tr><td></td><td><input type='button' value='Delete' class=btn onclick='deletelocation()'/></td></tr>
			    </table>
			</div>
			<script async defer
			        src="https://maps.googleapis.com/maps/api/js?language=en&key=AIzaSyBkN8FOWtIP6kWKDjCtQrz7Ude96XNCZxA&callback=initMap">
			</script>
		</form>
	</div>
  <div class="column side">
		<img width="100%" height="100%" src="../images/adminguideline.png" alt="">
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
