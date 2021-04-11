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
	<style>
	table {
	border-collapse: collapse;
	}

	table, td, th {
	border: 1px solid black;
	}

		input{
			border: 0px;
		}

		input:disabled {
  background: white;
   }
	</style>
</head>
<body>
	<div class="header">
		<h2>Workshop - List Mechanic Page</h2>
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
		<form method="post" action="mechanic.php">
			<?php
			global $db, $errors, $username;


			if(isset($_POST['update'])){
				$UpdateQuery = "UPDATE users set email = '$_POST[email]', firstname = '$_POST[firstname]', lastname = '$_POST[lastname]', phonenumber = '$_POST[phonenumber]' WHERE id = '$_POST[id]'  ";
				mysqli_query($db,$UpdateQuery);
			};

			if(isset($_POST['allow'])){
				$UpdateQuery = "UPDATE users set accountstatus='allow' WHERE id = '$_POST[id]'  ";
				mysqli_query($db,$UpdateQuery);
				};

				if(isset($_POST['block'])){
					$UpdateQuery = "UPDATE users set accountstatus='block' WHERE id = '$_POST[id]'  ";
					mysqli_query($db,$UpdateQuery);
					};


		$query = "SELECT * FROM users WHERE workplace = '".$_SESSION['user']['username']."' ";
		$result = mysqli_query($db, $query);

		echo "<table border='1' style='boder=1px solid black;'>";
		echo "<tr>";
		echo "<th></th>";
		echo "<th style='border=1px solid black;Font-size=18;Font-Weight=bold'>USERNAME</th>";
		echo "<th>EMAIL</th>";
		echo "<th>FIRST NAME</th>";
		echo "<th>LAST NAME</th>";
		echo "<th>PHONE</th>";
		echo "<th>ACCOUNT STATUS</th>";
		echo "<th>UPDATE</th>";
		echo "<th>ALLOW</th>";
		echo "<th>BLOCK</th>";
		echo "<tr>";
		while($data = mysqli_fetch_array($result))
		{
			echo "<form action=mechanic.php method=post>";
			echo "<tr>";
			echo "<td>" . "<input hidden type=hidden name=id value=" . $data['id'] . " </td>";
			echo "<td>" . "<input disabled type=text name=username value=" . $data['username'] . " </td>";
			echo "<td>" . "<input type=text name=email value=" . $data['email'] . " </td>";
			echo "<td>" . "<input type=text name=firstname value=" . $data['firstname'] . " </td>";
			echo "<td>" . "<input type=text name=lastname value=" . $data['lastname'] . " </td>";
			echo "<td>" . "<input type=text name=phonenumber value=" . $data['phonenumber'] . " </td>";
			echo "<td>" . "<input disabled type=text name=accountstatus value=" . $data['accountstatus'] . " </td>";
			echo "<td>" . "<input type=submit class=btn name=update value=update" . " </td>";
			echo "<td>" . "<input type=submit class=btn name=allow value=allow" . " </td>";
			echo "<td>" . "<input type=submit class=btn name=block value=blocked" . " </td>";
			echo "</tr>";
			echo "</form>";
		}

		echo "</table>";
			 ?>
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
