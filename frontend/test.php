<?php
session_start();
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

// 出題する問題数を設定
$max_question = 10;

// 既に表示した question_id を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
// 選択したchoice_id を取得
$selected_choice = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
// 回答時間を取得
$interval_time = isset($_SESSION['interval_time']) ? $_SESSION['interval_time'] : [];
// $displayed_questions をセッションに保存
$_SESSION['displayed_questions'] = $displayed_questions;
$_SESSION['selected_choice'] = $selected_choice;
$_SESSION['interval_time'] = $interval_time;

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choice'])) {
        $choice_id = $_POST['choice'];

        // 選択肢IDをセッションに保存
        $selected_choice[] = $choice_id;
        $_SESSION['selected_choice'] = $selected_choice;
    }

    if (isset($_POST['time_taken'])) {
        $time_taken = $_POST['time_taken'];

        // 時間切れになると「時間切れ」を入れる
        if ($time_taken === 'timeout') {
            $interval_time[] = '時間切れ';
        } else {
            $interval_time[] = (int)$time_taken;
        }
        $_SESSION['interval_time'] = $interval_time;
    }

    // 既に表示した question_id の数が10つに達したらリセット
    if (count($displayed_questions) >= $max_question) {
        // 模擬試験か練習問題かを判別させるセッション
        $_SESSION['test_display'] = 'test';
        echo '<script>window.location.href = "result.php";</script>';
        exit();
    }
}

// ログ表示
echo '<script>console.log('.json_encode($displayed_questions).')</script>'; // 既に表示した問題IDをコンソールに表示
echo '<script>console.log('.json_encode($selected_choice).')</script>'; // 選択した答えを表示
echo '<script>console.log('.json_encode($interval_time).')</script>'; // 回答時間を表示

// パラメータから question_id を取得。無ければランダムに選択
$question_id = isset($_GET['question_id']) ? (int)$_GET['question_id'] : null;

if (!$question_id) {
    // 既に表示した question_id を除外してランダムに選択
    if (count($displayed_questions) > 0) {
        $excluded_ids = implode(',', $displayed_questions);
        $random_sql = "SELECT question_id FROM questions WHERE question_id NOT IN ($excluded_ids) ORDER BY RAND() LIMIT 1";
    } else {
        $random_sql = "SELECT question_id FROM questions ORDER BY RAND() LIMIT 1";
    }
    $random_result = $conn->query($random_sql);
    if ($random_result->num_rows > 0) {
        $random_question = $random_result->fetch_assoc();
        $question_id = $random_question['question_id'];
    } else {
        // 全ての問題を表示した場合の処理（例: 全ての問題が表示されたとユーザーに通知）
        die("All questions have been displayed.");
    }
}

// 問題を取得
$question_sql = "SELECT * FROM questions WHERE question_id = $question_id";
$question_result = $conn->query($question_sql);

if ($question_result->num_rows > 0) {
    $question = $question_result->fetch_assoc();
} else {
    die("No question found with the given ID.");
}

// 選択肢を取得
$choices_sql = "SELECT * FROM choices WHERE question_id=" . $question['question_id'];
$choices_result = $conn->query($choices_sql);

$conn->close();

// 改行を HTML 改行タグに変換
$question_text = nl2br(htmlspecialchars($question['question_text'], ENT_QUOTES, 'UTF-8'));
$genre_text = nl2br(htmlspecialchars($question['genre_text'], ENT_QUOTES, 'UTF-8'));

// セッションに現在のquestion_idを保存
$_SESSION['displayed_questions'][] = $question_id;

// 制限時間を取得
$interval = $question['interval_num'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <link rel="stylesheet" href="../css/test.css">
</head>
<body scroll="no">
    <div class="content">
        <div class="question">
        <div class="top-contents"><!-- 上のやつ -->
            <p id="question_count"><?php echo $genre_text ?></p> <!-- ジャンル名のやつ -->
            <p><?php echo '問題数'.(count($displayed_questions)+1).'/'.$max_question.'問目'?></p> <!-- 問題数ののやつ -->
        </div>
        <div class="center-contents"></div>
            <p class="img"><?php
            // 画像のパスを作成
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            // HTMLで画像を表示
            echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
            ?></p>
        </div>
        <form id="choiceForm" method="post" action="test.php">
            <div class="choices">
                <?php
                while ($choice = $choices_result->fetch_assoc()) {
                    echo '<div class="choice">';
                    echo '<input type="radio" name="choice" value="' . $choice['choice_id'] . '" id="option' . $choice['choice_id'] . '">';
                    echo '<label for="option' . $choice['choice_id'] . '">' . htmlspecialchars($choice['choice_text'], ENT_QUOTES, 'UTF-8') . '</label>';
                    echo '</div>';
                }
                ?>
            </div>
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
            <input type="hidden" name="time_taken" id="time_taken" value="">
        </form>
    </div>
    </div>
    
    <div class="timer">
        <div class="timer-label">回答時間 <span id="remaining-time"></span></div>
        <div class="timer-container" id="timer-container">
            <div class="timer-bar" id="timer-bar"></div>
        </div>
    </div>
    <a href="#" class="next-button" id="next-button">次に進む</a>
    <script>
        const totalSegments = <?php echo $interval; ?>;
        let startTime;

        function goToNextQuestion() {
            const timeTakenInput = document.getElementById('time_taken');
            const endTime = Date.now();
            const timeTaken = Math.ceil((endTime - startTime) / 1000);
            
            // Check if the timer has reached its end
            if (timeTaken >= totalSegments) {
                timeTakenInput.value = 'timeout'; // Indicate timeout
            } else {
                timeTakenInput.value = timeTaken; // Normal time taken
            }
            
            // Handle choice selection
            if (!document.querySelector('input[name="choice"]:checked')) { // 時間切れの場合は0を格納する
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'choice';
                hiddenInput.value = '0';
                document.getElementById('choiceForm').appendChild(hiddenInput);
            }
            document.getElementById('choiceForm').submit();
        }

        document.getElementById('next-button').addEventListener('click', (e) => {
            e.preventDefault();
            goToNextQuestion();
        });

        document.querySelectorAll('.choice').forEach(choice => { // 選択肢の当たり判定をclass="choice"にも反映
            choice.addEventListener('click', () => {
                const radio = choice.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });

        window.addEventListener('load', function() { // ページリロードされたらteststart.phpに遷移
            if (performance.navigation.type === 1) {
                window.location.href = 'teststart.php';
            }
        });

        document.addEventListener('DOMContentLoaded', function () { // ページが表示されたら実行される
            const timerBar = document.getElementById('timer-bar'); // バーの時間経過で右へ延びる部分
            const timerContainer = document.getElementById('timer-container'); // バーの背景
            const remainingTimeElement = document.getElementById('remaining-time'); // 残り時間表示
            const intervalDuration = totalSegments * 1000; // 制限時間をミリ秒に変換
            startTime = Date.now();
            const endTime = startTime + intervalDuration;

            function updateTimer() {
                const currentTime = Date.now();
                const timeElapsed = currentTime - startTime;
                const timeRemaining = Math.max(0, endTime - currentTime);
                const percentage = (timeElapsed / intervalDuration) * 100;

                // バーの長さを更新
                timerBar.style.width = percentage + '%';

                // 背景の色を更新
                if (percentage < 50) {
                    timerContainer.style.backgroundColor = '#339966'; // 緑
                } else if (percentage < 80) {
                    timerContainer.style.backgroundColor = '#ffcc00'; // 黄
                } else {
                    timerContainer.style.backgroundColor = '#ff0000'; // 赤
                }

                // 残り時間を更新
                remainingTimeElement.textContent = Math.ceil(timeRemaining / 1000) + ' / '+ totalSegments +' 秒';

                if (currentTime >= endTime) { // 時間切れ
                    goToNextQuestion();
                } else {
                    requestAnimationFrame(updateTimer);
                }
            }

            // 初期化
            timerBar.style.transition = 'width 0.1s linear'; // バーの動きのアニメーション設定
            updateTimer();
        });
    </script>
</body>
</html>
