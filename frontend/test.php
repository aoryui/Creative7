<?php
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

// パラメータから question_id を取得。無ければ1をデフォルト値とする
$question_id = isset($_GET['question_id']) ? (int)$_GET['question_id'] : 1;

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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
</head>
    <link rel="stylesheet" href="../css/test.css">
<body>
    <div class="content">
        <div class="question">
            <div class="question-text">次の文章を読んで問いに答えなさい</div>
            <p><?php
            // 画像のパスを作成
            $image_path = "../image/言語/" . $question_text . ".jpg";
            // HTMLで画像を表示
            echo '<img src="' . $image_path . '" alt="icon">';
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
            const nextQuestionId = <?php echo $question['question_id'] + 1; ?>;
            window.location.href = "test.php?question_id=" + nextQuestionId; // 実際の次の問題のURLに変更
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
