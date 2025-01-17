<?php
$userid = $_POST['username'];
$password = $_POST['password'];

require_once __DIR__ . '/class.php';
$form = new Form();
$result = $form->authUser2($userid, $password);

session_start();
if (empty($result['userid'])) {
    $_SESSION['login_error'] = 'メールアドレス、パスワードを確認してください。';
    header('Location: ' . '../frontend/kanrisya_login.php');
    exit();
}

$userid = $result['userid'];
$username = $result['username'];

$_SESSION['userid'] = $result['userid'];
$_SESSION['userName'] = $result['username'];
$_SESSION['userEmail'] = $result['email'];

setcookie("userid", $userid, time() + 60 * 60 * 24 * 14, '/');
setcookie("userName", $username, time() + 60 * 60 * 24 * 14, '/');

header(('Location:' . '../frontend/kanrisya_management.php'));
