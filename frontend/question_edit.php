<?php
require_once __DIR__ . '/../backend/class.php';
$form = new form();

$question_id = isset($_GET['question_id']) ? $_GET['question_id'] : 1; // GETでquestion_idを取得

// 問題のデータを取得する
$list_question = $form->getQuestion(question_id: $question_id); // questionsテーブルからデータを取り出す
$list_choices = $form->getChoices($question_id); // choicesテーブルからデータを取り出す
$list_answers = $form->getAnswer($question_id); // answersテーブルからデータを取り出す

$question_text = $list_question['question_text']; // 問題画像名を
$genre_text = $list_question['genre_text']; // ジャンル名
$interval_num = $list_question['interval_num']; // 制限時間
$sentence = $list_question['sentence']; // 問題文の要約
$explanation = $list_answers['explanation']; // 解説画像名
$correct_choice_id = $list_answers['correct_choice_id']; // 正解のid


$question_img= "../image/問題集/" . $question_text . ".jpg";
$explanation_img = "../image/解説/" . $explanation . ".jpg";

echo '<script>console.log('.json_encode($list_question).')</script>';
echo '<script>console.log('.json_encode($list_choices).')</script>';
echo '<script>console.log('.json_encode($list_answers).')</script>';

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題表</title>
    <link rel="stylesheet" href="../css/question_edit.css">
</head>
<body>
<a href="question_list.php">問題一覧</a>
<h2>問題編集</h2>
<table>
    <tbody>
        <tr>
            <th>&nbsp;</th>
            <th>データ</th>
            <th>更新データ</th>
            <th>編集</th>
        </tr>
        <tr>
            <th>ジャンル名</th>
            <td data-original-genre="<?php echo $genre_text; ?>"><?php echo "<p>".$genre_text."</p>"?></td>
            <td id="updatedGenre">&nbsp;</td>
            <td><button onclick="openModal('modal1')">編集</button></td>
        </tr>

        <tr>
            <th>問題画像</th>
            <td><img src="<?php echo $question_img; ?>" alt="問題画像"></td>
            <td><img id="preview1" class="preview1" src="#" alt="プレビュー" style="display: none;"></td>
            <td><button onclick="openModal('modal2')">編集</button></td>
        </tr>
        <tr>
            <th>回答画像</th>
            <td><img src="<?php echo $explanation_img; ?>" alt="解説画像"></td>
            <td><img id="preview2" class="preview2" src="#" alt="プレビュー" style="display: none;"></td>
            <td><button onclick="openModal('modal3')">編集</button></td>
        </tr>
        <tr>
            <th>選択肢</th>
            <td>
                <?php
                    foreach ($list_choices as $choice_id => $choice_text) { // 選択肢を繰り返し処理で表示
                        if ($choice_id == $correct_choice_id) {
                            // 正しい選択肢だけ強調表示
                            echo "<p class='correct-choice'>$choice_text</p>";
                        } else {
                            echo "<p>$choice_text</p>";
                        }
                    }
                ?>
            </td>
            <td id="updatedChoices">&nbsp;</td>
            <td><button onclick="openModal('modal4')">編集</button></td>
        </tr>
        <tr>
            <th>制限時間</th>
            <td><?php echo "<p>".$interval_num."</p>" ?></td>
            <td id="updatedIntervalNum">&nbsp;</td>
            <td><button onclick="openModal('modal5')">編集</button></td>
        </tr>
        <tr>
            <th>問題の要約文</th>
            <td data-original-sentence="<?php echo $sentence; ?>"><?php echo "<p>".$sentence."</p>" ?></td>
            <td id="updatedSentence">&nbsp;</td>
            <td><button onclick="openModal('modal6')">編集</button></td>
        </tr>
    </tbody>
</table>
<button>問題を更新</button>
<!-- モーダル -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal1')">&times;</span>
        <h2>ジャンル名を編集</h2>
        <form id="genre_form">
            <fieldset>
                <legend>言語</legend>
                <div>
                    <input type="radio" id="lang_1" name="field" value="1_1" required <?php if ($genre_text == '二語の関係') echo 'checked'; ?> />
                    <label for="lang_1">二語の関係</label>

                    <input type="radio" id="lang_2" name="field" value="1_2" required <?php if ($genre_text == '語句の意味') echo 'checked'; ?> />
                    <label for="lang_2">語句の意味</label>

                    <input type="radio" id="lang_3" name="field" value="1_3" required <?php if ($genre_text == '語句の用法') echo 'checked'; ?> />
                    <label for="lang_3">語句の用法</label>
                    
                    <input type="radio" id="lang_4" name="field" value="1_4" required <?php if ($genre_text == '文章整序') echo 'checked'; ?> />
                    <label for="lang_4">文章整序</label>

                    <input type="radio" id="lang_5" name="field" value="1_5" required <?php if ($genre_text == '空欄補充') echo 'checked'; ?> />
                    <label for="lang_5">空欄補充</label>
                </div>
            </fieldset>
            <fieldset>
                <legend>非言語</legend>
                <div>
                    <input type="radio" id="non-lang_1" name="field" value="2_1" required <?php if ($genre_text == '場合の数') echo 'checked'; ?> />
                    <label for="non-lang_1">場合の数</label>

                    <input type="radio" id="non-lang_2" name="field" value="2_2" required <?php if ($genre_text == '推論') echo 'checked'; ?> />
                    <label for="non-lang_2">推論</label>

                    <input type="radio" id="non-lang_3" name="field" value="2_3" required <?php if ($genre_text == '割合') echo 'checked'; ?> />
                    <label for="non-lang_3">割合</label>

                    <input type="radio" id="non-lang_4" name="field" value="2_4" required <?php if ($genre_text == '確率') echo 'checked'; ?> />
                    <label for="non-lang_4">確率</label>

                    <input type="radio" id="non-lang_5" name="field" value="2_5" required <?php if ($genre_text == '金額計算') echo 'checked'; ?> />
                    <label for="non-lang_5">金額計算</label>

                    <input type="radio" id="non-lang_6" name="field" value="2_6" required <?php if ($genre_text == '分担計算') echo 'checked'; ?> />
                    <label for="non-lang_6">分担計算</label>

                    <input type="radio" id="non-lang_7" name="field" value="2_7" required <?php if ($genre_text == '速度算') echo 'checked'; ?> />
                    <label for="non-lang_7">速度算</label>

                    <input type="radio" id="non-lang_8" name="field" value="2_8" required <?php if ($genre_text == '集合') echo 'checked'; ?> />
                    <label for="non-lang_8">集合</label>

                    <input type="radio" id="non-lang_9" name="field" value="2_9" required <?php if ($genre_text == '表の読み取り') echo 'checked'; ?> />
                    <label for="non-lang_9">表の読み取り</label>

                    <input type="radio" id="non-lang_10" name="field" value="2_10" required <?php if ($genre_text == '特殊計算') echo 'checked'; ?> />
                    <label for="non-lang_10">特殊計算</label>
                </div>
            </fieldset>
            <input type="hidden" name="genre_name" id="genre_name" />
            <input type="submit" value="決定">
        </form>
        
    </div>
</div>

<div id="modal2" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal2')">&times;</span>
        <h2>問題画像を編集</h2>
        <form id="imageFormQuestion">
            <label for="imageInputQuestion">問題の画像を選択:</label>
            <input type="file" name="image" id="imageInputQuestion" accept=".jpg" required>
            <input type="submit" value="決定">
        </form>
    </div>
</div>

<div id="modal3" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal3')">&times;</span>
        <h2>回答画像を編集</h2>
        <form id="imageFormExplanation">
            <label for="imageInputExplanation">解説の画像を選択:</label>
            <input type="file" name="image" id="imageInputExplanation" accept=".jpg" required>
            <input type="submit" value="決定">
        </form>
    </div>
</div>

<div id="modal4" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal4')">&times;</span>
        <h2>選択肢を編集</h2>
        <form id="choicesForm">
            <div id="choice">
                <div class="choice">
                    <input type="radio" name="correct" value="0" required>
                    <input type="text" name="choice[]" placeholder="選択肢 A" required>
                </div>
                <div class="choice">
                    <input type="radio" name="correct" value="1" required>
                    <input type="text" name="choice[]" placeholder="選択肢 B" required>
                </div>
                <div class="choice">
                    <input type="radio" name="correct" value="2" required>
                    <input type="text" name="choice[]" placeholder="選択肢 C" required>
                </div>
                <div class="choice">
                    <input type="radio" name="correct" value="3" required>
                    <input type="text" name="choice[]" placeholder="選択肢 D" required>
                </div>
                <div class="choice">
                    <input type="radio" name="correct" value="4" required>
                    <input type="text" name="choice[]" placeholder="選択肢 E" required>
                </div>
                <div class="choice">
                    <input type="radio" name="correct" value="5" required>
                    <input type="text" name="choice[]" placeholder="選択肢 F" required>
                </div>
            </div>
            <button type="button" onclick="addChoice()">選択肢を追加</button>
            <button type="button" onclick="removeChoice()">選択肢を削除</button><br>
            <input type="submit" value="決定">
        </form>
    </div>
</div>

<div id="modal5" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal5')">&times;</span>
        <h2 for="time_limit">制限時間を入力（秒）:</h2>
        <form id="timesForm">
            <input type="number" id="time_limit" name="time_limit" min="1" value="30" required>
            <input type="submit" value="決定">
        </form>
    </div>
</div>

<div id="modal6" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal6')">&times;</span>
        <h2>問題の要約文を編集</h2>
        <form id="sentenceForm">
            <input type="text" id="sentence" name="sentence" maxlength="20" required><br>
            <input type="submit" value="決定">
        </form>
    </div>
</div>

<script>
    // モーダルを開く
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    // モーダルを閉じる
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // モーダル外をクリックすると閉じる
    window.onclick = function(event) {
        const modals = document.getElementsByClassName("modal");
        for (let modal of modals) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }

    // ジャンル変更
    document.getElementById('genre_form').addEventListener('submit', function(event) {
        event.preventDefault(); // form送信をしない
        const selectedRadio = document.querySelector('input[name="field"]:checked');
        if (selectedRadio) {
            const label = document.querySelector(`label[for="${selectedRadio.id}"]`);
            const selectedGenreText = label.textContent;
            const originalGenreText = document.querySelector('td[data-original-genre]').getAttribute('data-original-genre');

            // 更新前と同じデータなら更新データを消す
            if (selectedGenreText === originalGenreText) {
                document.getElementById('updatedGenre').innerHTML = '&nbsp;';
            } else {
                document.getElementById('updatedGenre').innerHTML = `<p>${selectedGenreText}</p>`;
            }

            document.getElementById('genre_name').value = selectedGenreText;
            closeModal('modal1'); // モーダルを閉じる
        }
        
    });

    // 問題画像のプレビュー表示
    document.getElementById('imageInputQuestion').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview1');
                preview.src = e.target.result;
                preview.style.display = 'block'; // プレビュー画像を表示
            };
            reader.readAsDataURL(file);
        }
    });

    // フォーム送信の処理
    document.getElementById('imageFormQuestion').addEventListener('submit', function(event) {
        event.preventDefault(); // フォーム送信を防ぐ
        closeModal('modal2'); // モーダルを閉じる
    });

    // 解説画像のプレビュー表示
    document.getElementById('imageInputExplanation').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview2');
                preview.src = e.target.result;
                preview.style.display = 'block'; // プレビュー画像を表示
            };
            reader.readAsDataURL(file);
        }
    });

    // フォーム送信の処理
    document.getElementById('imageFormExplanation').addEventListener('submit', function(event) {
        event.preventDefault(); // フォーム送信を防ぐ
        closeModal('modal3'); // モーダルを閉じる
    });

    function addChoice() {
        const optionsDiv = document.getElementById("choice");
        const optionCount = optionsDiv.getElementsByClassName("choice").length;
        const placeholderLetter = String.fromCharCode(65 + optionCount);

        const newOption = document.createElement("div");
        newOption.className = "choice";
        newOption.innerHTML = `<input type="radio" name="correct" value="${optionCount}" required>
                            <input type="text" name="choice[]" placeholder="選択肢 ${placeholderLetter}" required>`;

        if (optionCount < 11) {
            optionsDiv.appendChild(newOption);
        }
    }

    function removeChoice() {
        const optionsDiv = document.getElementById("choice");
        const optionCount = optionsDiv.getElementsByClassName("choice").length;

        if (optionCount > 1) {
            optionsDiv.removeChild(optionsDiv.lastElementChild);
        }
    }

    document.getElementById('choicesForm').addEventListener('submit', function(event) {
        event.preventDefault(); // フォーム送信を防ぐ

        const choiceElements = document.querySelectorAll('#choice .choice');
        const updatedChoices = document.getElementById('updatedChoices');
        updatedChoices.innerHTML = ''; // 既存のデータを消去する
        choiceElements.forEach((choiceElement, index) => {
            const isCorrect = choiceElement.querySelector('input[type="radio"]').checked;
            const choiceText = choiceElement.querySelector('input[type="text"]').value;

            // 正解の選択肢を強調する
            const choiceDisplay = document.createElement('p');
            choiceDisplay.className = isCorrect ? 'correct-choice' : '';
            choiceDisplay.textContent = choiceText;

            // 更新された選択肢コンテナに選択肢表示を追加する
            updatedChoices.appendChild(choiceDisplay);
        });

        closeModal('modal4'); // モーダルを閉じる
    });

    // 元の制限時間を取得
    const originalIntervalNum = <?php echo json_encode($interval_num); ?>;

    // 制限時間フォームのイベントリスナー
    document.getElementById('timesForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent form submission

        // 入力された制限時間を取得
        const newTimeLimit = document.getElementById('time_limit').value;
        const updatedTimeLimitElement = document.getElementById('updatedIntervalNum');

        // データベースの数値と比較する
        if (newTimeLimit != originalIntervalNum) {
            updatedTimeLimitElement.innerHTML = `<p>${newTimeLimit}</p>`; // 数値が新し場合表示
        } else {
            updatedTimeLimitElement.innerHTML = '&nbsp;'; // 元のデータと同じ場合表示させない
        }

        closeModal('modal5'); // モーダルを閉じる
    });

    // 元の要約文を取得
    const originalSentence = <?php echo json_encode($sentence); ?>;

    // 問題の要約文のフォームのイベントリスナー
    document.getElementById('sentenceForm').addEventListener('submit', function(event) {
        event.preventDefault(); // フォーム送信を防ぐ

        // 入力された新しい要約文を取得
        const newSentence = document.getElementById('sentence').value;
        const updatedSentenceElement = document.getElementById('updatedSentence');

        // オリジナルの要約文と比較し、更新があれば表示
        if (newSentence !== originalSentence) {
            updatedSentenceElement.innerHTML = `<p>${newSentence}</p>`; // 新しい要約文を表示
        } else {
            updatedSentenceElement.innerHTML = '&nbsp;'; // 元のデータと同じ場合は空白
        }

        closeModal('modal6'); // モーダルを閉じる
    });


</script>
</body>
</html>
