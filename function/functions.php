<?php
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'multi_login');

// variable declaration
$username = "";
$email    = "";
$errors   = array();

if (isset($_POST['goworkshop'])) {
	header('location: wregister.php');
}

if (isset($_POST['godriver'])) {
	header('location: dregister.php');
}

// call the register() function if register_btn is clicked

if (isset($_POST['register_btn'])) {
	register();
}

if (isset($_POST['mregister_btn'])) {
	mregister();
}

if (isset($_POST['dregister_btn'])) {
	dregister();
}

if (isset($_POST['wregister_btn'])) {
	wregister();
}

if (isset($_POST['feedback_btn'])) {
	feedback();
}
if (isset($_POST['aupdate_btn'])) {
	aupdate_btn();
}

if (isset($_POST['wupdate_btn'])) {
	wupdate();
}

if (isset($_POST['mupdate_btn'])) {
	mupdate();
}
if (isset($_POST['dupdate_btn'])) {
	dupdate();
}
//delete users
if (isset($_POST['delete_btn'])) {
	deleteusers();
}

function deleteusers(){
	global $db;
	$id     =  e($_POST['id']);
	$user_type = e($_POST['admin']);
	$query = "UPDATE users set accountstatus='block' WHERE id = $id";
	mysqli_query($db, $query);
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");

}


// REGISTER USER
function wregister(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username     =  e($_POST['username']);
	$email        =  e($_POST['email']);
	$workshopname =  e($_POST['workshopname']);
	$firstname    =  e($_POST['firstname']);
	$lastname     =  e($_POST['lastname']);
	$phonenumber  =  e($_POST['phonenumber']);
	$password_1   =  e($_POST['password_1']);
	$password_2   =  e($_POST['password_2']);
	$address      =  e($_POST['address']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
	//	$password = md5($password_1);//encrypt the password before saving in the database
		$password = $password_1;

		if (isset($_POST['workshop'])) {
			$user_type = e($_POST['workshop']);
			$query = "INSERT INTO users (username, email, workshopname, firstname, lastname, user_type, phonenumber, password, address, accountstatus)
					  VALUES('$username', '$email','$workshopname','$firstname','$lastname','workshop',$phonenumber, '$password', '$address', 'allow')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: workshop/whome.php');
		}else{
			$query = "INSERT INTO users (username, email, workshopname, firstname, lastname, user_type, phonenumber, password, address, accountstatus)
					  VALUES('$username', '$email','$workshopname','$firstname','$lastname','workshop',$phonenumber, '$password', '$address', 'allow')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: workshop/whome.php');
		}
	}
}

function mregister(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
		// defined below to escape form values
		$username    =  e($_POST['username']);
		$email       =  e($_POST['email']);
		$firstname   =  e($_POST['firstname']);
		$lastname    =  e($_POST['lastname']);
		$phonenumber =  e($_POST['phonenumber']);
		$password_1  =  e($_POST['password_1']);
		$password_2  =  e($_POST['password_2']);
		$workplace   =  e($_POST['workplace']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0)
//		$password = md5($password_1);//encrypt the password before saving in the database
		$password = $password_1;

			$query = "INSERT INTO users (username, email, firstname, lastname, user_type, phonenumber, password, workplace, accountstatus)
					  VALUES('$username', '$email', '$firstname', '$lastname', 'mechanic', $phonenumber, '$password', '$workplace', 'allow')";
					mysqli_query($db, $query);
					$_SESSION['success']  = "New user successfully created!!";
		}



function dregister(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$firstname   =  e($_POST['firstname']);
	$lastname    =  e($_POST['lastname']);
	$phonenumber =  e($_POST['phonenumber']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
	//	$password = md5($password_1);//encrypt the password before saving in the database
			$password = $password_1;

		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email,firstname,lastname, user_type, phonenumber, password, accountstatus)
					  VALUES('$username', '$email','$firstname','$lastname','driver',$phonenumber, '$password', 'allow')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: driver/dhome.php');
		}else{
			$query = "INSERT INTO users (username, email,firstname,lastname, user_type, phonenumber, password, accountstatus)
					  VALUES('$username', '$email','$firstname','$lastname','driver',$phonenumber, '$password', 'allow')";
						$_SESSION['success']  = "New user failed created!!";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: driver/dhome.php');
		}
	}
}

function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$username    =  e($_POST['username']);
	$email       =  e($_POST['email']);
	$firstname   =  e($_POST['firstname']);
	$lastname    =  e($_POST['lastname']);
	$phonenumber =  e($_POST['phonenumber']);
	$password_1  =  e($_POST['password_1']);
	$password_2  =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
//		$password = md5($password_1);//encrypt the password before saving in the database
			$password = $password_1;
		if (isset($_POST['user_type'])) {
			$user_type = e($_POST['user_type']);
			$query = "INSERT INTO users (username, email, firstname, lastname, phonenumber, user_type, password, accountstatus)
					  VALUES('$username', '$email', '$firstname', '$lastname', '$phonenumber', 'admin','$password', 'allow')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO users (username, email, firstname, lastname, phonenumber, user_type, password, accountstatus)
					  VALUES('$username', '$email', '$firstname', '$lastname', '$phonenumber','admin', '$password', 'allow')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: home.php');
		}
	}
}

// return user array from their id
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);

	$user = mysqli_fetch_assoc($result);
	return $user;
}

// escape string
function e($val){
	global $db;
	return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="error">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
	}
}

function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}

if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
	login();
}

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = e($_POST['username']);
	$password = e($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {
	//	$password = md5($password);
		$password;
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password' AND accountstatus='allow' LIMIT 1";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = mysqli_fetch_assoc($results);
			if ($logged_in_user['user_type'] == 'admin') {
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: admin/home.php');
			}elseif ($logged_in_user['user_type'] == 'driver') {
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: driver/dhome.php');
			}elseif($logged_in_user['user_type'] == 'workshop') {
				$_SESSION['user'] = $logged_in_user;
				$_SESSION['success']  = "You are now logged in";
				header('location: workshop/whome.php');
			}elseif($logged_in_user['user_type'] == 'mechanic') {
			$_SESSION['user'] = $logged_in_user;
			$_SESSION['success']  = "You are now logged in";
			header('location: mechanic/mhome.php');
			}
		}else {
			array_push($errors, "Wrong username/password combination");
		}
	}
}

function aupdate_btn(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$id     =  e($_POST['id']);
	$username     =  e($_POST['username']);
	$email        =  e($_POST['email']);
	$firstname    =  e($_POST['firstname']);
	$lastname     =  e($_POST['lastname']);
	$phonenumber  =  e($_POST['phonenumber']);
	$password_1   =  e($_POST['password_1']);
	$password_2   =  e($_POST['password_2']);

	// form validation: ensure that the form is correctly filled
	if (empty($username )) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
//		$password = md5($password_1);//encrypt the password before saving in the database
			$password = $password_1;
			if (isset($_POST['admin'])) {
				$user_type = e($_POST['admin']);
				$query = "update users set email='$email', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password' WHERE id='$id'";
				mysqli_query($db, $query);
				$_SESSION['success']  = "Updated successfully!!";
			}else{
				$query = "update users set email='$email', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password' WHERE id	='$id'";
				mysqli_query($db, $query);

				// get id of the created user
				$logged_in_user_id = $id;

				$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
				$_SESSION['success']  = "Updated Successfully";
			}

}

function wupdate(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;
//	$password = $password_1;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
	$id     =  e($_POST['id']);
	$username     =  e($_POST['username']);
	$email        =  e($_POST['email']);
	$workshopname =  e($_POST['workshopname']);
	$firstname    =  e($_POST['firstname']);
	$lastname     =  e($_POST['lastname']);
	$phonenumber  =  e($_POST['phonenumber']);
	$password_1   =  e($_POST['password_1']);
	$password_2   =  e($_POST['password_2']);
	$address      =  e($_POST['address']);

	// form validation: ensure that the form is correctly filled
	if (empty($username )) {
		array_push($errors, "Username is required");
	}
	if (empty($email)) {
		array_push($errors, "Email is required");
	}
	if (empty($password_1)) {
		array_push($errors, "Password is required");
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	//		$password = md5($password_1);//encrypt the password before saving in the database
	$password = $password_1;
	if (isset($_POST['workshop'])) {
		$user_type = e($_POST['workshop']);
		$query = "update users set email='$email', workshopname='$workshopname', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password', address='$address' WHERE id='$id'";
		mysqli_query($db, $query);
		$_SESSION['success']  = "Updated successfully!!";
	}else{
		$query = "update users set email='$email', workshopname='$workshopname', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password', address='$address' WHERE id	='$id'";
		mysqli_query($db, $query);

		// get id of the created user
		$logged_in_user_id = $id;

		$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
		$_SESSION['success']  = "Updated Successfully";
	}
}

function mupdate(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
		$id     =  e($_POST['id']);
		$username     =  e($_POST['username']);
		$email        =  e($_POST['email']);
		$firstname    =  e($_POST['firstname']);
		$lastname     =  e($_POST['lastname']);
		$phonenumber  =  e($_POST['phonenumber']);
		$password_1   =  e($_POST['password_1']);
		$password_2   =  e($_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username )) {
			array_push($errors, "Username is required");
		}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
	//		$password = md5($password_1);//encrypt the password before saving in the database
				$password = $password_1;
				if (isset($_POST['mechanic'])) {
					$user_type = e($_POST['mechanic']);
					$query = "update users set email='$email', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password' WHERE id='$id'";
					mysqli_query($db, $query);
					$_SESSION['success']  = "Updated successfully!!";
				}else{
					$query = "update users set email='$email', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password' WHERE id	='$id'";
					mysqli_query($db, $query);

					// get id of the created user
					$logged_in_user_id = $id;

					$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
					$_SESSION['success']  = "Updated Successfully";
				}

}

function dupdate(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. Call the e() function
    // defined below to escape form values
		$id     =  e($_POST['id']);
		$username     =  e($_POST['username']);
		$email        =  e($_POST['email']);
		$firstname    =  e($_POST['firstname']);
		$lastname     =  e($_POST['lastname']);
		$phonenumber  =  e($_POST['phonenumber']);
		$password_1   =  e($_POST['password_1']);
		$password_2   =  e($_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username )) {
			array_push($errors, "Username is required");
		}
		if (empty($email)) {
			array_push($errors, "Email is required");
		}
		if (empty($password_1)) {
			array_push($errors, "Password is required");
		}
		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
	//		$password = md5($password_1);//encrypt the password before saving in the database
				$password = $password_1;
				if (isset($_POST['driver'])) {
					$user_type = e($_POST['driver']);
					$query = "update users set email='$email', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password' WHERE id='$id'";
					mysqli_query($db, $query);
					$_SESSION['success']  = "Updated successfully!!";
				}else{
					$query = "update users set email='$email', firstname='$firstname', lastname='$lastname', phonenumber='$phonenumber', password='$password' WHERE id	='$id'";
					mysqli_query($db, $query);

					// get id of the created user
					$logged_in_user_id = $id;

					$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
					$_SESSION['success']  = "Updated Successfully";
				}

}

function feedback(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username;

	$username    =  e($_POST['username']);
	$shopname    =  e($_POST['shopname']);
	$feederback  =  e($_POST['feederback']);



	// form validation: ensure that the form is correctly filled

		if (isset($_POST['username'])) {
			$username = e($_POST['username']);
			$query = "INSERT INTO feedback (username,shopname,feederback)
					  VALUES('$username','$shopname','$feederback')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "Thanks for the report!!";
		}else{
			$query = "INSERT INTO feedback (username,shopname,feederback)
					  VALUES('$username','$shopname','$feederback')";
			mysqli_query($db, $query);

		}

	}

function isAdmin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
		return true;
	}else{
		return false;
	}
}

function isDriver()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'driver' ) {
		return true;
	}else{
		return false;
	}
}

function isWorkshop()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'workshop' ) {
		return true;
	}else{
		return false;
	}
}

function isMechanic()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'mechanic' ) {
		return true;
	}else{
		return false;
	}
}

if (isset($_POST['map'])) {
	header('location: maps.php');
}

if (isset($_POST['towingrequest'])) {
	header('location: towing-maps.php');
}

if (isset($_POST['mechanicrequest'])) {
	header('location: mechanic-maps.php');
}

if (isset($_POST['batteryrequest'])) {
	header('location: battery-maps.php');
}

if (isset($_POST['tyresrequestgrequest'])) {
	header('location: tyres-maps.php');
}


//googlemaps
// Gets data from URL parameters.
if(isset($_GET['add_workshop_location'])) {
    add_workshop_location();
}
if(isset($_GET['confirm_workshop_location'])) {
    confirm_workshop_location();
}


function add_workshop_location(){
	global $db;
    //$db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
		$workshopusername =$_GET['workshopusername'];
		$firstname =$_GET['firstname'];
		$lastname =$_GET['lastname'];
		$phonenumber =$_GET['phonenumber'];
		$workshopname =$_GET['workshopname'];
    $description =$_GET['description'];
		$wphonenumber =$_GET['wphonenumber'];
    $towing =$_GET['towing'];
    $tyres =$_GET['tyres'];
    $battery =$_GET['battery'];
    $mechanic =$_GET['mechanic'];
    // Inserts new row with place data.
    $query = sprintf("INSERT INTO locations " .
        " (id, lat, lng, description, towing, tyres, battery, mechanic, workshopusername, firstname, lastname, phonenumber, workshopname, wphonenumber) " .
        " VALUES (NULL, '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%s','%s','%s','%s','%s', '%s');",
        mysqli_real_escape_string($db,$lat),
        mysqli_real_escape_string($db,$lng),
        mysqli_real_escape_string($db,$description),
        mysqli_real_escape_string($db,$towing),
        mysqli_real_escape_string($db,$tyres),
        mysqli_real_escape_string($db,$battery),
        mysqli_real_escape_string($db,$mechanic),
				mysqli_real_escape_string($db,$workshopusername),
				mysqli_real_escape_string($db,$firstname),
				mysqli_real_escape_string($db,$lastname),
				mysqli_real_escape_string($db,$phonenumber),
				mysqli_real_escape_string($db,$workshopname),
				mysqli_real_escape_string($db,$wphonenumber)
      );

    $result = mysqli_query($db,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}
function confirm_workshop_location(){
		global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id =$_GET['id'];
    $confirmed =$_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "update locations set location_status = $confirmed WHERE id = $id ";
    $result = mysqli_query($db,$query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}
function get_confirmed_workshop_locations(){
	global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }

    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,workshopname, wphonenumber as isconfirmed
from locations WHERE  location_status = 1 AND workshopusername = '".$_SESSION['user']['username']."'
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function get_all_workshop_locations(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,workshopusername,firstname,lastname,phonenumber,workshopname,wphonenumber,towing,tyres,battery,mechanic as isconfirmed
from locations
  ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
  $indexed = array_map('array_values', $rows);
    $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}


//MECHANIC AND driver

//DRIVER
// driver all mapfiles
function get_confirmed_requested(){
	global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,workshopname,wphonenumber as isconfirmed
from locations WHERE  location_status = 1
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

//add location all mapfiles
if(isset($_GET['add_location'])) {
    add_location();
}

function add_location(){
	global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $description =$_GET['description'];
    // Inserts new row with place data.
    $query = sprintf("INSERT INTO requested " .
        " (id, lat, lng, description) " .
        " VALUES (NULL, '%s', '%s', '%s');",
        mysqli_real_escape_string($db,$lat),
        mysqli_real_escape_string($db,$lng),
        mysqli_real_escape_string($db,$description)
      );

    $result = mysqli_query($db,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

//driver towing requested

function get_confirmed_towing_requested(){
	global $db;
//	$db=mysqli_connect ("localhost", 'root', '','multi_login');
	if (!$db) {
			die('Not connected : ' . mysqli_connect_error());
	}
	// update location with location_status if admin location_status.
	$sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,towing,workshopusername,workshopname,wphonenumber as isconfirmed
from locations WHERE  location_status = 1 AND towing = 1
");

	$rows = array();

	while($r = mysqli_fetch_assoc($sqldata)) {
			$rows[] = $r;

	}

	$indexed = array_map('array_values', $rows);
	//  $array = array_filter($indexed);

	echo json_encode($indexed);
	if (!$rows) {
			return null;
	}
}

//add towing locations

if(isset($_GET['add_towing_location'])) {
    add_towing_location();
}

function add_towing_location(){
	global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
		$lat = $_GET['lat'];
		$lng = $_GET['lng'];
		$description =$_GET['description'];
		$service_type =$_GET['service_type'];
		$username =$_GET['username'];
		$firstname =$_GET['firstname'];
		$lastname =$_GET['lastname'];
		$phonenumber =$_GET['phonenumber'];
		// Inserts new row with place data.
		$query = sprintf("INSERT INTO requested " .
				" (id, lat, lng, description, servicetype, username, firstname, lastname, phonenumber) " .
				" VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
				mysqli_real_escape_string($db,$lat),
				mysqli_real_escape_string($db,$lng),
				mysqli_real_escape_string($db,$description),
				mysqli_real_escape_string($db,$service_type),
				mysqli_real_escape_string($db,$username),
				mysqli_real_escape_string($db,$firstname),
				mysqli_real_escape_string($db,$lastname),
				mysqli_real_escape_string($db,$phonenumber)
      );

    $result = mysqli_query($db,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

if(isset($_GET['add_request'])) {
    add_request();
}

function add_request(){
	global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $workshopusername =$_GET['workshopusername'];
    // update location with confirm if admin confirm.
    $query = "update requested set workshopusername = '$workshopusername' WHERE username = '".$_SESSION['user']['username']."' ";
    $result = mysqli_query($db,$query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

//driver tyres

function get_confirmed_tyres_requested(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,tyres,workshopusername,workshopname,wphonenumber
from locations WHERE  location_status = 1 AND tyres = 1
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

//driver tyres add locations

if(isset($_GET['add_tyres_location'])) {
    add_tyres_location();
}

function add_tyres_location(){
	global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
		$lat = $_GET['lat'];
		$lng = $_GET['lng'];
		$description =$_GET['description'];
		$service_type =$_GET['service_type'];
		$username =$_GET['username'];
		$firstname =$_GET['firstname'];
		$lastname =$_GET['lastname'];
		$phonenumber =$_GET['phonenumber'];
		// Inserts new row with place data.
		$query = sprintf("INSERT INTO requested " .
				" (id, lat, lng, description, servicetype, username, firstname, lastname, phonenumber) " .
				" VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
				mysqli_real_escape_string($db,$lat),
				mysqli_real_escape_string($db,$lng),
				mysqli_real_escape_string($db,$description),
				mysqli_real_escape_string($db,$service_type),
				mysqli_real_escape_string($db,$username),
				mysqli_real_escape_string($db,$firstname),
				mysqli_real_escape_string($db,$lastname),
				mysqli_real_escape_string($db,$phonenumber)
			);

    $result = mysqli_query($db,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

//driver battery

function get_confirmed_battery_requested(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,battery,workshopusername,workshopname,wphonenumber
from locations WHERE  location_status = 1 AND battery = 1
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

//add battery location

if(isset($_GET['add_battery_location'])) {
    add_battery_location();
}

function add_battery_location(){
	global $db;
//	$db=mysqli_connect ("localhost", 'root', '','multi_login');
	if (!$db) {
			die('Not connected : ' . mysqli_connect_error());
	}
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	$description =$_GET['description'];
	$service_type =$_GET['service_type'];
	$username =$_GET['username'];
	$firstname =$_GET['firstname'];
	$lastname =$_GET['lastname'];
	$phonenumber =$_GET['phonenumber'];
	// Inserts new row with place data.
	$query = sprintf("INSERT INTO requested " .
			" (id, lat, lng, description, servicetype, username, firstname, lastname, phonenumber) " .
			" VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
			mysqli_real_escape_string($db,$lat),
			mysqli_real_escape_string($db,$lng),
			mysqli_real_escape_string($db,$description),
			mysqli_real_escape_string($db,$service_type),
			mysqli_real_escape_string($db,$username),
			mysqli_real_escape_string($db,$firstname),
			mysqli_real_escape_string($db,$lastname),
			mysqli_real_escape_string($db,$phonenumber)
		);

	$result = mysqli_query($db,$query);
	echo"Inserted Successfully";
	if (!$result) {
			die('Invalid query: ' . mysqli_error($db));
	}
}

//drver mechanic

function get_confirmed_mechanic_requested(){
	global $db;
  //  $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,mechanic,workshopusername,workshopname,wphonenumber
from locations WHERE  location_status = 1 AND mechanic = 1
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

//add driver location mechanic
if(isset($_GET['add_mechanic_location'])) {
    add_mechanic_location();
}

function add_mechanic_location(){
global $db;
//	$db=mysqli_connect ("localhost", 'root', '','multi_login');
	if (!$db) {
			die('Not connected : ' . mysqli_connect_error());
	}
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];
	$description =$_GET['description'];
	$service_type =$_GET['service_type'];
	$username =$_GET['username'];
	$firstname =$_GET['firstname'];
	$lastname =$_GET['lastname'];
	$phonenumber =$_GET['phonenumber'];
	// Inserts new row with place data.
	$query = sprintf("INSERT INTO requested " .
			" (id, lat, lng, description, servicetype, username, firstname, lastname, phonenumber) " .
			" VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
			mysqli_real_escape_string($db,$lat),
			mysqli_real_escape_string($db,$lng),
			mysqli_real_escape_string($db,$description),
			mysqli_real_escape_string($db,$service_type),
			mysqli_real_escape_string($db,$username),
			mysqli_real_escape_string($db,$firstname),
			mysqli_real_escape_string($db,$lastname),
			mysqli_real_escape_string($db,$phonenumber)
		);

	$result = mysqli_query($db,$query);
	echo"Inserted Successfully";
	if (!$result) {
			die('Invalid query: ' . mysqli_error($db));
	}
}

//mechanic_users
function get_all_requested(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,workshopusername,firstname,lastname,phonenumber as isconfirmed
from requested WHERE workshopusername = '".$_SESSION['user']['workplace']."'
  ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
  $indexed = array_map('array_values', $rows);
    $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

function get_user_location(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,workshopusername
from requested WHERE username ='".$_SESSION['user']['username']."'
  ");

    $rows = array();

    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }

    $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}


function get_specific_workshop(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($db,"
select id ,lat,lng,description,location_status,workshopusername as isconfirmed
from locations WHERE location_status = '1' AND workshopusername = '".$_SESSION['user']['workplace']."'
  ");

    $rows = array();
    while($r = mysqli_fetch_assoc($sqldata)) {
        $rows[] = $r;

    }
  $indexed = array_map('array_values', $rows);
    $array = array_filter($indexed);

    echo json_encode($indexed);
    if (!$rows) {
        return null;
    }
}

if(isset($_GET['confirm_location'])) {
    confirm_location();
}

function confirm_location(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id =$_GET['id'];
    $confirmed =$_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "update requested set location_status = $confirmed WHERE id = $id ";
    $result = mysqli_query($db,$query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

if(isset($_GET['finish_location'])) {
    finish_location();
}

function finish_location(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id =$_GET['id'];
    $query = "delete from requested WHERE id = $id ";
    $result = mysqli_query($db,$query);
    echo "Finished Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}

if(isset($_GET['delete_location'])) {
    delete_location();
}

function delete_location(){
	global $db;
//    $db=mysqli_connect ("localhost", 'root', '','multi_login');
    if (!$db) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id =$_GET['id'];
    $query = "delete from locations WHERE id = $id ";
    $result = mysqli_query($db,$query);
    echo "Finished Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($db));
    }
}


if(isset($_GET['request_services'])) {
    request_services();
}

function array_flatten($array) {
    if (!is_array($array)) {
        return FALSE;
    }
    $result = array();
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $result = array_merge($result, array_flatten($value));
        }
        else {
            $result[$key] = $value;
        }
    }
    return $result;
}

//star getRatingByProductId

?>
