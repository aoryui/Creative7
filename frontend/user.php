<?php
session_start(); // セッションを開始

require_once __DIR__ . '/header_kanrisya.php';

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

// GETリクエストで渡されたuseridを取得
if (isset($_GET['userid'])) {
    $userid = intval($_GET['userid']); // URLからユーザーIDを取得
} else {
    die('ユーザーIDが指定されていません');
}

// 指定されたユーザーIDに基づいてデータベースから情報を取得
$user_sql = "SELECT * FROM userinfo WHERE userid = $userid";
$user_result = $conn->query($user_sql);

if ($user_result->num_rows > 0) {
    $user = $user_result->fetch_assoc();

    // 必要な情報を変数に格納
    $subject = $user['subject'];
    $exp = $user['exp'];
    $maxExp = 10;
    $level = $user['level']; // レベルを取得

    

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
    <title><?= htmlspecialchars($user['username']) ?>のマイページ</title>
    <link rel="stylesheet" href="../css/mypage.css">
</head>
<body>
    <div class="profile-container">
        <div class="profile-sidebar">
            
            <div class="profile-info">
                <?php if ($level >= 100): ?>
                    <img src="../image/character/shitake4.png" alt="シイタケ最終形態" width="350" height="300">
                <?php elseif ($level >= 50): ?>
                    <img src="../image/character/shitake3.png" alt="シイタケ進化後" width="350" height="300">
                <?php elseif ($level >= 2): ?>
                    <img src="../image/character/shitake2.png" alt="シイタケ成長後" width="350" height="300">
                <?php else: ?>
                    <img src="../image/character/shitake1.png" alt="シイタケ原木" width="350" height="300">
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
                    <select id="editOption" name="editOption" required onchange="handleOptionChange()">
                        <option value="name">名前</option>
                        <option value="subject">学科</option>
                    </select>

                    <!-- 入力欄またはプルダウンメニュー -->
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

    <footer>
        <div class="footer-content">
        <a href="kanrisya.php" class="back-to-kanrisya">管理者画面に戻る</a>
        <style>
    .back-to-kanrisya {
    display: inline-block;    /* ボタンのように表示 */
    padding: 10px 20px;       /* ボタンの内側余白 */
    background-color: #007BFF; /* 背景色（青） */
    color: white;             /* 文字色（白） */
    text-decoration: none;    /* リンクの下線を消す */
    border-radius: 5px;       /* 角を丸める */
    font-size: 16px;          /* 文字サイズ */
    transition: background-color 0.3s; /* 背景色の変化にアニメーションを追加 */
    }

        </style>
        </div>
    </footer>

    <script>
        function handleOptionChange() {
        const editOption = document.getElementById('editOption').value;
        const editInputContainer = document.getElementById('editInputContainer');
        
        if (editOption === 'subject') {
            // 学科選択肢用のプルダウンメニューを表示
            editInputContainer.innerHTML = `
                <label for="newValue">学科を選択してください:</label>
                <select id="newValue" name="newValue" required>
                    <option value="ITエキスパート学科">ITエキスパート学科</option>
                    <option value="ITスペシャリスト学科">ITスペシャリスト学科</option>
                    <option value="情報処理学科">情報処理学科</option>
                    <option value="AIシステム開発学科">AIシステム開発学科</option>
                </select>
            `;
        } else {
            // 名前用のテキスト入力フィールドを表示
            editInputContainer.innerHTML = `
                <label for="newValue">新しい値を入力してください:</label>
                <input type="text" id="newValue" name="newValue" required>
            `;
        }
    }
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
