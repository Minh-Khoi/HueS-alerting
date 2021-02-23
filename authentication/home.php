<?php
session_start();
if (empty($_SESSION['username'])) {
  header("location: http://{$_SERVER['HTTP_HOST']}/authentication/index.php");
}
// die("<pre>" . print_r($_SERVER, true) . "</pre>")
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
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
    <?
    // die("<pre>" . print_r($_COOKIE, true) . "</pre>")
    ?>
    <div class="col-md-12 jumbotron">
      <?php if (isset($_SESSION['success'])) : ?>
      <p><?php
              echo $_SESSION['success'];
              // unset($_SESSION['success']);
              ?>
      </p>
      <?php endif ?>
      <?php if (isset($_SESSION['username'])) : ?>
      <h1>Hello, <?php echo $_SESSION['username']; ?>!</h1>
      <p>
        <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/authentication/logout.php" class="btn btn-primary btn-lg"
          role="button">Logout</a>
      </p>
      <?php endif ?>
    </div>
  </div>
</body>

</html>