<?php
session_start();
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/../backend/class.php';
$form = new Form();

// displayed_questions と current_question_index をセッションから取得
$displayed_questions = isset($_SESSION['displayed_questions']) && is_array($_SESSION['displayed_questions']) ? $_SESSION['displayed_questions'] : [];
$current_question_index = isset($_SESSION['current_question_index']) && is_int($_SESSION['current_question_index']) ? $_SESSION['current_question_index'] : 0;

// 選択した choice_id を取得
$selected_choice = isset($_SESSION['selected_choice']) && is_array($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];

// フォーム送信時の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 選択肢を保存
    if (isset($_POST['choice'])) {
        $choice_id = intval($_POST['choice']);
        $_SESSION['selected_choice'][$current_question_index] = $choice_id;
        $current_question_index++;
        $_SESSION['current_question_index'] = $current_question_index;

        // 全ての問題を回答済みの場合はリダイレクト
        if ($current_question_index >= count($displayed_questions)) {
            $_SESSION['test_display'] = 'practice';
            echo '<script>window.location.href = "rensyu_result.php";</script>';
            exit;
        }
    }

    // ジャンプ処理
    elseif (isset($_POST['go_to_index'])) {
        $go_to_index = intval($_POST['go_to_index']);
        if ($go_to_index >= 0 && $go_to_index < count($displayed_questions)) {
            $current_question_index = $go_to_index;
            $_SESSION['current_question_index'] = $current_question_index;
        }
    }
}

// 現在の question_id を取得
if (isset($displayed_questions[$current_question_index])) {
    $question_id = $displayed_questions[$current_question_index];
} else {
    echo '<script>console.log("問題がありません")</script>';
}

// ログ表示
echo '<script>console.log('.json_encode($displayed_questions).')</script>';
echo '<script>console.log('.json_encode($selected_choice).')</script>';

// questionテーブルから問題データを取得
$question_data = $form->getQuestion($question_id);
// choicesテーブルから選択肢データを取り出す
$choices_data = $form->getChoices($question_id);
echo '<script>console.log('.json_encode($choices_data).')</script>';

// 改行を HTML 改行タグに変換
$question_text = nl2br(htmlspecialchars($question_data['question_text'], ENT_QUOTES, 'UTF-8'));
$genre_text = nl2br(htmlspecialchars($question_data['genre_text'], ENT_QUOTES, 'UTF-8'));

// 最新のセッションデータを取得
$selected_choice = isset($_SESSION['selected_choice']) && is_array($_SESSION['selected_choice']) ? $_SESSION['selected_choice'] : [];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <link rel="stylesheet" href="../css/practice.css">
    <link rel="stylesheet" href="../responsive/practice.css">
</head>
<body>
    <div class="content">
        <button class="open-edit-btn" onclick="openEditModal('nav-modal')">問題メニュー</button>
        <div class="top-contents">
            <?php echo '<div id="question_genre">'.$genre_text.'</div>' ?>
            <?php echo '<div id="question_count">問題数'.($current_question_index+1).'/'.count($displayed_questions).'問目</div>'?>
        </div>

        <div class="center-contents">
            <?php
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            $image_path = "../image/問題集/" . $question_text . ".jpg";
            // HTMLで画像を表示
                $image_path = "../image/問題集/" . $question_text . ".jpg";
            // HTMLで画像を表示
                echo '<img src="' . $image_path . '" alt="問題画像" class="question_img">';
            ?>
            <div id="question_form">
                <form id="choiceForm" method="post" action="practice.php">
                    <div class="choices">
                        <?php
                            foreach ($choices_data as $key => $value) {
                                $checked = isset($_SESSION['selected_choice'][$current_question_index]) && $_SESSION['selected_choice'][$current_question_index] == $key ? 'checked' : '';
                                echo '<div class="choice">';
                                echo '<input type="radio" name="choice" value="' . $key . '" id="option' . $key . '" ' . $checked . '>';
                                echo '<label for="option' . $key . '">' . htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '</label>';
                                echo '</div>';
                            }
                        ?>
                    </div>
                    <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
                </form>
            </div>
            <div class="next">
                <a href="#" class="next-button" id="next-button">次に進む</a>
            </div>
        </div>
    </div>

    <div id="questionModal" class="modal">
        <div class="modal-content">
            
            <span class="close" onclick="closeEditModal('nav-modal')">&times;</span>
            <button type="button" class="button" id="container" onclick="location.href='practice_start.php';">
                開始画面に戻る
            </button>
            <div class="navigation-buttons">
                <?php foreach ($displayed_questions as $index => $question_id): ?>
                    <form method="post" style="display: inline-block;">
                        <input type="hidden" name="go_to_index" value="<?php echo $index; ?>">
                        <button type="submit" class="nav-button 
                            <?php 
                                if (isset($selected_choice[$index]) && $selected_choice[$index] !== 0) {
                                    echo 'answered'; // 回答済み
                                } else {
                                    echo 'not-answered'; // 未回答
                                }
                            ?>" 
                            <?php if ($index == $current_question_index) echo 'disabled'; ?>>
                            <?php echo $index + 1; ?>
                        </button>
                    </form>
                <?php endforeach; ?>

            </div>
            
        </div>
    </div>
    <script>
        function goToNextQuestion() {
            document.getElementById('choiceForm').submit();
        }

        document.getElementById('next-button').addEventListener('click', (e) => {
            e.preventDefault();
            goToNextQuestion();
        });

        document.querySelectorAll('.choice').forEach(choice => { // 選択肢の当たり判定をclass="choice"にも反映
            choice.addEventListener('click', () => {
                const radio = choice.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
            });
        });

        window.addEventListener('load', function() { // ページリロードされたらpracticestart.phpに遷移
            if (performance.navigation.type === 1) {
                window.location.href = 'practice_start.php';
            }
        });

        
        // モーダルを開く関数
        function openEditModal() {
            document.getElementById("questionModal").style.display = "block";
        }

        // モーダルを閉じる関数
        function closeEditModal() {
            document.getElementById("questionModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("questionModal")) {
                closeEditModal();
            }
        }
    </script>
    
</body>
</html>
