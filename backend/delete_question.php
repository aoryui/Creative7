<?php
session_start();

// データベースに接続するための情報
$host = 'localhost';
$username = 'Creative7';
$password = '11111';
$database = 'creative7';

// データベースに接続
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

if (isset($_POST['question_id'])) {
    $question_id = $_POST['question_id'];

    $query = "DELETE FROM wrong WHERE question_id = $question_id AND userid = {$_SESSION['userid']}";

    if (mysqli_query($conn, $query)) {
        // 成功した場合、リダイレクト
        header('Location: ../frontend/review.php');
        exit();
    } else {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));//a
    }
}

// データベース接続をクローズ
mysqli_close($conn);
?>
