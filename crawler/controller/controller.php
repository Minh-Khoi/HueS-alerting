<?php
session_start();
header('Access-Control-Allow-Origin: http://localhost:2000');
// error_reporting(E_ERROR);

require_once dirname(__FILE__, 2) . "/action/action.php";

if (!isset($_POST['token_remembered'])) {
  echo "Post Form with empty TOKEN";
  die();
}

$task = $_POST['task'];
$token_remembered = $_POST['token_remembered'];
if ($task == 'add_keywords') {
  $keyswords_string = $_POST['keywords_string'];
  $action = new action();
  $action->add_new_keywords($keyswords_string, $token_remembered);
} else if ($task == 'change_password') {
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];
  $new_password_retyped = $_POST['new_password_retyped'];
  $action = new action();
  $action->change_password($old_password, $new_password, $new_password_retyped);
}
