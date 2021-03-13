<?php
session_start();
require_once dirname(__FILE__) . "/client_IP.php";
require_once dirname(__FILE__) . "/model/user_dao.php";

$db = new mysqli('localhost', 'root', '', 'php-auth');

if (!$db) {
    die('Connection failed: ' . mysqli_connect_error());
}

// $errors = array();
// // check if cookie remember the previous log in user
// if (isset($_COOKIE["remembered_logged_member"])) {
//     $user_datas_in_array = json_decode($_COOKIE['remembered_logged_member'], true);
//     // die("<pre>" . print_r($user_datas_in_array, true) . "</pre>");
//     $username = $user_datas_in_array["user_name"];
//     setcookie('remembered_logged_member', json_encode($user_datas_in_array), time() + 60 * 60 * 24);
//     $_COOKIE['remembered_logged_member'] = json_encode($user_datas_in_array);
//     $_SESSION['username'] = $username;
//     $_SESSION['success'] = "You are logged in!";
//     header("location: http://{$_SERVER['HTTP_HOST']}/authentication/home.php");
// }

// Check if this file was call by login form
if (isset($_POST['login-submit'])) {
    $username = $db->real_escape_string($_POST['username']);
    $password = $db->real_escape_string($_POST['password']);
    $hashed_password = md5($password);

    $query = "SELECT * FROM users WHERE user_name='$username' AND hashed_password='$hashed_password'";
    $result = $db->query($query);
    if ($result->num_rows == 1) {
        // Log user in
        $user_datas_in_array = $result->fetch_assoc();
        // die("<pre>" . print_r($result->fetch_assoc(), true) . "</pre>");
        if ($_POST['remember'] == 1) {
            // at first, create token
            $client_device = new client_device();
            $client_ip = $client_device->client_ip;
            $token_before_enscrypted = $client_ip . $user_datas_in_array['id'];
            $token = md5($token_before_enscrypted);
            // then save it in database
            $user_dao = new user_dao();
            $user_dao->set_remember_login_token($token, $username);
        }
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are logged in!";
        header("location: http://{$_SERVER['HTTP_HOST']}/authentication/home.php");
    } else {
        // die($username . " " . $password);
        header("location: http://{$_SERVER['HTTP_HOST']}/authentication/index.php");
    }
}
