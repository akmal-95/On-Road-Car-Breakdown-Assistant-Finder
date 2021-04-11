<?php include('function\functions.php') ?>

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

          <h2 class="subtitle">Pick your account type?</h2>
        </div>
        <div class="form">
                		<?php echo display_error(); ?>
          <form id="post" class="form page-form" method="post" action="register.php">
            <div class="form-container">
              <div class="form-body">
                <div class="field">
                  <div class="control">
                    <button id="login" type="submit" class="button" name="godriver">
                      DRIVER
                    </button>
                  </br>
                    <button id="login" type="submit" class="button" name="goworkshop">
                      WORKSHOP
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <div class="sub-actions">
            <p class="action">Already have account? <a class="link" href="login.php">Sign In</a></p>
            <p> <a class="link" href="index.html">Home</a></p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
