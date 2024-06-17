<?php
if (!isset($_SESSION)) {
    session_start();
}

$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
$username = isset($_SESSION['userName']) ? $_SESSION['userName'] : '';

if (empty($userid) || empty($username)) {
    if (isset($_COOKIE['userid']) && isset($_COOKIE['userName'])) {
        $userid = $_COOKIE['userid'];
        $username = $_COOKIE['userName'];
    } else {
        $userid = (string)mt_rand(10000000, 99999999);
        $username = "ゲスト";
        setcookie("userid", $userid, time() + 60 * 60 * 24 * 14, '/');
        setcookie("userName", $username, time() + 60 * 60 * 24 * 14, '/');
    }

    $_SESSION['userid'] = $userid;
    $_SESSION['userName'] = $username;
}

date_default_timezone_set('Asia/Tokyo');
