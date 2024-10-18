<?php
session_start();
require_once __DIR__ . '/class.php';
$form = new form();

$username = $_POST['username'];
$email = $_POST['address'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['signup_error'] = '正しいメールアドレスを入力してください。';
    header('Location: ../frontend/kanrisya_signup.php');
    exit();
}

$result = $form->signUP2($username, $email, $password);

if ($result == '') {
    header('Location: ../frontend/kanrisya_login.php');
    exit();
} else {
    $_SESSION['signup_error'] = $result;
    header('Location: ../frontend/kanrisya_signup.php');
    exit();
}
