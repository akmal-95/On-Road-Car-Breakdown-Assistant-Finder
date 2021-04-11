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

		 textarea:disabled{
		 	background: white;
			border: 0px;
		 }
		</style>
</head>
<body>
	<div class="header">
		<h2>Admin - Issues Page</h2>
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
			<li><a href="resolve.php?logout='1'" style="margin-left: 1070px;" >logout</a></li>
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
		<a href="home.php">Profile</a></li>
		<a href="approval.php">Approval</a>
		<a href="workshop.php">Workshop</a>
		<a href="mechanic.php">Mechanic</a>
		<a href="driver.php">Driver</a>
		<a href="resolve.php">Issues</a>
		<a href="addadmin.php">Add Admin</a>
		<a href="resolve.php?logout='1'">logout</a>
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
		<form action="resolve.php" method="post">
			 <?php
			global $db, $errors, $username;


			if(isset($_POST['delete'])){
				$DeleteQuery = "DELETE FROM feedback  WHERE id='$_POST[id]' ";
				mysqli_query($db,$DeleteQuery);
			};

		 $query = "SELECT * FROM feedback ";
		 $result = mysqli_query($db, $query);

		 echo "<table  border='1' style='boder=10px solid black; margin-left:auto; margin-right:auto;'>";
		 echo "<tr>";
		 echo "<th></th>";
		 echo "<th style='border=1px solid black;Font-size=18;Font-Weight=bold'>USERNAME</th>";
		 echo "<th>ISSUES</th>";
		 echo "<th>DESCRIPTION</th>";
		 echo "<th>ACTION</th>";
		 echo "<tr>";
		while($data = mysqli_fetch_array($result))
		 {
			echo "<form action=resolve.php method=post>";
			echo "<tr>";
			echo "<td>" . "<input hidden type=hidden name=id value=" . $data['id'] . " </td>";
			echo "<td>" . "<input disabled type=text name=username value=" . $data['username'] . " </td>";
			echo "<td>" . "<textarea width:1000px; disabled id='lastname' placeholder='Description'>" . $data['feederback'] . "</textarea></td>";
			echo "<td>" . "<textarea disabled id='lastname' placeholder='Description'>" . $data['feederback'] . "</textarea></td>";
			echo "<td>" . "<input align='center' type=submit class=btn name=delete value=RESOLVE" . " </td>";
			echo "</tr>";
			echo "</form>";
		 }

		 echo "</table>";
			 ?>
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
