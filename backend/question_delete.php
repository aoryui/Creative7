<?php
require_once __DIR__ . '/class.php'; // DbDataクラスをインポート
$form = new Form();

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id'])) {
    $question_id = intval($_POST['question_id']); // question_idを取得

    // 画像ファイル名を取得
    $list_question = $form->getQuestion(question_id: $question_id);
    $question_text = $list_question['question_text']; // 問題画像名
    $existing_image_path = "../image/問題集/" . $question_text . ".jpg";

    $answer_data = $form->getAnswer($question_id);
    $answer_text = $answer_data['explanation']; // 問題画像名
    $answer_image_path = "../image/解説/" . $answer_text . ".jpg";

    // データを削除
    $result = $form->deleteQuestion($question_id);
    
    // 画像削除
    if (file_exists($existing_image_path)) {
        unlink($existing_image_path);
    }
    if (file_exists($answer_image_path)) {
        unlink($answer_image_path);
    }

    // 削除結果を表示するページにリダイレクト
    header('Location: ../frontend/question_list.php?message=true');
    exit;
}else{
    header('Location: ../frontend/question_list.php?message=false');
}
?>
