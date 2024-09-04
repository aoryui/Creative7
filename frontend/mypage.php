<?php
session_start(); // セッションを開始

require_once __DIR__ . '/header.php';

$servername = "localhost";
$username = "Creative7";
$password = "11111";
$dbname = "creative7";


// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_sql = "SELECT * FROM userinfo WHERE userid = $userid";
$user_result = $conn->query($user_sql);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();

    // subjectを取り出してHTMLで表示
    $subject = $user['subject'];
} else {
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../css/mypage.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-sidebar">
            <img src="path/to/icon.png" alt="Icon" class="profile-icon">
            <div class="profile-info">
            <label>名前：</label><h2 id="name"><?= htmlspecialchars($username1, ENT_QUOTES, 'UTF-8') ?></h2>
                <p>学科：</p><h2 id="subject"><?= htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') ?></h2>
                <button class="edit-profile-btn">プロフィール編集</button>
                
            </div>
        </div>
        <div class="profile-main">
            <h2>プロフィール</h2>
            <div class="learning-progress">
                <h3>学習進捗</h3>
                <div class="progress-item">
                    <h4>言語 非言語</h4>
                    <p>正答率：</p>
                    <p>平均回答時間：</p>
                    <p>学習問題数：</p>
                </div>
            </div>
            <div class="growth-record">
                <h3>成長記録</h3>
                <img src="path/to/chart.png" alt="gakusyu" class="gakusyu">
            </div>
        </div>
    </div>
</body>
</html>

