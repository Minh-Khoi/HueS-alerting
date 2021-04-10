<?php
session_start();

// echo "<pre>" . print_r($_SERVER, true) . "</pre>";
// die();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Simple PHP Auth</title>
  <!-- css -->
  <link href="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/css/bootstrap.min.css" rel="stylesheet">
  <link href="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/css/style.css" rel="stylesheet" />
  <link href="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/css/parsley.css" rel="stylesheet" />
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <!-- js -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/js/main.js"></script>
  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/js/parsley.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-login">
          <div class="panel-heading">
            <div class="row">
              <div class="col-xs-6">
                <a href="#" id="register-form-link">Register</a>
              </div>
            </div>
            <hr>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-lg-12">

                <form id="register-form" action="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/register.php"
                  method="POST" role="form" data-parsley-validate>
                  <div class="form-group">
                    <input type="text" name="username" id="username" tabindex="1" class="form-control"
                      placeholder="Username" value="" data-parsley-trigger="change" required>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" id="email" tabindex="1" class="form-control"
                      placeholder="Email Address" value="" data-parsley-trigger="change" required>
                  </div>
                  <div class="form-group">
                    <input type="password" name="password" id="password" tabindex="2" class="form-control"
                      placeholder="Password" data-parsley-trigger="change" required data-parsley-minlength="6">
                  </div>
                  <div class="form-group">
                    <input type="password" name="confirm_password" id="confirm-password" tabindex="2"
                      class="form-control" placeholder="Confirm Password" data-parsley-trigger="change" required
                      data-parsley-minlength="6">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6 col-sm-offset-3">
                        <input type="submit" name="register" id="register-submit" tabindex="4"
                          class="form-control btn btn-register" value="Register">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/js/bootstrap.min.js"></script>
</body>

</html>