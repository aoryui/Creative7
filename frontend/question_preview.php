<?php
require_once __DIR__ . '/header_kanrisya.php'; //ヘッダー指定
require_once __DIR__ . '/../backend/class.php';
$form = new form();
// 問題idをセッションから取得
session_start();
if (isset($_GET['question_id'])) {
    // postでquestion_idを送った場合は一度セッションに保存する
    $_SESSION['question_id'] = $_GET['question_id'];
}
$question_id = isset($_SESSION['question_id']) ? $_SESSION['question_id'] : [];
echo '<script>console.log('.json_encode(value: $question_id).')</script>';

// 問題のデータを取得する
$list_question = $form->getQuestion(question_id: $question_id); // questionsテーブルからデータを取り出す
$list_choices = $form->getChoices($question_id); // choicesテーブルからデータを取り出す
$list_answers = $form->getAnswer($question_id); // answersテーブルからデータを取り出す
$question_text = $list_question['question_text']; // 問題画像名を
$field_id = $list_question['field_id']; // 言語非言語
if($field_id===1){
    $field_name = "言語";
}elseif($field_id===2){
    $field_name = "非言語";
}else{
    $field_name = "言語非言語";
}
$genre_text = $list_question['genre_text']; // ジャンル名
$interval_num = $list_question['interval_num']; // 制限時間
$sentence = $list_question['sentence']; // 問題文の要約
$explanation = $list_answers['explanation']; // 解説画像名
$correct_choice_id = $list_answers['correct_choice_id']; // 正解のid

$question_img= "../image/問題集/" . $question_text . ".jpg";
$explanation_img = "../image/解説/" . $explanation . ".jpg";
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題表</title>
    <link rel="stylesheet" href="../css/question_preview.css">
</head>
    <body>
        <p class="language">選択言語:</p>
        <p class="genre_name">ジャンル名:</p>
        <p class="interval_time">制限時間:</p>
        <p class="summary">要約文:</p>
        <a href="question_list.php" class="question_list">問題一覧</a>
        <?php
        echo '<p class="choice">'.$field_name.'</p>'; // 言語非言語
        echo '<p class="genre">'.$genre_text.'</p>'; // ジャンル名(二語の関係など)
        echo '<p class="interval">'.$interval_num.'</p>'; // 制限時間
        echo '<p class="sentence">'.$sentence.'</p>'; // 問題の要約文
        echo '<img src="' . $question_img . '" alt="問題画像"  class="question_image">';
        echo '<img src="' . $explanation_img . '" alt="解説画像" class="explanation_image">';
        foreach ($list_choices as $choice_id => $choice_text) { // 選択肢を繰り返し処理で表示
            if ($choice_id == $correct_choice_id) {
                // 正しい選択肢だけ強調表示
                echo "<p class='correct-choice'>$choice_text</p>";
            } else {
                echo "<p  class='correct-choice1'>$choice_text</p>";
            }
        }
        ?>
</div>
    </body>
</html>
