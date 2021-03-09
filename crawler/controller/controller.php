<?php
session_start();
require_once dirname(__FILE__, 2) . "/action/action.php";

if ($_POST['task'] == 'add_keywords') {
  $action = new action();
  $action->add_keywords($_POST['keyswords']);
} else if ($_POST['task'] == 'change_password') {
  $old_password = $_POST['old_password'];
  $new_password = $_POST['new_password'];
  $new_password_retyped = $_POST['new_password_retyped'];
  $action = new action();
  $action->pre_change_password($old_password, $new_password, $new_password_retyped);
}