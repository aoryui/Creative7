<?php
session_start();

// データベース接続情報
$host = 'localhost';
$username = 'Creative7';
$password = '11111';
$database = 'creative7';

// ユーザーIDを確認
if (!isset($_SESSION['userid'])) {
    die('ユーザーがログインしていません。');
}

$userid = $_SESSION['userid'];

// データベースに接続
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

// ユーザーの間違い問題を全削除
$query = "DELETE FROM wrong WHERE userid = $userid";
$result = mysqli_query($conn, $query);

if (!$result) {
    die('全削除に失敗しました: ' . mysqli_error($conn));
}

mysqli_close($conn);

// 削除後に復習ページにリダイレクト
header('Location: ../frontend/review.php');
exit();
?>
