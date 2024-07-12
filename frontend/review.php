<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$form = new form();
require_once __DIR__ . '/../backend/pre.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

// データベースに接続するための情報
$host = 'localhost';
$username = 'Creative7';
$password = '11111';
$database = 'creative7';

// データベースに接続
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$selected_choice = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
$interval_time = isset($_SESSION['interval_time']) ? $_SESSION['interval_time'] : [];

// 正誤判定用の配列を初期化
$correct_answers = [];  // 各問題の正誤を格納する配列
$genres = [];  // 各問題の分野を格納する配列
$correct_choices = [];  // 各問題の正解選択肢IDを格納する配列
$questionTexts = []; // 問題のテキストを格納する配列

$total_time = 0; // 合計回答時間
$total_questions = count($displayed_questions); // 問題数
$correct_count = 0; // 正解数

// 各問題の正誤を判定する
foreach ($displayed_questions as $key => $question_id) {
    // 問題IDに対応する正解の選択肢IDを取得するクエリ
    $query = "SELECT correct_choice_id FROM answers WHERE question_id = $question_id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);
    $correct_choice_id = $row['correct_choice_id'];
    $correct_choices[] = $correct_choice_id;

    // 選択された選択肢IDを取得
    $selected_choice_id = $selected_choice[$key];

    // 正誤判定
    if ($selected_choice_id == $correct_choice_id) {
        $correct_answers[$question_id] = true; // 正解の場合
        $correct_count++; // 正解数をカウント
    } else {
        $correct_answers[$question_id] = false; // 不正解の場合
    }

    // 分野名を取得するクエリ
    $genre_query = "SELECT genre_text FROM questions WHERE question_id = $question_id";
    $genre_result = mysqli_query($conn, $genre_query);

    if (!$genre_result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    $genre_row = mysqli_fetch_assoc($genre_result);
    $genres[$question_id] = $genre_row['genre_text'];

    // 問題名を取得するクエリ
    $questionText_query = "SELECT sentence FROM questions WHERE question_id = $question_id";
    $questionText_result = mysqli_query($conn, $questionText_query);

    if (!$questionText_result) {
        die('クエリ実行に失敗しました: ' . mysqli_error($conn));
    }

    $questionText_row = mysqli_fetch_assoc($questionText_result);
    $questionTexts[$question_id] = $questionText_row['sentence'];

    // 回答時間を合計に追加
    if ($interval_time[$key] !== '時間切れ') {
        $total_time += intval($interval_time[$key]);
    }
}

// データベース接続をクローズ
mysqli_close($conn);

// 正解と選択肢のセッション保存
$_SESSION['correct_choices'] = $correct_choices;
$_SESSION['selected_choice'] = $selected_choice;

// 間違えた問題を取得
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die('データベースに接続できませんでした: ' . mysqli_connect_error());
}

$wrong_questions = [];
$wrong_query = "SELECT question_id FROM wrong WHERE userid = $userid";
$wrong_result = mysqli_query($conn, $wrong_query);
if (!$wrong_result) {
    die('クエリ実行に失敗しました: ' . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($wrong_result)) {
    $wrong_questions[] = $row['question_id'];
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/review.css">
</head>
<body>
    <div class="border-frame">
    <h2 class="answer">復習問題</h2>
    <table border="1" id="table">
        <tr>
            <th>分野</th>
            <th>問題文</th>
            <th>解説</th>
            <th>復習</th>
        </tr>
        <?php foreach ($wrong_questions as $question_id): ?>
            <?php
                // 問題の詳細を取得
                $conn = mysqli_connect($host, $username, $password, $database);
                if (!$conn) {
                    die('データベースに接続できませんでした: ' . mysqli_connect_error());
                }

                $query = "SELECT genre_text, sentence FROM questions WHERE question_id = $question_id";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    die('クエリ実行に失敗しました: ' . mysqli_error($conn));
                }

                $row = mysqli_fetch_assoc($result);
                $genre = $row['genre_text'];
                $sentence = $row['sentence'];

                mysqli_close($conn);
            ?>
            <tr>
                <td><?php echo htmlspecialchars($genre, ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($sentence, ENT_QUOTES, 'UTF-8'); ?></td>
                <td id="tri"><a href="kaitoukaisetu3.php?question_id=<?php echo $question_id; ?>">解説リンク</a></td>
                <td id="tri"><a href="review_questions.php?question_id=<?php echo $question_id; ?>">問題</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>
