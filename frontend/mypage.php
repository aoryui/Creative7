<?php
session_start(); // セッションを開始

require_once __DIR__ . '/header.php'; // パスの修正

$servername = "localhost";
$username = "Creative7";
$password = "11111";
$dbname = "creative7";

// $servername = "mysql1.php.starfree.ne.jp";
// $username = "creative7_jun";
// $password = "eL6VKCZh";
// $dbname = "creative7_creative7";

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
    $total_questions = $user['total_questions']; // 回答数の取得

    // levelをデータベースから取得
    $level = $user['level']; // データベースからレベルを取得

    // 経験値が最大経験値に到達またはそれを超えた場合の処理
    if ($exp >= $maxExp) {
        // レベルアップ時に余剰経験値を計算し、$expをリセット
        $exp = $exp % $maxExp;

        // levelをデータベースから取得
        $level = $user['level']; // データベースからレベルを取得
        $badge = '';

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
    $correct_count = floor($total_questions * ($correct_rate / 100)); //正解数の取得

} else {
    // ユーザーが見つからない場合の処理
}

// ユーザーの所持バッジを取得するクエリ
$badge_sql = "SELECT badge_id FROM owned_badge WHERE userid = $userid";
$badge_result = $conn->query($badge_sql);

$owned_badges = [];
if ($badge_result->num_rows > 0) {
    while ($row = $badge_result->fetch_assoc()) {
        $owned_badges[] = $row['badge_id'];
    }
}

// バッジ取得フラグ
$received_badges = [
    'badge1' => false
];

// モーダル表示フラグを初期化
$show_modal = false;

// バッジ1を持っていない場合、バッジ1を追加
$required_badges = [1];
$has_required_badges = array_intersect($owned_badges, $required_badges);

// バッジ1を持っていない場合、バッジ1を追加
if (empty($has_required_badges) && !in_array(1, $owned_badges)) {
    $add_badge_sql = "INSERT INTO owned_badge (userid, badge_id) VALUES ($userid, 1)";
    if ($conn->query($add_badge_sql) === TRUE) {
        $owned_badges[] = 1; // 新しく追加したバッジを所持バッジリストに追加
        $received_badges['badge1'] = true;
    } else {
        echo "バッジの取得エラー: " . $conn->error;
    }
}
// バッジ画像の設定
$badge_images = [
    1 => "../image/icon/badge1.png",
    2 => "../image/icon/badge2.png",
    3 => "../image/icon/badge3.png",
    4 => "../image/icon/badge4.png",
    5 => "../image/icon/badge5.png",
    6 => "../image/icon/badge6.png",
    7 => "../image/icon/badge7.png"
];

// 表示するバッジを決定
$badge_to_display = "";
if (in_array(7, $owned_badges)) {
    $badge_to_display = $badge_images[7];
} elseif (in_array(6, $owned_badges)) {
    $badge_to_display = $badge_images[6];
} elseif (in_array(5, $owned_badges)) {
    $badge_to_display = $badge_images[5];
} elseif (in_array(4, $owned_badges)) {
    $badge_to_display = $badge_images[4];
} elseif (in_array(3, $owned_badges)) {
    $badge_to_display = $badge_images[3];
} elseif (in_array(2, $owned_badges)) {
    $badge_to_display = $badge_images[2];
} elseif (in_array(1, $owned_badges)) {
    $badge_to_display = $badge_images[1];
}

// trueのバッジ名を取得
$true_badges = [];
foreach ($received_badges as $badge_name => $status) {
    if ($status) {
        $true_badges[] = $badge_name;
    }
}
// モーダルを表示するかの判定
$show_modal = !empty($true_badges);
// 接続を閉じる
$conn->close();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="../css/mypage.css">
    <link rel="stylesheet" href="../responsive/mypage.css">
</head>
<body>
    <?php if ($show_modal): ?>
        <div class="badge-modal-overlay" id="badge-modalOverlay">
            <div class="badge_modal" id="badge-modal">
                <h2>バッジを獲得！</h2>
                <div>
                    <?php foreach ($true_badges as $badge_name): ?>
                        <img src="../image/icon/<?= htmlspecialchars($badge_name) ?>.png" alt="<?= htmlspecialchars($badge_name) ?>">
                    <?php endforeach; ?>
                </div>
                <button id="badge-closeModal">閉じる</button>
            </div>
        </div>
    <?php endif; ?>
    <div class="profile-container">
        <div class="profile-sidebar">
            <div class="profile-info">
                <?php if ($level >= 125): ?>
                    <img src="../image/character/human5.5.png" alt="" width="300" height="300">
                <?php elseif ($level >= 120): ?>
                    <img src="../image/character/human5.4.png" alt="" width="300" height="300">
                <?php elseif ($level >= 115): ?>
                    <img src="../image/character/human5.3.png" alt="" width="300" height="300">
                <?php elseif ($level >= 110): ?>
                    <img src="../image/character/human5.2.png" alt="" width="300" height="300">
                <?php elseif ($level >= 105): ?>
                    <img src="../image/character/human5.1.png" alt="" width="300" height="300">
                <?php elseif ($level >= 100): ?>
                    <img src="../image/character/human4.5.png" alt="" width="300" height="300">
                <?php elseif ($level >= 95): ?>
                    <img src="../image/character/human4.4.png" alt="" width="300" height="300">
                <?php elseif ($level >= 90): ?>
                    <img src="../image/character/human4.3.png" alt="" width="300" height="300">
                <?php elseif ($level >= 85): ?>
                    <img src="../image/character/human4.2.png" alt="" width="300" height="300">
                <?php elseif ($level >= 80): ?>
                    <img src="../image/character/human4.1.png" alt="" width="300" height="300">
                <?php elseif ($level >= 75): ?>
                    <img src="../image/character/human3.5.png" alt="" width="300" height="300">
                <?php elseif ($level >= 70): ?>
                    <img src="../image/character/human3.4.png" alt="" width="300" height="300">
                <?php elseif ($level >= 65): ?>
                    <img src="../image/character/human3.3.png" alt="" width="300" height="300">
                <?php elseif ($level >= 60): ?>
                    <img src="../image/character/human3.2.png" alt="" width="300" height="300">
                <?php elseif ($level >= 55): ?>
                    <img src="../image/character/human3.1.png" alt="" width="300" height="300">
                <?php elseif ($level >= 50): ?>
                    <img src="../image/character/human2.5.png" alt="" width="300" height="300">
                <?php elseif ($level >= 45): ?>
                    <img src="../image/character/human2.4.png" alt="" width="300" height="300">
                <?php elseif ($level >= 40): ?>
                    <img src="../image/character/human2.3.png" alt="" width="300" height="300">
                <?php elseif ($level >= 35): ?>
                    <img src="../image/character/human2.2.png" alt="" width="300" height="300">
                <?php elseif ($level >= 30): ?>
                    <img src="../image/character/human2.1.png" alt="" width="300" height="300">
                <?php elseif ($level >= 25): ?>
                    <img src="../image/character/human1.5.png" alt="" width="300" height="300">
                <?php elseif ($level >= 20): ?>
                    <img src="../image/character/human1.4.png" alt="" width="300" height="300">
                <?php elseif ($level >= 15): ?>
                    <img src="../image/character/human1.3.png" alt="" width="300" height="300">
                <?php elseif ($level >= 10): ?>
                    <img src="../image/character/human1.2.png" alt="" width="300" height="300">
                <?php elseif ($level >= 5): ?>
                    <img src="../image/character/human1.1.png" alt="" width="300" height="300">
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
                <div id="badge"><p>レベル: <?= $level ?></p>
                    <?php if ($badge_to_display): ?>
                        <img src="<?= htmlspecialchars($badge_to_display, ENT_QUOTES, 'UTF-8') ?>" alt="バッジ" width="75" height="75">
                    <?php endif; ?>
                </div>
                <a href="collection.php" id="button">バッジコレクションページに移動</a>
            </div>
        </div>
        <div class="profile-main">
            <div class="learning-progress">
                <h3>学習進捗</h3>
                <p>正解数： <?=htmlspecialchars($correct_count, ENT_QUOTES, 'UTF-8') ?></p>
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

    <script>
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
        
    </script>
        <div class="modal-overlay" id="modalOverlay">
        <div class="modal" id="modal">
            <span class="close" onclick="closeEditModal()">&times;</span>

            <h2 class="modalTitle">プロフィール編集</h2>

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
                <a href="email_verify.php">パスワードを忘れた場合はこちら</a>
            </form>
    </div>

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
            document.getElementById("modalOverlay").style.display = "block";
        }

        // モーダルを閉じる関数
        function closeEditModal() {
            document.getElementById("modalOverlay").style.display = "none";
        }

        // 閉じるボタンにイベントリスナーを追加
        document.querySelector(".close").addEventListener("click", closeEditModal);

        // モーダル外をクリックしたときにモーダルを閉じる
        window.addEventListener('click', function(event) {
            const modalOverlay = document.getElementById("modalOverlay");
            const modal = document.getElementById("modal");

            // モーダル自体がクリックされた場合は閉じない
            if (event.target === modalOverlay) {
                closeEditModal();
            }
        });

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

        // JavaScriptでモーダルを制御
        document.addEventListener('DOMContentLoaded', () => {
            const badge_modal = document.getElementById('badge-modal'); // 修正済み
            const badge_modalOverlay = document.getElementById('badge-modalOverlay');
            const badge_closeModal = document.getElementById('badge-closeModal');

            if (badge_modal) {
                badge_modal.classList.add('active');
                badge_modalOverlay.classList.add('active');
                
                badge_closeModal.addEventListener('click', () => {
                    closeBadgeModal();
                });
            }
        });

        // モーダルを閉じる関数
        function closeBadgeModal() {
            document.getElementById("badge-modalOverlay").style.display = "none";
        }

        // モーダル外をクリックしたときにモーダルを閉じる
        window.onclick = function(event) {
            if (event.target == document.getElementById("badge-modalOverlay")) {
                closeBadgeModal();
            }
        }
    </script>
    
</body>
</html>
