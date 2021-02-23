<?php
session_start();
// Connect to the database
$db = new mysqli('localhost', 'root', '', 'php-auth');

if (!$db) {
    die('Connection failed: ' . mysqli_connect_error());
}

$errors = array();

if (isset($_POST['register'])) {
    $username = $db->real_escape_string($_POST['username']);
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);
    $confirm_password = $db->real_escape_string($_POST['confirm_password']);

    // Validation
    if (empty($username)) {
        array_push($errors, "Username is required!");
    }

    if (empty($email)) {
        array_push($errors, "Email is required!");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "The entered email is not valid!");
    }

    if (empty($password)) {
        array_push($errors, "Password is required!");
    }
    if ($password != $confirm_password) {
        array_push($errors, "Passwords not matching!");
    }

    // Save into DB
    if (count($errors) == 0) {
        $hashed_password = md5($password);
        $query = "INSERT INTO users (user_name, email, hashed_password, password) 
                                VALUES ('$username', '$email', '$hashed_password','$password')";
        $datas_saved = $db->query($query);
        if ($datas_saved !== TRUE) {
            die("FUCK");
        }
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are logged in";
        header("location: http://{$_SERVER['HTTP_HOST']}/authentication/home.php");
    }
}