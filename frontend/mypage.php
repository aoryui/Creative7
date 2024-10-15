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
$user_sql = "SELECT * FROM userinfo WHERE userid = $userid";
$user_result = $conn->query($user_sql);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();

    // subjectを取り出してHTMLで表示
    $subject = $user['subject'];
    $exp = $user['exp'];
    $maxExp = 10;

    // レベルの計算
    $level = floor($exp / $maxExp) + 1;

    // 経験値が最大経験値に到達またはそれを超えた場合の処理
    if ($exp >= $maxExp) {
        // レベルアップ時に余剰経験値を計算し、$expをリセット
        $exp = $exp % $maxExp;

        // データベースのexpフィールドを更新
        $update_sql = "UPDATE userinfo SET exp = $exp WHERE userid = $userid";
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
</head>
<body>
    <div class="profile-container">
        <div class="profile-sidebar">
            
            <div class="profile-info">
                <img src="../image/character/shitake1.png" alt="説明文" width="350" height="300">
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
            <h2>プロフィール</h2>
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
            </div>
            <div class="growth-record">
            </div>
        </div>
    </div>

    <!-- 編集用のモーダル -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="pro">
            <h2>プロフィール編集</h2>
            </div>
            <form id="editForm" action="../backend/edit_profile.php" method="POST">
                <label for="editOption">編集する項目を選択してください:</label>
                <select id="editOption" name="editOption" required>
                    <option value="name">名前</option>
                    <option value="subject">学科</option>
                </select>
                <!-- 入力欄を最初から表示 -->
                <div id="editInputContainer">
                    <label for="newValue">新しい値を入力してください:</label>
                    <input type="text" id="newValue" name="newValue" required>
                </div>
                <div class="change-btn">
                <button class="edit-profile-btn" type="submit">変更</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // モーダルを開く関数
        function openEditModal() {
            document.getElementById("editModal").style.display = "block";
        }

        // モーダルを閉じる関数
        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }

        // 閉じるボタンにイベントリスナーを追加
        document.querySelector(".close").addEventListener("click", closeEditModal);

        // モーダル外をクリックしたときにモーダルを閉じる
        window.onclick = function(event) {
            if (event.target == document.getElementById("editModal")) {
                closeEditModal();
            }
        }

        // PHPから取得した経験値をJSに渡す
        const currentExp = <?= $exp ?>; // 経験値
        const maxExp = <?= $maxExp ?>; // 最大経験値

        // レベルバーを更新する関数
        function updateLevelBar(exp, maxExp) {
            const levelBar = document.querySelector('.level-bar');
            const percentage = (exp / maxExp) * 100;
            levelBar.style.width = percentage + '%'; // 経験値に応じてバーの幅を調整
        }

        // ページ読み込み時に経験値バーを更新
        window.onload = function() {
            updateLevelBar(currentExp, maxExp);
        }
    </script>
</body>
</html>
