<?php
session_start();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 1000, '/');
}
session_destroy();

setcookie("userid", '', time() - 1000, '/');
setcookie("userName", '', time() - 1000, '/');

header('Location: ../frontend/login.php');
exit();
?>
