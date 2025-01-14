<?php
// 画像のセッションの期限を設定
$now = time();
$now = date('YmdHis');

require_once __DIR__ . '/header_kanrisya.php'; //ヘッダー指定
require_once __DIR__ . '/../backend/class.php';
$form = new form();
// 問題idをセッションから取得
if (isset($_GET['question_id'])) {
    // postでquestion_idを送った場合は一度セッションに保存する
    $_SESSION['question_id'] = $_GET['question_id'];
}
$question_id = isset($_SESSION['question_id']) ? $_SESSION['question_id'] : [];
echo '<script>console.log('.json_encode(value: $question_id).')</script>';

$status = $_GET['status'] ?? null;
$messages = [];

if ($status) {
    // メッセージ配列を生成
    foreach ($status as $key => $value) {
        // keyに基づく表示テキストを定義
        switch ($key) {
            case 'genre':
                $displayText = 'ジャンル名';
                break;
            case 'img':
                $displayText = '問題画像';
                break;
            case 'ans_img':
                $displayText = '解説画像';
                break;
            case 'choice':
                $displayText = '選択肢';
                break;
            case 'interval':
                $displayText = '制限時間';
                break;
            case 'sentence':
                $displayText = '要約文';
                break;
            default:
                $displayText = $key; // その他のキーはそのまま表示
                break;
        }

        // 成功/失敗に応じたスタイルを決定
        $status_class = ($value === 'true') ? 'active' : 'inactive';
        $messages[] = ['text' => $displayText, 'status' => $status_class];
    }
}

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
    <div class="container">
        <p class="language">選択言語: <?php echo $field_name; ?></p>
        <p class="genre_name">ジャンル名: <?php echo $genre_text; ?></p>
        <p class="interval_time">制限時間: <?php echo $interval_num; ?>秒</p>
        <p class="summary">要約文: <?php echo $sentence; ?></p>
    </div>

    <!-- 問題画像表示 -->
    <div class="content">
    <div class="images">
        <img src="<?php echo $question_img; ?>?<?php echo $now; ?>" alt="問題画像" class="question_image">
        <img src="<?php echo $explanation_img; ?>?<?php echo $now; ?>" alt="解説画像" class="explanation_image">
    </div>

    <!-- 選択肢表示 -->
    <fieldset>
    <legend>選択肢</legend>
    <div class="choices">
        <?php
        foreach ($list_choices as $choice_id => $choice_text) {
            if ($choice_id == $correct_choice_id) {
                // 正しい選択肢だけ強調表示
                echo "<p class='correct-choice'>$choice_text</p>";
            } else {
                echo "<p>$choice_text</p>";
            }
        }
        ?>
    </div>
</fieldset>
</div>

<div id="statusModal">
    <div class="modal-content">
        <h2>問題を編集しました！</h2>
        <div id="modalBody">
            <?php if (!empty($messages)): ?>
                <?php foreach ($messages as $message): ?>
                    <p class="<?= $message['status']; ?>"><?= htmlspecialchars($message['text'], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <button class="close-btn" onclick="closeModal()">閉じる</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('statusModal');
        <?php if (!empty($messages)): ?>
        modal.style.display = 'block';
        <?php endif; ?>
    });

    function closeModal() {
        document.getElementById('statusModal').style.display = 'none';
    }

    // モーダル外をクリックすると閉じる
    window.onclick = function(event) {
        const modal = document.getElementById("statusModal");
        if (event.target === modal) {
            modal.style.display = "none";
        }
    };
    
</script>

</body>
</html>
