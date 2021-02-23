<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'php-auth');

if (!$db) {
    die('Connection failed: ' . mysqli_connect_error());
}

$errors = array();
// check if cookie remember the previous log in user
if (isset($_COOKIE["remembered_logged_member"])) {
    $user_datas_in_array = json_decode($_COOKIE['remembered_logged_member'], true);
    // die("<pre>" . print_r($user_datas_in_array, true) . "</pre>");
    $username = $user_datas_in_array["user_name"];
    setcookie('remembered_logged_member', json_encode($user_datas_in_array), time() + 60 * 60 * 24);
    $_COOKIE['remembered_logged_member'] = json_encode($user_datas_in_array);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are logged in!";
    header("location: http://{$_SERVER['HTTP_HOST']}/authentication/home.php");
}

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
            setcookie('remembered_logged_member', json_encode($user_datas_in_array), time() +  60 * 60 * 24);
            $_COOKIE['remembered_logged_member'] = json_encode($user_datas_in_array);
            // die("<pre>" . print_r($_COOKIE['remembered_logged_member'], true) . "</pre>");
        }
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are logged in!";
        header("location: http://{$_SERVER['HTTP_HOST']}/authentication/home.php");
    } else {
        // die($username . " " . $password);
        header("location: http://{$_SERVER['HTTP_HOST']}/authentication/index.php");
    }
}
