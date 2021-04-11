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
</head>
<body>
	<div class="header">
		<h2>Workshop - Profile Page</h2>
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
						<i  style="margin-left:70px; color: #888;">(<?php echo ucfirst($_SESSION['user']['phonenumber']); ?>)</i></p>
						<i  style="margin-left:70px; color: #888;">(<?php echo ucfirst($_SESSION['user']['workshopname']); ?>)</i></p>
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
		<a href="feedback.php">Report</a>
		<a href="addmechanic.php">Add Mechanic</a>
		<a href="whome.php?logout='1'">logout</a>
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
		<form method="post" action="whome.php" >
			<div class="input-group">
				<input hidden type="text" name="id" value="<?php echo $_SESSION['user']['id']; ?>" >
			</div>
			<div class="input-group">
				<label>Username</label>
				<input type="text" name="username" value="<?php echo $_SESSION['user']['username']; ?>" >
			</div>
			<div class="input-group">
				<label>Email</label>
				<input type="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
			</div>
			<div class="input-group">
				<label>Workshop Name</label>
				<input type="text" name="workshopname" value="<?php echo $_SESSION['user']['workshopname']; ?>">
			</div>
			<div class="input-group">
				<label>First Name</label>
				<input type="text" name="firstname" value="<?php echo $_SESSION['user']['firstname']; ?>">
			</div>
			<div class="input-group">
				<label>Last Name</label>
				<input type="text" name="lastname" value="<?php echo $_SESSION['user']['lastname']; ?>">
			</div>
			<div class="input-group">
				<label>Phone Number</label>
				<input type="text" name="phonenumber" value="<?php echo $_SESSION['user']['phonenumber']; ?>">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" name="password_1" value="<?php echo $_SESSION['user']['password']; ?>">
			</div>
			<div class="input-group">
				<label>Confirm password</label>
				<input type="password" name="password_2" value="<?php echo $_SESSION['user']['password']; ?>">
			</div>
			<div class="input-group">
				<label>Address</label>
				<input type="text" name="address" value="<?php echo $_SESSION['user']['address']; ?>">
			</div>
			<div class="input-group">
				<button style="margin-left:auto;margin-right:auto;display:block;margin-top:5%;margin-bottom:0%" type="submit" class="btn" name="wupdate_btn">UPDATE</button>
				<button style="margin-left:auto;margin-right:auto;display:block;margin-top:1%;margin-bottom:0%" type="submit" class="btn" name="delete_btn">DELETE</button>
			</div>
		</form>
			</div>
		<div class="column side">
			<img width="100%" height="100%" src="../images/covic19.png" alt="">
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
