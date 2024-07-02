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

// 正誤判定用の配列を初期化
$correct_answers = [];  // 各問題の正誤を格納する配列
$genres = [];  // 各問題の分野を格納する配列
$correct_choices = [];  // 各問題の正解選択肢IDを格納する配列

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
}
// 間違えた問題を取得
$incorrect_questions = array_keys(array_filter($correct_answers, function($value) {return $value === false;}));
sort($incorrect_questions); // 問題番号を昇順にソート
echo '<script>console.log('.json_encode($incorrect_questions).')</script>';

$quesid = $form->insert($userid,'1');

// データベース接続をクローズ
mysqli_close($conn);

// 正解と選択肢のセッション保存
$_SESSION['correct_choices'] = $correct_choices;
$_SESSION['selected_choice'] = $selected_choice;

// ログ表示
echo '<script>console.log('.json_encode($displayed_questions).')</script>';
echo '<script>console.log('.json_encode($selected_choice).')</script>';
echo '<script>console.log('.json_encode($correct_choices).')</script>';
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/result.css">
</head>
<body>
    <div class="border-frame">
<!-- <div class="bar-graph-wrap">
        <div class="graph">
            <span class="name">Graph 01</span>
            <span class="number">70%</span>
        </div>
    </div>

    <h2 class="level">Lv.10</h2>
    <h2 class="exp">700/1000 exp</h2>
    <h2 class="addition">+100exp</h2>
    <h2 class="correct-answer-rate">正答率:</h2>
    <h2 class="rate">20%</h2>
    <h2 class="response-time">平均回答時間：</h2>
    <h2 class="time">180秒</h2>
-->
    <h2 class="answer">回答</h2>

    <table border="1" id="table">
        <tr>
            <th>問題No.</th>
            <th>正誤</th>
            <th>分野</th>
            <th>解説</th>
        </tr>
        <?php foreach ($displayed_questions as $key => $question): ?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $correct_answers[$question] ? '○' : '×'; ?></td>
                <td><?php echo htmlspecialchars($genres[$question], ENT_QUOTES, 'UTF-8'); ?></td>
                <td id="tri"><a href="kaitoukaisetu.php?question_id=<?php echo $key; ?>">解説リンク</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    </div>
</body>
</html>
