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

// セッションから開いたページのファイル名を取得
$test_display = isset($_SESSION['test_display']) ? $_SESSION['test_display'] : [];

// リザルト画面のファイル場所をセッションに保存
$_SESSION['result_display'] = 'result';

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
    $selected_choice_id = isset($selected_choice[$key]) ? $selected_choice[$key] : null;

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
    if (isset($interval_time[$key]) && $interval_time[$key] !== '時間切れ') {
        $total_time += intval($interval_time[$key]);
    }
}

// 制限時間があるか判定
$interval_time_empty = empty($interval_time);

// 間違えた問題を取得
$incorrect_questions = array_keys(array_filter($correct_answers, function($value) {return $value === false;}));
sort($incorrect_questions); // 問題番号を昇順にソート
echo '<script>console.log('.json_encode($incorrect_questions).')</script>';

foreach ($incorrect_questions as $index => $question_id) {
    $quesid = $form->insert($userid, $incorrect_questions[$index]);
}

// 正解と選択肢のセッション保存
$_SESSION['correct_choices'] = $correct_choices;
$_SESSION['selected_choice'] = $selected_choice;

// 平均回答時間を計算
if (!$interval_time_empty) { // 制限時間がない場合は計算しない
    $average_time = $total_time / $total_questions;
    $average_time=round($average_time);
}
$correct_rate = ($correct_count / $total_questions) * 100; // 正答率を計算

$getUser = $form->getUser($userid); // ユーザーが存在するか確認
// データベースに正答率、平均回答時間、学習問題数を保存
if ($test_display === 'test' && $getUser === true){ // ログイン状態で模擬試験の時だけ学習記録を更新
    $result = $form->getStatus($userid);    // 学習記録を取得
    $correctRate = $result['correct_rate'];      // 正答率
    $averageTime = $result['average_time'];      // 平均回答時間
    $totalQuestions = $result['total_questions']; // 学習問題数

    // 回答率の計算
    $correct_rate_num = $correct_rate / 100; // %を小数に変換
    $correctRate_num = $correctRate / 100;
    // 正答率を計算
    $new_correctRate = (($correctRate_num*$totalQuestions + $correct_rate_num*$total_questions) / ($totalQuestions+$total_questions))*100;
    $new_correctRate = round($new_correctRate); // 四捨五入

    // 回答時間の計算
    $new_averageTime = ($average_time*$total_questions + $averageTime*$totalQuestions) / ($total_questions+$totalQuestions);
    $new_averageTime = round($new_averageTime); // 四捨五入

    // 問題数の合計を計算
    $new_totalQuestions = $totalQuestions+$total_questions;
    // ここにclass.phpのupdateStatusを実行するコード
    $form->updateStatus($userid, $new_correctRate, $new_averageTime, $new_totalQuestions);
}

// ログ表示
echo '<script>console.log('.json_encode($displayed_questions).')</script>';
echo '<script>console.log('.json_encode($selected_choice).')</script>';
echo '<script>console.log('.json_encode($correct_choices).')</script>';
// データベース接続をクローズ
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/result.css">
    <!-- 制限時間がない場合はcssで非表示にするやつ -->
    <style>
        <?php if ($interval_time_empty): ?>
        .interval-time-header,
        .interval-time-cell,
        .average-time {
            display: none;
        }
        <?php endif; ?>
    </style>
</head>
<body>
    <div class="border-frame">
        <h2 class="answer">試験回別レポート</h2>

        <?php if (!$interval_time_empty): ?> <!-- 制限時間がない場合は実行しない -->
            <h2 class="average-time">平均回答時間: <?php echo $average_time; ?>秒</h2>
        <?php endif; ?>
        <h2 class="correct-rate">正答率: <?php echo round($correct_rate, 2); ?>%</h2>

        <table border="1" id="table">
            <tr>
                <th>問題No.</th>
                <th>正誤</th>
                <th>分野</th>
                <th>問題文</th>
                <?php if (!$interval_time_empty): ?><!-- 制限時間がない場合は非表示 -->
                    <th class="interval-time-header">回答時間</th>
                <?php endif; ?>
                <th>解説</th>
                <th>復習</th>
            </tr>
            <?php foreach ($displayed_questions as $key => $question): ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $correct_answers[$question] ? '○' : '×'; ?></td>
                    <td><?php echo htmlspecialchars($genres[$question], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td id="custom-question"><?php echo htmlspecialchars($questionTexts[$question], ENT_QUOTES, 'UTF-8'); ?></td>
                    <?php if (!$interval_time_empty): ?> <!-- 制限時間がない場合は非表示 -->
                        <td class="interval-time-cell"><?php echo (isset($interval_time[$key]) && $interval_time[$key] === '時間切れ') ? $interval_time[$key] : (isset($interval_time[$key]) ? $interval_time[$key] . '秒' : ''); ?></td>
                    <?php endif; ?>
                    <td id="tri"><a href="kaitoukaisetu.php?question_id=<?php echo $key; ?>">解説リンク</a></td>
                    <td id="tri"><a href="review_questions.php?question_id=<?php echo $displayed_questions[$key]; ?>">復習リンク</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
