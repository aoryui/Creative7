<?php
session_start(); // セッション開始
require_once __DIR__ . '/header_test.php'; // ヘッダーの読み込み

// データベース接続の設定
$servername = "localhost"; // サーバー名
$username = "Creative7"; // ユーザー名
$password = "11111"; // パスワード
$dbname = "creative7"; // データベース名

// $servername = "mysql1.php.starfree.ne.jp"; // もし本番環境を使用する場合のサーバー名
// $username = "creative7_jun"; // 本番環境のユーザー名
// $password = "eL6VKCZh"; // 本番環境のパスワード
// $dbname = "creative7_creative7"; // 本番環境のデータベース名

// データベース接続を確立
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // 接続失敗時にエラーメッセージを表示
}

// 出題する問題数を設定
$max_question = 10;

// 既に表示した問題のIDをセッションから取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
// 選択した回答（choice_id）をセッションから取得
$selected_choice = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
// 回答にかかった時間（秒）をセッションから取得
$interval_time = isset($_SESSION['interval_time']) ? $_SESSION['interval_time'] : [];

// セッションにデータを保存
$_SESSION['displayed_questions'] = $displayed_questions;
$_SESSION['selected_choice'] = $selected_choice;
$_SESSION['interval_time'] = $interval_time;

// フォームが送信された時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 選択した選択肢がある場合
    if (isset($_POST['choice'])) {
        $choice_id = $_POST['choice']; // 選択肢のIDを取得

        // 選択肢IDをセッションに保存
        $selected_choice[] = $choice_id;
        $_SESSION['selected_choice'] = $selected_choice;
    }

    // 回答時間を取得
    if (isset($_POST['time_taken'])) {
        $time_taken = $_POST['time_taken'];

        // 時間切れの場合、「時間切れ」を記録
        if ($time_taken === 'timeout') {
            $interval_time[] = '時間切れ';
        } else {
            // 時間が正常に計測された場合
            $interval_time[] = (int)$time_taken;
        }
        $_SESSION['interval_time'] = $interval_time;
    }

    // 既に表示した問題数が10問に達したら結果ページへ遷移
    if (count($displayed_questions) >= $max_question) {
        // 模擬試験か練習問題かを判別し、テスト終了後に結果ページへ遷移
        $_SESSION['test_display'] = 'test';
        echo '<script>window.location.href = "honban_result.php";</script>';
        exit(); // これ以上処理を実行しない
    }
}

// ログ表示（デバッグ用）
echo '<script>console.log('.json_encode($displayed_questions).')</script>'; // 表示した問題ID
echo '<script>console.log('.json_encode($selected_choice).')</script>'; // 選択した選択肢
echo '<script>console.log('.json_encode($interval_time).')</script>'; // 回答時間

// URLパラメータからquestion_idを取得（指定がない場合はランダムに選択）
$question_id = isset($_GET['question_id']) ? (int)$_GET['question_id'] : null;

if (!$question_id) {
    // 既に表示した問題を除外し、ランダムに問題IDを選択
    if (count($displayed_questions) > 0) {
        $excluded_ids = implode(',', $displayed_questions); // 既に表示した問題IDをカンマ区切りで取得
        $random_sql = "SELECT question_id FROM questions WHERE question_id NOT IN ($excluded_ids) ORDER BY RAND() LIMIT 1";
    } else {
        // 初回表示時は全ての問題からランダムに選択
        $random_sql = "SELECT question_id FROM questions ORDER BY RAND() LIMIT 1";
    }
    $random_result = $conn->query($random_sql);
    if ($random_result->num_rows > 0) {
        $random_question = $random_result->fetch_assoc();
        $question_id = $random_question['question_id'];
    } else {
        // すべての問題が表示された場合の処理
        die("All questions have been displayed.");
    }
}

// 問題の詳細をデータベースから取得
$question_sql = "SELECT * FROM questions WHERE question_id = $question_id";
$question_result = $conn->query($question_sql);

if ($question_result->num_rows > 0) {
    $question = $question_result->fetch_assoc(); // 問題情報を取得
} else {
    die("No question found with the given ID."); // 問題が見つからなかった場合の処理
}

// 選択肢を取得
$choices_sql = "SELECT * FROM choices WHERE question_id=" . $question['question_id'];
$choices_result = $conn->query($choices_sql);

// データベース接続を閉じる
$conn->close();

// 改行をHTMLの改行タグに変換
$question_text = nl2br(htmlspecialchars($question['question_text'], ENT_QUOTES, 'UTF-8'));
$genre_text = nl2br(htmlspecialchars($question['genre_text'], ENT_QUOTES, 'UTF-8'));

// 現在の問題IDをセッションに保存
$_SESSION['displayed_questions'][] = $question_id;

// 制限時間を取得
$interval = $question['interval_num']; // 制限時間
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <link rel="stylesheet" href="../css/test.css"> <!-- テスト用CSS -->
    <link rel="stylesheet" href="../responsive/test.css"> <!-- レスポンシブCSS -->
</head>
<body>
    <div class="content">
        <button class="edit-profile-btn" onclick="location.href='teststart.php';">模擬試験開始に戻る</button> <!-- 模擬試験開始に戻るボタン -->
        <div class="question">
            <div class="top-contents">
                <p id="question_count"><?php echo $genre_text ?></p> <!-- ジャンル名 -->
                <p id="count"><?php echo '問題数'.(count($displayed_questions)+1).'/'.$max_question.'問目'?></p> <!-- 現在の問題数 -->
            </div>
            <div class="center-contents"></div>
            <?php
            // 画像パスを作成
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            // HTMLで画像を表示
            echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
            ?>
        </div>
        <form id="choiceForm" method="post" action="test.php">
            <div class="choices">
                <?php
                while ($choice = $choices_result->fetch_assoc()) {
                    // 各選択肢を表示
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
    
    <!-- タイマーの表示 -->
    <div class="timer">
        <div class="timer-label">回答時間 <span id="remaining-time"></span></div>
        <div class="timer-container" id="timer-container">
            <div class="timer-bar" id="timer-bar"></div>
        </div>
    </div>

    <!-- 次に進むボタン -->
    <a href="#" class="next-button" id="next-button">次に進む</a>

    <script>
        const totalSegments = <?php echo $interval; ?>; // 制限時間（秒）
        let startTime; // 開始時間

        // 次の問題に進む処理
        function goToNextQuestion() {
            const timeTakenInput = document.getElementById('time_taken');
            const endTime = Date.now();
            const timeTaken = Math.ceil((endTime - startTime) / 1000); // 経過時間を秒単位で計算

            // 時間切れ判定
            if (timeTaken >= totalSegments) {
                timeTakenInput.value = 'timeout'; // 時間切れ
            } else {
                timeTakenInput.value = timeTaken; // 通常の経過時間
            }

            // 回答が選択されていない場合は0をセット
            if (!document.querySelector('input[name="choice"]:checked')) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'choice';
                hiddenInput.value = '0';
                document.getElementById('choiceForm').appendChild(hiddenInput);
            }

            document.getElementById('choiceForm').submit(); // フォームを送信
        }

        // 次に進むボタンがクリックされたとき
        document.getElementById('next-button').addEventListener('click', (e) => {
            e.preventDefault();
            goToNextQuestion();
        });

        // 画面上の選択肢クリック時にラジオボタンを選択
        document.querySelectorAll('.choice').forEach(choice => {
            choice.addEventListener('click', () => {
                const radio = choice.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });

        window.addEventListener('load', function() { // ページがリロードされたとき
            if (performance.navigation.type === 1) {
                window.location.href = 'teststart.php'; // teststart.phpに遷移
            }
        });

        // ページが表示されたときにタイマーを開始
        document.addEventListener('DOMContentLoaded', function () {
            const timerBar = document.getElementById('timer-bar'); // タイマーのバー
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

                // 背景色の更新
                if (percentage < 50) {
                    timerContainer.style.backgroundColor = '#339966'; // 緑
                } else if (percentage < 80) {
                    timerContainer.style.backgroundColor = '#ffcc00'; // 黄
                } else {
                    timerContainer.style.backgroundColor = '#ff0000'; // 赤
                }

                // 残り時間を更新
                remainingTimeElement.textContent = Math.ceil(timeRemaining / 1000) + ' / ' + totalSegments + ' 秒';

                if (currentTime >= endTime) {
                    goToNextQuestion(); // 時間切れで次の問題へ
                } else {
                    requestAnimationFrame(updateTimer); // タイマーを更新
                }
            }

            updateTimer();
        });
    </script>
</body>
</html>
