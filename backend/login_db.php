<?php
// データベース接続の情報
$host = 'localhost';
$username = 'Creative7';
$password = '11111';
$database = 'creative7';

// データベース接続を試みる
$conn = mysqli_connect($host, $username, $password, $database);

// 接続エラーチェック
if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

$userid = $_POST['username'];
$password = $_POST['password'];

require_once __DIR__ . '/class.php';
$form = new Form();
$result = $form->authUser($userid, $password);

session_start();
if (empty($result['userid'])) {
    $_SESSION['login_error'] = 'メールアドレス、パスワードを確認してください。';
    header('Location: ' . '../frontend/login.php');
    exit();
}

$userid = $result['userid'];
$username = $result['username'];

$_SESSION['userid'] = $result['userid'];
$_SESSION['userName'] = $result['username'];
$_SESSION['userEmail'] = $result['email'];

setcookie("userid", $userid, time() + 60 * 60 * 24 * 14, '/');
setcookie("userName", $username, time() + 60 * 60 * 24 * 14, '/');

// ログイン成功時に最終ログイン時間を更新
$userid = $_SESSION['userid']; // セッションからユーザーIDを取得
$update_sql = "UPDATE userinfo SET last_login = NOW() WHERE userid = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param('i', $userid);
$stmt->execute();

header(('Location:' . '../frontend/mypage.php'));
