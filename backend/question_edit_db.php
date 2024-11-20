<?php
require_once __DIR__ . '/class.php'; // DbDataクラスをインポート
$form = new Form();

$genre_success = false; // ジャンル保存の成功フラグ
$image_success = false; // 画像アップロードの成功フラグ

// ジャンル
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // JSONデータを受け取る
    $list_data = isset($_POST["list_data"]) ? $_POST["list_data"] : "[]";
    
    // JSONをPHPの配列にデコード
    $list = json_decode($list_data, true);
    echo '<script>console.log('.json_encode($list).')</script>';

    $question_id = $list['question_id']; // 問題id
    $field_id = $list['field_id']; // 言語非言語
    $genre_id = $list['genre_id']; // ジャンルid
    $genre_text = $list['genre_text']; // ジャンル名
    $interval_num = $list['interval_num']; // 制限時間
    $question_text = $list['question_text']; // 問題文
    $sentence = $list['sentence']; // 要約文

    // ジャンル保存
    if ($field_id !== "" && $genre_id !== "" && $genre_text !== "") {
        $result = $form->updateGenre($question_id, $field_id, $genre_id, $genre_text);
        if ($result === true) {
            $genre_success = true;
        }
    }
}

// 画像
$list_question = $form->getQuestion(question_id: $question_id);
$question_text = $list_question['question_text']; // 問題画像名
$existing_image_path = "../image/問題集/" . $question_text . ".jpg";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $image = $_FILES['image'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $uploaded_image_path = "../image/問題集/" . $question_text . ".jpg";
        if (move_uploaded_file($image['tmp_name'], $uploaded_image_path)) {
            $image_success = true;
        }
    }
}
echo '<script>console.log('.json_encode($question_id).')</script>';
// 条件分岐
if ($genre_success && $image_success) {
    echo "<script>
        alert('ジャンルと画像を保存しました');
        window.location.href = '../frontend/question_preview.php?question_id=" . $question_id . "';
    </script>";
    exit();
} elseif ($genre_success && !$image_success) {
    echo "<script>
        alert('ジャンル保存は成功しましたが、画像のアップロードに失敗しました');
        window.location.href = '../frontend/question_preview.php?question_id=" . $question_id . "';
    </script>";
    exit();
} elseif (!$genre_success && $image_success) {
    echo "<script>
        alert('ジャンル保存に失敗しましたが、画像は正常にアップロードされました');
        window.location.href = '../frontend/question_preview.php?question_id=" . $question_id . "';
    </script>";
    exit();
} else {
    echo "<script>
        alert('ジャンル保存と画像アップロードの両方が失敗しました');
        window.location.href = '../frontend/question_edit.php?question_id=" . $question_id . "';
    </script>";
    exit();
}



?>
