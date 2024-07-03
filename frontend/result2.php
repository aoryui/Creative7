<?php
session_start(); // セッションを開始

// フォームから送信されたデータを受け取る
$choice_id = isset($_POST['choice']) ? $_POST['choice'] : null;
$question_id = isset($_POST['question_id']) ? $_POST['question_id'] : null;

// セッションから表示された質問のリストを取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];

// 表示された質問リストから現在の質問の位置を取得
$position = array_search($question_id, $displayed_questions);

// 選択された選択肢IDをセッションに保存
if ($position !== false && $choice_id !== null) {
    $selected_choices[$position] = $choice_id;
    $_SESSION['selected_choice'][$position] = $choice_id;
}

// セッションに保存された選択肢をデバッグ表示
echo '<pre>';
echo '$_POST: ';
print_r($_POST);
echo '$_SESSION: ';
print_r($_SESSION);
echo '</pre>';

// 次のページにリダイレクト（ここでは元のページに戻る例）
header('Location: result.php'); // original_page.phpを実際の元のページに置き換える
exit();
?>
