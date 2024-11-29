<?php
require_once __DIR__ . '/class.php'; // DbDataクラスをインポート
$form = new Form();

$genre_success = false; // ジャンル保存の成功フラグ
$image_success = false; // 画像アップロードの成功フラグ
$image_ans_succsess = false; // 解説画像の成功フラグ
$choice_success = false; // 選択肢保存の成功フラグ
$interval_success = false; // 制限時間保存のフラグ
$sentence_success = false; // 要約文保存のフラグ

// questionsテーブル上書き
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

    // 制限時間保存
    if ($interval_num !== "") {
        $result = $form->updateInterval($question_id, $interval_num);
        if ($result === true) {
            $interval_success = true;
        }
    }
    
    // 要約文保存
    if ($sentence !== "") {
        $result = $form->updateSentence($question_id, $sentence);
        if ($result === true) {
            $sentence_success = true;
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

// 問題画像
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

// 解説画像
$answer_data = $form->getAnswer($question_id);
$answer_text = $answer_data['explanation']; // 問題画像名
$answer_image_path = "../image/解説/" . $answer_text . ".jpg";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image_answer'])) {
    $image = $_FILES['image_answer'];

    if ($image['error'] === UPLOAD_ERR_OK) {
        $uploaded_ansimage_path = "../image/解説/" . $answer_text . ".jpg";
        if (move_uploaded_file($image['tmp_name'], $uploaded_ansimage_path)) {
            $image_ans_succsess = true;
        }
    }
}

// 条件分岐
$message = [
    'genre' => $genre_success ? 'true' : 'false',
    'img' => $image_success ? 'true' : 'false',
    'ans_img' => $image_ans_succsess  ? 'true' : 'false',
    'choice' => $choice_success ? 'true' : 'false',
    'interval' => $interval_success ? 'true' : 'false',
    'sentence' => $sentence_success ? 'true' : 'false'
];

if ($genre_success || $image_success || $choice_success || $image_ans_succsess || $interval_success || $sentence_success) {
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
