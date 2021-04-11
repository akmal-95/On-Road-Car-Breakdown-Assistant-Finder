<?php include('function/functions.php') ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Workshop - Registration Form</title>
    	<link rel="stylesheet" type="text/css" href="css/loginstyle.css">
  </head>
  <body>
    <div class="root">
      <div class="container">
        <div class="heading">
          <img class="logo" src="images/car.png" alt="On-Road Car Breakdown Assistant Finder" />

          <h2 class="subtitle">Workshop - Registration Form</h2>
        </div>
        <div class="form">
                		<?php echo display_error(); ?>
          <form id="login" class="form page-form" method="post" action="wregister.php">
            <div class="form-container">
              <div class="form-body">
                <div class="field">
                  <label class="label">Username</label>
                  <div class="control">
                    <input id="username" type="username" class="input" placeholder="Username" name="username" value="<?php echo $username; ?>"/>
                  </div>
                </div>
               <div class="field">
                <label class="label">Email</label>
                  <div class="control">
                    <input id="password" type="email" class="input" placeholder="example@gmail.com" name="email" value="<?php echo $email; ?>"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Workshop Name</label>
                  <div class="control">
                    <input id="username" type="text" class="input" placeholder="workshop name" name="workshopname"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">First Name</label>
                  <div class="control">
                    <input id="username" type="text" class="input" placeholder="First Name" name="firstname"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Last Name</label>
                  <div class="control">
                    <input id="username" type="text" class="input" placeholder="Last Name" name="lastname"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Phone Number</label>
                  <div class="control">
                    <input id="username" type="text" class="input" placeholder="012-123456" name="phonenumber"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Password</label>
                  <div class="control">
                    <input id="username" type="password" class="input" placeholder="Password" name="password_1"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Confirm password</label>
                  <div class="control">
                    <input id="username" type="password" class="input" placeholder="Password" name="password_2"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Address</label>
                  <div class="control">
                    <input id="username" type="text" class="input" placeholder="Address" name="address"/>
                  </div>
                </div>
                <div class="field">
                  <div id="error-message" class="notification is-danger"></div>
                </div>
                <div class="field">
                  <div class="control">
                    <button  type="submit" class="button" name="wregister_btn">
                      Register
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="sub-actions">
            <p> <a class="link" href="index.html">Home</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
