<?php
require_once __DIR__ . '/class.php'; // DbDataクラスをインポート
$form = new Form();

$genre_success = false; // ジャンル保存の成功フラグ
$image_success = false; // 画像アップロードの成功フラグ
$choice_success = false; // 選択肢保存の成功フラグ

// ジャンル
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // JSONデータを受け取る
    $list_data = isset($_POST["list_data"]) ? $_POST["list_data"] : "[]";
    $choice_data = $_POST["choice_data"] ?? "[]"; // 新規選択肢
    $correct = $_POST["correct_data"] ?? null; // 回答

    // JSONをPHPの配列にデコード
    $list = json_decode($list_data, true);
    $choice_list = json_decode($choice_data, true);

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

    // 選択肢保存
    if (is_array($choice_list) && !empty($choice_list) && $correct !== null && isset($list['question_id'])) {
        // 選択肢と正解の更新
        $result = $form->updateChoicesAndAnswer($question_id, $choice_list, $correct);
        if ($result === true) {
            $choice_success = true;
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

// 条件分岐
$message = [
    'genre' => $genre_success ? 'true' : 'false',
    'img' => $image_success ? 'true' : 'false',
    'choice' => $choice_success ? 'true' : 'false'
];

if ($genre_success || $image_success || $choice_success) {
    // 成功したステータスをURLパラメータとして送信
    $query_params = http_build_query(['status' => $message]);
    $redirect_url = '../frontend/question_preview.php?question_id=' . $question_id . '&' . $query_params;
} else {
    // 失敗時は何も送らず編集画面へ
    $redirect_url = '../frontend/question_edit.php?question_id=' . $question_id;
}

// リダイレクト処理
echo "<script>
    window.location.href = '$redirect_url';
</script>";
exit();


?>
