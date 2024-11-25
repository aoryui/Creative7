<?php
session_start(); // セッションを開始

// データベース接続設定
$host = 'localhost';
$dbname = 'creative7';
$username = 'Creative7';
$password = '11111';

// MySQLi を使った接続
$conn = new mysqli($host, $username, $password, $dbname);

// 接続エラーの確認
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

$userid = $_SESSION['userid']; // セッションからユーザーIDを取得

// ユーザーが所有しているバッジIDを取得
$badge_query = "
    SELECT bc.badge_file 
    FROM owned_badge ob
    JOIN badge_collections bc ON ob.badge_id = bc.badge_id
    WHERE ob.userid = $userid
";
$badge_result = $conn->query($badge_query);

if ($badge_result && $badge_result->num_rows > 0) {
    echo "<div style='display: flex; gap: 10px; flex-wrap: wrap;'>";
    while ($row = $badge_result->fetch_assoc()) {
        // バッジファイル名に.jpgを追加
        $badge_file = $row['badge_file'] . ".png";
        // 画像を表示
        echo "<img src='../image/icon/$badge_file' alt='Badge Image' style='width: 100px; height: 100px;'>";
    }
    echo "</div>";
} else {
    echo "<p>No badges owned.</p>";
}

// データベース接続を閉じる
$conn->close();
?>