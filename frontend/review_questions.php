<?php
session_start(); // セッションを開始

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
// question_idを取得
$question_id = isset($_GET['question_id']) ? $_GET['question_id'] : null;

// セッションから選択肢と正解の情報を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : [];
$_SESSION['test_display'] = 'test'; //test_displayを初期化

// リストの番号を取得
$position = array_search($question_id, $displayed_questions);
echo '<script>console.log('.json_encode($selected_choices).')</script>'; // 選択した答えを表示

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

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choice'])) {
        $choice_id = $_POST['choice'];
        // 指定した位置に選択肢IDを設定
        $selected_choices[$position] = $choice_id;
        // 選択肢の配列をセッションに保存
        $_SESSION['selected_choice'][$position] = $choice_id;
    }

    if (isset($_POST['interval'])) {
        $_SESSION['interval'] = (int)$_POST['interval'];
    }
    
    // デバッグ情報を表示
    echo '<pre>';
    echo '$_POST: ';
    print_r($_POST);
    echo '$_SESSION: ';
    print_r($_SESSION);
    echo '</pre>';
}

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
<body>
    <div class="content">
        <div class="question">
            <p><?php
            // 画像のパスを作成
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            // HTMLで画像を表示
            echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
            ?></p>
        </div>
        <form id="choiceForm" method="post" action="../backend/review_db.php">
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
    <div class="footer">
        <a href="#" class="next-button" id="next-button">判定する</a>
    </div>
    <script>
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

        document.querySelectorAll('.choice').forEach(choice => { // 選択肢の当たり判定をclass="choice"にも反映
            choice.addEventListener('click', () => {
                const radio = choice.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });

    </script>
    
</body>
</html>
