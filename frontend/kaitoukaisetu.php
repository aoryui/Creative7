<?php
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';

// $kaisetuID を最初に取得
$kaisetuID = isset($_GET['question_id']) ? $_GET['question_id'] : null;

// セッションから開いたページのファイル名を取得
$before_display = isset($_SESSION['result_display']) ? $_SESSION['result_display'] : [];

// セッションから選択肢と正解の情報を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : [];
echo '<script>console.log('.json_encode($displayed_questions).')</script>';
echo '<script>console.log('.json_encode($selected_choices).')</script>';
echo '<script>console.log('.json_encode($correct_choices).')</script>';

// ユーザーの回答と正解の選択肢IDを取得
$question_num = $displayed_questions[$kaisetuID];
$user_choice_id = isset($selected_choices[$kaisetuID]) ? $selected_choices[$kaisetuID] : 'N/A';
$correct_choice_id = isset($correct_choices[$kaisetuID]) ? $correct_choices[$kaisetuID] : 'N/A';
echo '<script>console.log('.json_encode($user_choice_id).')</script>';
echo '<script>console.log('.json_encode($correct_choice_id).')</script>';

$form = new form();
$list_choices = $form->getChoices($question_num); // choicesテーブルから選択肢データを全て取り出す
$kaisetu = $form->getQuestion($question_num); // questionテーブルから問題データを全て取り出す

echo '<script>console.log('.json_encode($list_choices).')</script>';
echo '<script>console.log("あ",'.json_encode($user_choice_id).')</script>';

// ユーザーが選択した選択肢のテキストを取得
if($user_choice_id === 0 || $user_choice_id === "0"){ // choice_idが0の場合(無回答)
    $user_choice_text = '無回答';
}else{
    $user_choice_text = $list_choices[$user_choice_id];
}

$correct_choice_text = $list_choices[$correct_choice_id];

// 復習ページから表示した場合は自分の回答を非表示にする
$display_user_choice = !($before_display === 'review' && $user_choice_text === '無回答');
$_SESSION['test_display'] = ''; //test_displayを初期化

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>回答と解説画面</title>
    <link rel="stylesheet" href="../css/kaitoukaisetu.css">
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const result = urlParams.get('result');
            setTimeout(function() {
                if (result === 'correct') {
                    alert("正解です！");
                } else if (result === 'incorrect') {
                    alert("不正解です！");
                }
            }, 500); // 500ミリ秒 (0.5秒) 後にアラートを表示
        });
    </script>
</head>
<body>
    <div class="top-contents">
        <b>ジャンル:</b>
        <span><?php echo htmlspecialchars($kaisetu['genre_text'], ENT_QUOTES, 'UTF-8'); ?></span>
    </div>
    <div class="center-contents">
        <div class="img-contents">
            <div>
                <h2>問題</h2>
                <?php
                $image_path1 = "../image/問題集/" . $kaisetu['question_text'] . ".jpg";
                //HTMLで画像を表示
                echo '<img src="' . $image_path1 . '" alt="問題画像" class="question_img">';
                ?>
            </div>
            
            <div>
                <h2>解説</h2>
                <?php
                    // 画像のパスを作成
                    $image_path = "../image/解説/" .$kaisetu['question_text'] . ".jpg";
                    // HTMLで画像を表示
                    echo '<img src="' . $image_path . '" alt="問題画像" class="answer_img">';
                ?>
            </div>
        </div>

        <div class="kaitou">
            <h2>回答</h2>
            <?php
            foreach ($list_choices as $choice_id => $choice_text) { // 選択肢を繰り返し処理で表示
                $id_attribute = ($choice_id == $user_choice_id) ? ' id="user-choice"' : ''; // ユーザーの選択肢にid属性を付与
                if ($choice_id == $correct_choice_id) {
                    // 正しい選択肢だけ強調表示
                    echo "<p class='correct-choice'$id_attribute>$choice_text</p>";
                } else {
                    echo "<p class='correct-choice1'$id_attribute>$choice_text</p>";
                }
            }
            ?>
            <?php if ($display_user_choice) : ?> <!-- 復習ページから表示した場合は自分の回答を非表示にする -->               
                <div class="choice-collar">
                あなたの回答
                <div class="choice-preview"></div>
            </div>
            <?php endif; ?>  
            <div class="correct-collar">
                正しい回答
                <div class="color-preview"></div>
            </div>
        </div>

        <?php if ($before_display === 'review') : ?> 
            <a href="review.php" class="btn">復習問題一覧に戻る</a> <!-- 復習ページから開いた場合のボタンテキスト -->
        <?php elseif ($before_display === 'honban') : ?>
            <a href="honban_result.php" class="btn">本番ページに戻る</a> <!-- 本番ページに戻るボタン -->
        <?php elseif ($before_display === 'rensyu') : ?>
            <a href="rensyu_result.php" class="btn">練習ページに戻る</a> <!-- 練習ページに戻るボタン -->
        <?php elseif ($before_display === 'ranking') : ?>
            <a href="question_ranking.php" class="btn">ランキングページに戻る</a> <!-- ランキングページに戻るボタン -->
        <?php else : ?>
            <a href="<?php echo htmlspecialchars($before_display, ENT_QUOTES, 'UTF-8'); ?>.php" class="btn">リザルトに戻る</a>
        <?php endif; ?>
    </div>
</body>
</html>
