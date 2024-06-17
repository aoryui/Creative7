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

// 問題を取得
$question_sql = "SELECT * FROM questions LIMIT 1"; // ここでは最初の問題を取得
$question_result = $conn->query($question_sql);
$question = $question_result->fetch_assoc();

// 選択肢を取得
$choices_sql = "SELECT * FROM choices WHERE question_id=" . $question['question_id'];
$choices_result = $conn->query($choices_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
</head>
<body>
    <div class="content">
        <div class="question">
            <div class="question-text">次の文章を読んで問いに答えなさい</div>
            <p><?php echo $question['question_text']; ?></p>
        </div>
        <div class="choices">
            <?php
            while ($choice = $choices_result->fetch_assoc()) {
                echo '<div class="choice">';
                echo '<input type="radio" name="choice" id="option' . $choice['choice_id'] . '">';
                echo '<label for="option' . $choice['choice_id'] . '">' . $choice['choice_text'] . '</label>';
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
            window.location.href = "次の問題のURL"; // 実際の次の問題のURLに変更
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
