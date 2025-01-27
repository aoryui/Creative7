<?php
session_start(); // セッションを開始

require_once __DIR__ . '/header_review_question.php'; // ヘッダーを読み込む

// データベース接続情報
$servername = "localhost";
$username = "Creative7";
$password = "11111";
$dbname = "creative7";

// セッションに保存されたユーザーIDを取得
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
// ユーザーIDが指定の範囲外なら、ログイン画面にリダイレクト
if ($userid >= 10000000 && $userid <= 99999999) {
    echo "<script>
            alert('ログインしてください');
            window.location.href = 'login.php';
        </script>";
    exit();
}

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// URLパラメータから問題IDを取得
$question_id = isset($_GET['question_id']) ? $_GET['question_id'] : null;

// セッションから選択肢と正解の情報を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : []; // 表示された問題のID
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : []; // ユーザーが選択した選択肢
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : []; // 正しい選択肢
$_SESSION['test_display'] = 'test'; // テストの表示を初期化

// リスト内での位置を取得（問題IDに対応する位置）
$position = array_search($question_id, $displayed_questions);

// デバッグ用：選択した答えをコンソールに表示
echo '<script>console.log('.json_encode($selected_choices).')</script>';

// 問題情報をデータベースから取得
$question_sql = "SELECT * FROM questions WHERE question_id = $question_id";
$question_result = $conn->query($question_sql);
if ($question_result->num_rows > 0) {
    $question = $question_result->fetch_assoc(); // 問題データを取得
} else {
    die("No question found with the given ID."); // 問題が見つからなかった場合
}

// 選択肢をデータベースから取得
$choices_sql = "SELECT * FROM choices WHERE question_id=" . $question['question_id'];
$choices_result = $conn->query($choices_sql);

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['choice'])) {
        // 選択肢が選ばれた場合、そのIDをセッションに保存
        $choice_id = $_POST['choice'];
        $selected_choices[$position] = $choice_id; // 選択した位置にIDを設定
        $_SESSION['selected_choice'][$position] = $choice_id; // セッションに保存
    }

    if (isset($_POST['interval'])) {
        // インターバルをセッションに保存
        $_SESSION['interval'] = (int)$_POST['interval'];
    }
    
    // デバッグ情報の表示
    echo '<pre>';
    echo '$_POST: ';
    print_r($_POST);
    echo '$_SESSION: ';
    print_r($_SESSION);
    echo '</pre>';
}

// データベース接続を閉じる
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
    <link rel="stylesheet" href="../css/review_question.css"> <!-- スタイルシートの読み込み -->
    <link rel="stylesheet" href="../responsive/review_question.css"> <!-- レスポンシブ用スタイル -->
</head>
<body>
    <div class="content">
        <div class="question">
            <p><?php
            // 問題文に基づいて画像のパスを作成
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            // 画像を表示
            echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
            ?></p>
        </div>
        <form id="choiceForm" method="post" action="../backend/review_db.php">
            <div class="choices">
                <?php
                // 取得した選択肢を表示
                while ($choice = $choices_result->fetch_assoc()) {
                    echo '<div class="choice">';
                    echo '<input type="radio" name="choice" value="' . $choice['choice_id'] . '" id="option' . $choice['choice_id'] . '">';
                    echo '<label for="option' . $choice['choice_id'] . '">' . htmlspecialchars($choice['choice_text'], ENT_QUOTES, 'UTF-8') . '</label>';
                    echo '</div>';
                }
                ?>
            </div>
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>"> <!-- 問題IDをフォームに隠しフィールドとして追加 -->
        </form>
    </div>

    <!-- 判定ボタン -->
    <a href="#" class="next-button" id="next-button">判定する</a>

    <script>
        // 次の問題に進む処理
        function goToNextQuestion() {
            // 時間切れの場合、選択肢が選ばれていなければhiddenフィールドを追加して送信
            if (!document.querySelector('input[name="choice"]:checked')) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'choice';
                hiddenInput.value = '0'; // 未選択の場合、0を格納
                document.getElementById('choiceForm').appendChild(hiddenInput);
            }
            document.getElementById('choiceForm').submit(); // フォームを送信
        }

        // 判定ボタンのクリックイベントリスナー
        document.getElementById('next-button').addEventListener('click', (e) => {
            e.preventDefault(); // リンクのデフォルトの動作を無効化
            goToNextQuestion(); // 次の問題に進む
        });

        // 選択肢をクリックした際にラジオボタンをチェックする処理
        document.querySelectorAll('.choice').forEach(choice => { 
            choice.addEventListener('click', () => {
                const radio = choice.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true; // ラジオボタンをチェック
                }
            });
        });
    </script>

</body>
</html>
