<?php
session_start();

// データベース接続
$servername = "localhost";
$username = "Creative7";
$password = "11111";
$dbname = "creative7";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userid = $_SESSION['userid']; // ユーザーIDの取得
$editOption = $_POST['editOption']; // 選択された編集項目
$newValue = $_POST['newValue']; // 新しい値

if ($editOption === "name") {
    $sql = "UPDATE userinfo SET username = ? WHERE userid = ?";
} elseif ($editOption === "subject") {
    $sql = "UPDATE userinfo SET subject = ? WHERE userid = ?";
} else {
    die("Invalid option selected.");
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $newValue, $userid);

if ($stmt->execute()) {
    echo "プロフィールが更新されました。";
} else {
    echo "エラーが発生しました: " . $stmt->error;
}

$stmt->close();
$conn->close();

// 更新後、プロフィールページにリダイレクト
header("Location: ../frontend/mypage.php");
exit();
?>
