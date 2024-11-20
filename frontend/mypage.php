<?php
session_start(); // セッションを開始

require_once __DIR__ . '/header.php'; // パスの修正

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

$userid = $_SESSION['userid']; // セッションからユーザーIDを取得
echo '<script>console.log('.json_encode($userid).')</script>';

if ($userid >= 10000000 && $userid <= 99999999) {
    echo "<script>
            alert('ログインしてください');
            window.location.href = 'login.php';
        </script>";
    exit();
}
$user_sql = "SELECT * FROM userinfo WHERE userid = $userid";
$user_result = $conn->query($user_sql);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();

    // subjectを取り出してHTMLで表示
    $subject = $user['subject'];
    $exp = $user['exp'];
    $maxExp = 10;

    // levelをデータベースから取得
    $level = $user['level']; // データベースからレベルを取得

    // 経験値が最大経験値に到達またはそれを超えた場合の処理
    if ($exp >= $maxExp) {
        // レベルアップ時に余剰経験値を計算し、$expをリセット
        $exp = $exp % $maxExp;

        // レベルを更新
        $level += floor($user['exp'] / $maxExp); // 余剰経験値に応じてレベルを更新

        // データベースのexpフィールドとlevelフィールドを更新
        $update_sql = "UPDATE userinfo SET exp = $exp, level = $level WHERE userid = $userid";
        $conn->query($update_sql);
    }

    $correct_rate = $user['correct_rate'];
    $average_time = $user['average_time'];
    $total_questions = $user['total_questions'];
    $correct_rate_lang = $user['correct_rate_lang'];
    $average_time_lang = $user['average_time_lang'];
    $total_questions_lang = $user['total_questions_lang'];
    $correct_rate_nonlang = $user['correct_rate_nonlang'];
    $average_time_nonlang = $user['average_time_nonlang'];
    $total_questions_nonlang = $user['total_questions_nonlang'];
} else {
    // ユーザーが見つからない場合の処理
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../css/mypage.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-info">
                <?php if ($level >= 100): ?>
                    <img src="../image/character/human4.png" alt="破壊ロボット" width="300" height="300">
                <?php elseif ($level >= 50): ?>
                    <img src="../image/character/human3.png" alt="黄金の騎士" width="300" height="300">
                <?php elseif ($level >= 2): ?>
                    <img src="../image/character/human2.png" alt="騎士" width="300" height="300">
                <?php else: ?>
                    <img src="../image/character/human1.png" alt="普通の村人" width="300" height="300">
                <?php endif; ?>
                
                <label>名前：</label><h2 id="name"><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></h2>
                <p>学科：</p><h2 id="subject"><?= htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') ?></h2>
                <div class="level" data-proficiency="100">
                    <div class="level-info">
                        <p class="level-name">Lv. <?= htmlspecialchars($level, ENT_QUOTES, 'UTF-8') ?></p> <!-- レベルを表示 -->
                    </div>
                    <!-- レベルバーの表示 -->
                    <div class="level-bar-container">
                        <div class="level-bar"></div>
                    </div>
                    <div class="level-name">exp
                        <?= htmlspecialchars($exp, ENT_QUOTES, 'UTF-8') ?>
                        /<?php echo $maxExp ?>
                    </div>
                </div>
                <button class="edit-profile-btn" onclick="openEditModal()">プロフィール編集</button>
            </div>
        </div>
        <div class="profile-main">
            <div class="learning-progress">
                <h3>学習進捗</h3>
                <div class="progress-item">
                    <h4 id="sougo">総合</h4>
                    <div class="sougo1">
                        <p>平均正答率：<?= htmlspecialchars($correct_rate, ENT_QUOTES, 'UTF-8') ?>%</p>
                        <p>平均回答時間：<?= htmlspecialchars($average_time, ENT_QUOTES, 'UTF-8') ?>秒</p>
                        <p>学習問題数：<?= htmlspecialchars($total_questions, ENT_QUOTES, 'UTF-8') ?>問</p>
                    </div>
                    <h4 id="language">言語</h4>
                    <div class="language1">
                        <p>平均正答率：<?= htmlspecialchars($correct_rate_lang, ENT_QUOTES, 'UTF-8') ?>%</p>
                        <p>平均回答時間：<?= htmlspecialchars($average_time_lang, ENT_QUOTES, 'UTF-8') ?>秒</p>
                        <p>学習問題数：<?= htmlspecialchars($total_questions_lang, ENT_QUOTES, 'UTF-8') ?>問</p>
                    </div>
                    <h4 id="nonverbal">非言語</h4>
                    <div class="nonverbal1">
                        <p>平均正答率：<?= htmlspecialchars($correct_rate_nonlang, ENT_QUOTES, 'UTF-8') ?>%</p>
                        <p>平均回答時間：<?= htmlspecialchars($average_time_nonlang, ENT_QUOTES, 'UTF-8') ?>秒</p>
                        <p>学習問題数：<?= htmlspecialchars($total_questions_nonlang, ENT_QUOTES, 'UTF-8') ?>問</p>
                    </div>
                </div>
                <!-- グラフ表示用のキャンバス -->
                <!-- <canvas id="learningChart" width="100" height="100"></canvas> -->
            </div>
        </div>
    </div>

    <!-- <script> 
        // PHPからデータをJSに渡す
        const data = {
            labels: ["総合", "言語", "非言語"],
            datasets: [
                {
                    label: "平均正答率 (%)",
                    data: [<?= $correct_rate ?>, <?= $correct_rate_lang ?>, <?= $correct_rate_nonlang ?>],
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1,
                },
                {
                    label: "平均回答時間 (秒)",
                    data: [<?= $average_time ?>, <?= $average_time_lang ?>, <?= $average_time_nonlang ?>],
                    backgroundColor: "rgba(255, 159, 64, 0.2)",
                    borderColor: "rgba(255, 159, 64, 1)",
                    borderWidth: 1,
                },
                {
                    label: "学習問題数 (問)",
                    data: [<?= $total_questions ?>, <?= $total_questions_lang ?>, <?= $total_questions_nonlang ?>],
                    backgroundColor: "rgba(153, 102, 255, 0.2)",
                    borderColor: "rgba(153, 102, 255, 1)",
                    borderWidth: 1,
                },
            ],
        };

        const config = {
            type: "bar",
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: "top" },
                    title: { display: true, text: "学習進捗の統計" },
                },
                scales: { y: { beginAtZero: true } },
            },
        };

        // グラフを描画
        const ctx = document.getElementById("learningChart").getContext("2d");
        new Chart(ctx, config);
    </script> -->
</body>
</html>
