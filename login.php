<?php include('function/functions.php') ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    	<link rel="stylesheet" type="text/css" href="css/loginstyle.css">
  </head>
  <body>
    <div class="root">
      <div class="container">
        <div class="heading">
          <img class="logo" src="images/car.png" alt="On-Road Car Breakdown Assistant Finder" />

          <h2 class="subtitle">Login to your account.</h2>
        </div>
        <div class="form">
                		<?php echo display_error(); ?>
          <form id="login" class="form page-form" method="post" action="login.php">
            <div class="form-container">
              <div class="form-body">
                <div class="field">
                  <label class="label">Username</label>
                  <div class="control">
                    <input id="username" type="username" class="input" placeholder="Username" name="username"/>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Password</label>
                  <div class="control">
                    <input id="password" type="password" class="input" placeholder="Password" name="password"/>
                  </div>
                </div>
                <div class="field">
                  <div id="error-message" class="notification is-danger"></div>
                </div>
                <div class="field">
                  <div class="control">
                    <button id="login" type="submit" class="button" name="login_btn">
                      Login
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="sub-actions">
            <p class="action">Don't have a  account? <a class="link" href="register.php">Sign up</a>.</p>
            <p> <a class="link" href="index.html">Home</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
