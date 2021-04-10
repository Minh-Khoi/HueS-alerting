<?php
session_start();
header('Access-Control-Allow-Origin: http://localhost:2000');
error_reporting(E_ERROR);
require_once dirname(__FILE__) . "/client_IP.php";
require_once dirname(__FILE__) . "/model/user_dao.php";

$db = new mysqli('localhost', 'root', '', 'php-auth');

if (!$db) {
    die('Connection failed: ' . mysqli_connect_error());
}

// First, check the database if the device has been "remembered" to be logged in
if (isset($_POST["token_remembered"])) {
    $token_remembered = $db->real_escape_string($_POST['token_remembered']);
    $query = "SELECT * FROM users WHERE login_remembering_token = '$token_remembered'";
    $data_response_object = [];
    $result_set = $db->query($query);
    $row_of_user = $result_set->fetch_assoc();
    if ($result_set->num_rows > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are logged in!";
        $data_response_object['announce'] = "found remembered logging in user";
        echo json_encode($data_response_object);
        die();
    }
}

// THEN Check if this file was call by login form
if (isset($_POST['login_submit'])) {
    $username = $db->real_escape_string($_POST['username']);
    $password = $db->real_escape_string($_POST['password']);
    $hashed_password = md5($password);

    $query = "SELECT * FROM users WHERE user_name='$username' AND hashed_password='$hashed_password'";
    $result = $db->query($query);
    if ($result->num_rows == 1) {
        // Log user in
        $user_datas_in_array = $result->fetch_assoc();
        // die("<pre>" . print_r($result->fetch_assoc(), true) . "</pre>");
        $data_response_object = [];
        if (!is_null($_POST['remember'])) {
            $user_dao = new user_dao();
            // at first, create token
            $time_remember =  time();
            $token = md5($time_remember . $hashed_password . $username);
            // then save it in database
            $user_dao->set_remember_login_token($token, $username);
            $data_response_object['token'] = $token;
        }
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are logged in!";
        $data_response_object['announce'] = "You are logged in!";
        echo json_encode($data_response_object);
        die();
        // header("location: http://{$_SERVER['HTTP_HOST']}/authentication/home.php");
    } else {
        $data_response_object['announce'] = "login failed";
        die(json_encode($data_response_object));
        // header("location: http://{$_SERVER['HTTP_HOST']}/authentication/index.php");
    }
}