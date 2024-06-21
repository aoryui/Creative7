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

// 既に表示した question_id を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];

// 既に表示した question_id の数が5つに達したらリセット
if (count($displayed_questions) >= 5) {
    $displayed_questions = [];
    $_SESSION['displayed_questions'] = [];
}

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

// セッションに現在のquestion_idを保存
$_SESSION['displayed_questions'][] = $question_id;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <link rel="stylesheet" href="../css/test.css">
</head>
<body>
    <div class="content">
        <div class="question">
            <div class="question-text">次の文章を読んで問いに答えなさい</div>
            <p><?php
            // 画像のパスを作成
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            // HTMLで画像を表示
            echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
            ?></p>
        </div>
        <div class="choices">
            <?php
            while ($choice = $choices_result->fetch_assoc()) {
                echo '<div class="choice">';
                echo '<input type="radio" name="choice" id="option' . $choice['choice_id'] . '">';
                echo '<label for="option' . $choice['choice_id'] . '">' . htmlspecialchars($choice['choice_text'], ENT_QUOTES, 'UTF-8') . '</label>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <div class="timer">
        <div class="timer-label">回答時間</div>
        <div class="timer-bar" id="timer-bar">
            <!-- タイマーバーの色の部分をJavaScriptで生成 -->
        </div>
    </div>
    <div class="footer">
        <p>時間超過した場合次の問題に行きます</p>
        <a href="#" class="next-button" id="next-button">次に進む</a>
    </div>
    <script>
        const timerBar = document.getElementById('timer-bar');
        const totalSegments = 30;
        const segmentTime = 1000; // 1秒
        const lightColors = [
            '#dcedc8', '#dcedc8', '#dcedc8', '#dcedc8', '#dcedc8',
            '#f0f4c3', '#f0f4c3', '#f0f4c3', '#f0f4c3', '#f0f4c3',
            '#fff9c4', '#fff9c4', '#fff9c4', '#fff9c4', '#fff9c4',
            '#ffecb3', '#ffecb3', '#ffecb3', '#ffecb3', '#ffecb3',
            '#ffe0b2', '#ffe0b2', '#ffe0b2', '#ffe0b2', '#ffe0b2',
            '#ffccbc', '#ffccbc', '#ffccbc', '#ffccbc', '#ffcdd2'
        ];
        const darkColors = [
            '#8bc34a', '#8bc34a', '#8bc34a', '#8bc34a', '#8bc34a',
            '#cddc39', '#cddc39', '#cddc39', '#cddc39', '#cddc39',
            '#ffeb3b', '#ffeb3b', '#ffeb3b', '#ffeb3b', '#ffeb3b',
            '#ffc107', '#ffc107', '#ffc107', '#ffc107', '#ffc107',
            '#ff9800', '#ff9800', '#ff9800', '#ff9800', '#ff9800',
            '#ff5722', '#ff5722', '#ff5722', '#ff5722', '#f44336'
        ];

        function createSegments() {
            for (let i = 0; i < totalSegments; i++) {
                const segment = document.createElement('div');
                segment.style.backgroundColor = lightColors[i];
                timerBar.appendChild(segment);
            }
        }

        function startTimer() {
            let currentSegment = 0;
            const segments = timerBar.children;
            const interval = setInterval(() => {
                if (currentSegment >= totalSegments) {
                    clearInterval(interval);
                    goToNextQuestion(); // タイムアップ後の処理をここに書く
                } else {
                    segments[currentSegment].style.backgroundColor = darkColors[currentSegment];
                    currentSegment++;
                }
            }, segmentTime);
        }

        function goToNextQuestion() {
            // 次の問題に進む処理をここに書く
            window.location.href = "test.php"; // 実際の次の問題のURLに変更
        }

        document.getElementById('next-button').addEventListener('click', (e) => {
            e.preventDefault();
            goToNextQuestion();
        });

        createSegments();
        startTimer();
    </script>
</body>
</html>
