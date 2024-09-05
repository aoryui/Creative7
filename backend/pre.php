<?php
if (!isset($_SESSION)) {
    session_start();
}

$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : '';
$username = isset($_SESSION['userName']) ? $_SESSION['userName'] : '';
$subject = isset($_SESSION['subject']) ? $_SESSION['subject'] : '';

if (empty($userid) || empty($username) || empty($subject)) {
    // 修正：isset($_COOKIE['subject']) のチェックが抜けていた
    if (isset($_COOKIE['userid']) && isset($_COOKIE['userName']) && isset($_COOKIE['subject'])) {
        $userid = $_COOKIE['userid'];
        $username = $_COOKIE['userName'];
        $subject = $_COOKIE['subject'];
    } else {
        $userid = (string)mt_rand(10000000, 99999999);
        $username = "ゲスト";
        $subject = "なし";
        setcookie("userid", $userid, time() + 60 * 60 * 24 * 14, '/');
        setcookie("userName", $username, time() + 60 * 60 * 24 * 14, '/');
        setcookie("userid", $subject, time() + 60 * 60 * 24 * 14, '/');
    }

    $_SESSION['userid'] = $userid;
    $_SESSION['userName'] = $username;
    $_SESSION['subject'] = $subject;
}

date_default_timezone_set('Asia/Tokyo');
