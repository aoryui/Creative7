<?php
session_start(); // セッションを開始

require_once __DIR__ . '/../backend/class.php';
require_once __DIR__ . '/../backend/pre.php';
$form = new form();
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

// フォームから送信されたデータを受け取る
$choice_id = isset($_POST['choice']) ? $_POST['choice'] : null;
$question_id = isset($_POST['question_id']) ? $_POST['question_id'] : null;

// セッションから表示された質問、選択、を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : [];

// 表示された質問リストから現在の質問の位置を取得
$position = array_search($question_id, $displayed_questions);

// 選択された選択肢IDをセッションに保存
if ($position !== false && $choice_id !== null) {
    $selected_choices[$position] = $choice_id;
    $_SESSION['selected_choice'][$position] = $choice_id;
}

// セッションデータの更新後に表示されるデータを取得
$selected_choice_id = $selected_choices[$position];
$correct_choice_id = $correct_choices[$position];
$displayed_questions_id = $displayed_questions[$position];

// デバッグ情報を表示
echo '<script>console.log('.json_encode($selected_choices).')</script>';
echo '<script>console.log('.json_encode($correct_choices).')</script>';
echo '<script>console.log('.json_encode($selected_choice_id).')</script>';
echo '<script>console.log('.json_encode($correct_choice_id).')</script>';
echo '<script>console.log('.json_encode($displayed_questions_id).')</script>';

if ($selected_choice_id == $correct_choice_id) {
    $quesid = $form->wrongdelete($userid, $displayed_questions_id);
    $result = 'correct';
} else {
    $result = 'incorrect';
}

// セッションに保存された選択肢をデバッグ表示
echo '<pre>';
echo '$_POST: ';
print_r($_POST);
echo '$_SESSION: ';
print_r($_SESSION);
echo '</pre>';

// データベース接続を閉じる
mysqli_close($conn);
header('Location: ../frontend/practice_kaitoukaisetu.php?question_id=' . $position . '&result=' . $result); // original_page.phpを実際の元のページに置き
exit();
?>
