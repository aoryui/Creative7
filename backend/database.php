<?php
// database.php
$servername = "localhost";
$username = "Creative7";    // MySQLのユーザー名
$password = "11111";        // MySQLのパスワード（XAMPPのデフォルトは空白）
$dbname = "creative7";  // 使用するデータベース名

try {
    // PDOを使用したデータベース接続
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // 接続成功のメッセージを表示（デバッグ用）
    // echo "Connected successfully"; 
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit; // 接続エラー時はスクリプト終了
}
?>