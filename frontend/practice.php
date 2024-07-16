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

// displayed_questions と current_question_index をセッションから取得
$displayed_questions = isset($_SESSION['displayed_questions']) && is_array($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$current_question_index = isset($_SESSION['current_question_index']) && is_int($_SESSION['current_question_index']) ? $_SESSION['current_question_index'] : 0;

// 選択した choice_id を取得
$selected_choice = isset($_SESSION['selected_choice']) && is_array($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choice'])) {
        $choice_id = $_POST['choice'];

        // 選択肢IDをセッションに保存
        $selected_choice[] = $choice_id;
        $_SESSION['selected_choice'] = $selected_choice;

        // 次の問題に進むためにインデックスを更新
        $current_question_index++;
        $_SESSION['current_question_index'] = $current_question_index;

        // 全ての問題が表示されたら終了メッセージを表示（例として）
        if ($current_question_index >= count($displayed_questions)) {
            echo '<script>window.location.href = "result.php";</script>';
            exit;
        }
    }
}

// 現在の question_id を取得
if (isset($displayed_questions[$current_question_index])) {
    $question_id = $displayed_questions[$current_question_index];
} else {
    die("No more questions available.");
}

// ログ表示
echo '<script>console.log('.json_encode($displayed_questions).')</script>'; // 既に表示した問題IDをコンソールに表示
echo '<script>console.log('.json_encode($selected_choice).')</script>'; // 選択した答えを表示

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
    <link rel="stylesheet" href="../css/test.css">
</head>
<body scroll="no">
    <div class="content">
        <div class="question">
            <p><?php
            // 画像のパスを作成
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            // HTMLで画像を表示
            echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
            ?></p>
        </div>
        <form id="choiceForm" method="post" action="practice.php">
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
    <a href="#" class="next-button" id="next-button">次に進む</a>
    <script>
        function goToNextQuestion() {
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

        window.addEventListener('load', function() { // ページリロードされたらpracticestart.phpに遷移
            if (performance.navigation.type === 1) {
                window.location.href = 'practicestart.php';
            }
        });

    </script>
</body>
</html>
