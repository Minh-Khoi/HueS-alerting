<?php
session_start();
// check if the user has logged in before
if (empty($_SESSION['username'])) {
  header("location: http://{$_SERVER['HTTP_HOST']}/authentication/index.php");
}
