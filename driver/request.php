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
</head>
<body>
	<div class="header">
		<h2>Driver - Request Page</h2>
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
		<div class="row">
	<div class="column side">
				<img src="../images/driver_profile.png" class="centerr" ></br>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
				</br><i class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['firstname']); ?>)</i>
				</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['lastname']); ?>)</i>
			</br><i  class="centerr" style="color: #888;">(<?php echo ucfirst($_SESSION['user']['phonenumber']); ?>)</i>
	</div>
	<div class="column middle">
		<form id="post" class="form page-form" method="post" action="request.php">
				<button style="margin-left:auto;margin-right:auto;display:block;margin-top:5%;margin-bottom:0%" type="submit" class="btn" name="map">MAP</button>
				<button style="margin-left:auto;margin-right:auto;display:block;margin-top:5%;margin-bottom:0%" type="submit" class="btn" name="towingrequest">TOWING</button>
				<button style="margin-left:auto;margin-right:auto;display:block;margin-top:5%;margin-bottom:0%" type="submit" class="btn" name="mechanicrequest">MECHANIC</button>
				<button style="margin-left:auto;margin-right:auto;display:block;margin-top:5%;margin-bottom:0%" type="submit" class="btn" name="batteryrequest">BATTERY</button>
				<button style="margin-left:auto;margin-right:auto;display:block;margin-top:5%;margin-bottom:0%" type="submit" class="btn" name="tyresrequestgrequest">TYRES</button>
		</form>
	</div>
	<div class="column side">
		<img width="100%" height="100%" src="../images/Maintenance.jpg"  >
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
