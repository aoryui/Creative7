<?php
// 必要なファイルを読み込む
require_once __DIR__ . '/header.php'; // ヘッダー部分を読み込む
require_once __DIR__ . '/../backend/class.php'; // 必要なクラス定義を含むファイルを読み込む

// $kaisetuID を最初に取得 (GETパラメータから取得)
$kaisetuID = isset($_GET['question_id']) ? $_GET['question_id'] : null; // パラメータが無い場合はnullを設定

// セッションから開いたページのファイル名を取得
$before_display = isset($_SESSION['result_display']) ? $_SESSION['result_display'] : []; // 表示するページ情報を取得

// セッションから選択肢と正解の情報を取得
$displayed_questions = isset($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : []; // 表示した問題情報
$selected_choices = isset($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : []; // ユーザーが選択した選択肢
$correct_choices = isset($_SESSION['correct_choices']) ? $_SESSION['correct_choices'] : []; // 正しい選択肢
echo '<script>console.log('.json_encode($displayed_questions).')</script>'; // デバッグ用の情報をコンソールに出力
echo '<script>console.log('.json_encode($selected_choices).')</script>';
echo '<script>console.log('.json_encode($correct_choices).')</script>';

// ユーザーの回答と正解の選択肢IDを取得
$question_num = $displayed_questions[$kaisetuID]; // 現在の問題番号
$user_choice_id = isset($selected_choices[$kaisetuID]) ? $selected_choices[$kaisetuID] : 'N/A'; // ユーザーの回答
$correct_choice_id = isset($correct_choices[$kaisetuID]) ? $correct_choices[$kaisetuID] : 'N/A'; // 正しい回答
echo '<script>console.log('.json_encode($user_choice_id).')</script>'; // デバッグ用
echo '<script>console.log('.json_encode($correct_choice_id).')</script>';

// formクラスのインスタンスを生成し、データを取得
$form = new form();
$list_choices = $form->getChoices($question_num); // `choices`テーブルから選択肢データを取得
$kaisetu = $form->getQuestion($question_num); // `question`テーブルから問題データを取得

echo '<script>console.log('.json_encode($list_choices).')</script>'; // デバッグ用
echo '<script>console.log("あ",'.json_encode($user_choice_id).')</script>';

// ユーザーが選択した選択肢のテキストを取得
if ($user_choice_id === 0 || $user_choice_id === "0") { // 無回答の場合
    $user_choice_text = '無回答';
} else {
    $user_choice_text = $list_choices[$user_choice_id]; // 選択肢のテキストを取得
}

$correct_choice_text = $list_choices[$correct_choice_id]; // 正しい選択肢のテキストを取得

// 復習ページから表示した場合は自分の回答を非表示にする
$display_user_choice = !($before_display === 'review' && $user_choice_text === '無回答'); // 復習時の無回答を判定
$_SESSION['test_display'] = ''; // test_displayを初期化

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>回答と解説画面</title> <!-- ページタイトル -->
    <!-- CSSの読み込み -->
    <link rel="stylesheet" href="../css/kaitoukaisetu.css"> <!-- PC用CSS -->
    <link rel="stylesheet" href="../responsive/kaitoukaisetu.css"> <!-- レスポンシブ用CSS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const result = urlParams.get('result'); // URLから`result`パラメータを取得
            const modal = document.getElementById('resultModal'); // モーダル要素を取得
            const modalContent = document.getElementById('modalContent'); // モーダルの内容要素を取得
            const modalImage = document.getElementById('modalImage'); // モーダル内の画像要素を取得
            const closeButton = document.getElementById('closeModal'); // モーダルを閉じるボタン

            // モーダルを表示する関数
            function showModal(message, imageSrc) {
                modalContent.textContent = message;
                modalImage.src = imageSrc;
                modal.style.display = 'block';
            }

            // 結果に応じてモーダルを表示
            setTimeout(function() {
                if (result === 'correct') { // 正解の場合
                    showModal("正解です！", "../image/icon/true.png");
                } else if (result === 'incorrect') { // 不正解の場合
                    showModal("不正解です！", "../image/icon/false.png");
                }
            }, 500);

            // モーダルを閉じる処理
            closeButton.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // 背景クリックでモーダルを閉じる
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
    </script>
</head>
<body>
    <!-- モーダルのHTML -->
    <div id="resultModal" class="modal">
        <div class="modal-content">
            <span id="closeModal" class="close-btn">&times;</span> <!-- モーダル閉じるボタン -->
            <h2 id="modalContent"></h2> <!-- モーダルメッセージ -->
            <img id="modalImage" class="modal-image" src="" alt="結果画像"> <!-- 結果画像 -->
        </div>
    </div>

    <div class="top-contents">
        <b>ジャンル:</b>
        <span><?php echo htmlspecialchars($kaisetu['genre_text'], ENT_QUOTES, 'UTF-8'); ?></span> <!-- ジャンルを表示 -->
    </div>
    <div class="center-contents">
        <div class="img-contents">
            <div>
                <h2>問題</h2>
                <?php
                $image_path1 = "../image/問題集/" . $kaisetu['question_text'] . ".jpg"; // 問題画像パスを作成
                echo '<img src="' . $image_path1 . '" alt="問題画像" class="question_img">'; // 画像を表示
                ?>
            </div>
            <div>
                <h2>解説</h2>
                <?php
                $image_path = "../image/解説/" .$kaisetu['question_text'] . ".jpg"; // 解説画像パスを作成
                echo '<img src="' . $image_path . '" alt="解説画像" class="answer_img">'; // 画像を表示
                ?>
            </div>
        </div>

        <div class="kaitou">
            <h3>回答</h3>
            <?php
            foreach ($list_choices as $choice_id => $choice_text) { // 選択肢をループで表示
                $id_attribute = ($choice_id == $user_choice_id) ? ' id="user-choice"' : ''; // ユーザーの選択肢にIDを付与
                if ($choice_id == $correct_choice_id) {
                    echo "<p class='correct-choice'$id_attribute>$choice_text</p>"; // 正しい選択肢
                } else {
                    echo "<p class='correct-choice1'$id_attribute>$choice_text</p>"; // 他の選択肢
                }
            }
            ?>
            <?php if ($display_user_choice) : ?> <!-- ユーザーの回答を表示 -->
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
            <a href="review.php" class="btn">復習問題一覧に戻る</a> <!-- 復習ページのリンク -->
        <?php elseif ($before_display === 'honban') : ?>
            <a href="honban_result.php" class="btn">本番ページに戻る</a> <!-- 本番ページのリンク -->
        <?php elseif ($before_display === 'rensyu') : ?>
            <a href="rensyu_result.php" class="btn">練習ページに戻る</a> <!-- 練習ページのリンク -->
        <?php elseif ($before_display === 'ranking') : ?>
            <a href="question_ranking.php" class="btn">ランキングページに戻る</a> <!-- ランキングページのリンク -->
        <?php else : ?>
            <a href="<?php echo htmlspecialchars($before_display, ENT_QUOTES, 'UTF-8'); ?>.php" class="btn">リザルトに戻る</a> <!-- その他リザルトページのリンク -->
        <?php endif; ?>
    </div>
</body>
</html>
