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
// 選択したchoice_id を取得
$selected_choice = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
// $displayed_questions をセッションに保存
$_SESSION['displayed_questions'] = $displayed_questions;
$_SESSION['selected_choice'] = $selected_choice;

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choice'])) {
        $choice_id = $_POST['choice'];

        // 選択肢IDをセッションに保存
        $selected_choice[] = $choice_id;
        $_SESSION['selected_choice'] = $selected_choice;
    }

    if (isset($_POST['interval'])) {
        $_SESSION['interval'] = (int)$_POST['interval'];
    }
}

// ログ表示
echo '<script>console.log('.json_encode($displayed_questions).')</script>'; // 既に表示した問題IDをコンソールに表示
echo '<script>console.log('.json_encode($selected_choice).')</script>'; // 選択した答えを表示

// 既に表示した question_id の数が10つに達したらリセット
if (count($displayed_questions) >= 10) {
    echo '<script>window.location.href = "result.php";</script>';
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

// 選択した秒数を取得
$interval = isset($_SESSION['interval']) ? $_SESSION['interval'] : 30; // デフォルトは30秒
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
            <?php
            echo '<div class="question-text">問題番号'.$question_id.'次の文章を読んで問いに答えなさい</div>';
            ?>
            <p><?php
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
        </form>
    </div>
    <div class="timer">
        <div class="timer-label">回答時間</div>
        <div class="timer-bar" id="timer-bar">
            <!-- タイマーバーの色の部分をJavaScriptで生成 -->
        </div>
    </div>
    <div class="footer">
        ※時間超過した場合次の問題に行きます
        <a href="#" class="next-button" id="next-button">次に進む</a>
    </div>
    <script>
        const timerBar = document.getElementById('timer-bar');
        const totalSegments = <?php echo $interval; ?>;
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
                segment.style.backgroundColor = lightColors[i % lightColors.length];
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
                    segments[currentSegment].style.backgroundColor = darkColors[currentSegment % darkColors.length];
                    currentSegment++;
                }
            }, segmentTime);
        }

        function goToNextQuestion() {
            // 次の問題に進む処理をここに書く
            if (!document.querySelector('input[name="choice"]:checked')) { // 時間切れの場合は0を格納する
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'choice';
                hiddenInput.value = '0';
                document.getElementById('choiceForm').appendChild(hiddenInput);
            }
            document.getElementById('choiceForm').submit(); // フォームを送信
        }

        document.getElementById('next-button').addEventListener('click', (e) => {
            e.preventDefault();
            goToNextQuestion();
        });

        window.addEventListener('load', function() { // ページリロードされたらteststart.phpに遷移
            if (performance.navigation.type === 1) {
                window.location.href = 'teststart.php';
            }
        });

        createSegments();
        startTimer();
    </script>
</body>
</html>
