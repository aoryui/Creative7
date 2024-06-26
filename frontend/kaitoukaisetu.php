<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';

// セッションから選択肢と正解の情報を取得
session_start();
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : [];
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];

$kaisetuID = $_GET['question_id'];
$form = new form();
$kaisetu = $form->getQues($kaisetuID);

// ユーザーの回答と正解の選択肢IDを取得
$user_choice_id = isset($selected_choices[$kaisetuID]) ? $selected_choices[$kaisetuID] : 'N/A';
$correct_choice_id = isset($correct_choices[$kaisetuID]) ? $correct_choices[$kaisetuID] : 'N/A';
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>回答と解説画面</title>
    <link rel="stylesheet" href="../css/kaitoukaisetu.css">
</head>
<body>
    <div class="kaisetu1">
        <main>
            <h2>回答</h2>
            <section class="kaitouran">
                <div class="kaitou">
                    <strong>貴方の回答:</strong>
                    <span id="user-kaitou"><?php echo htmlspecialchars($user_choice_id, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div class="kaitou">
                    <strong>正解:</strong>
                    <span id="correct-kaitou"><?php echo htmlspecialchars($correct_choice_id, ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
            </section>
            <h2>解説</h2>
            <section class="kaiseturan">
                <p id="kaisetu">
                    <p><?php
                        // 画像のパスを作成
                        $image_path = "../image/解説/" . $kaisetu['explanation'] . ".jpg";
                        // HTMLで画像を表示
                        echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
                    ?></p>
                </p>
            </section>
            <p><a href="result.php">リザルトに戻る</a></p>
        </main>
    </div>
</body>
</html>
