<?php
session_start();
if (isset($_COOKIE['login_token'])) {
    setcookie("login_token", "", time() - 3600, "/");
}
session_destroy();
header("Location: login.php");
exit();
?>