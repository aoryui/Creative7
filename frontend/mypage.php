<?php
require_once __DIR__ . '/header.php';
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
                <h2>名前</h2>
                <p>学科：</p>
                <p>Lv.10</p>
                <div class="progress-bar">
                    <div class="progress" style="width: 70%;"></div>
                </div>
                <p class="progress-text">700/1000 exp</p>
                <p>SPI合格するぞ<br>テニスやろうぜ！</p>
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

