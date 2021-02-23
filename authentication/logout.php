<?php
// unset session
session_start();
session_destroy();
session_unset();
// unset cookies
if (isset($_COOKIE["remembered_logged_member"])) {
    setcookie("remembered_logged_member", "", 1);
    unset($_COOKIE['remembered_logged_member']);
}
// die("<pre>".print_r($_COOKIE['remembered_logged_member'],true)."</pre>");
// redirect
header("location: http://{$_SERVER['HTTP_HOST']}/authentication/index.php");