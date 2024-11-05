<?php
require_once __DIR__ . '/header_kanrisya.php';

// URLからメッセージを取得
$message = isset($_GET['message']) ? $_GET['message'] : '';

// メッセージが空でない場合に表示
if (!empty($message)) {
    echo '<span class="message">' . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . '</span>';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>画像アップロードと問題作成</title>
    <link rel="stylesheet" href="../css/question_insert.css">
</head>
<body>
    <button onclick="location.href='question_list.php'">問題一覧</button>
    <h2 class="text">問題ジャンル選択</h2>
    <form id="questionForm" action="../backend/question_insert_db.php" method="post" enctype="multipart/form-data">
        <fieldset class="language">
            <legend>言語</legend>
            <div>
                <input type="radio" id="lang_1" name="field" value="1_1" required />
                <label for="lang_1">二語の関係</label>

                <input type="radio" id="lang_2" name="field" value="1_2" required />
                <label for="lang_2">語句の意味</label>

                <input type="radio" id="lang_3" name="field" value="1_3" required />
                <label for="lang_3">語句の用法</label>
                
                <input type="radio" id="lang_4" name="field" value="1_4" required />
                <label for="lang_4">文章整序</label>

                <input type="radio" id="lang_5" name="field" value="1_5" required />
                <label for="lang_5">空欄補充</label>
            </div>
        </fieldset>
        <fieldset class="language2">
            <legend>非言語</legend>
            <div">
                <input type="radio" id="non-lang_1" name="field" value="2_1" required />
                <label for="non-lang_1">場合の数</label>

                <input type="radio" id="non-lang_2" name="field" value="2_2" required />
                <label for="non-lang_2">推論</label>

                <input type="radio" id="non-lang_3" name="field" value="2_3" required />
                <label for="non-lang_3">割合</label>

                <input type="radio" id="non-lang_4" name="field" value="2_4" required />
                <label for="non-lang_4">確率</label>

                <input type="radio" id="non-lang_5" name="field" value="2_5" required />
                <label for="non-lang_5">金額計算</label>

                <input type="radio" id="non-lang_6" name="field" value="2_6" required />
                <label for="non-lang_6">分担計算</label>

                <input type="radio" id="non-lang_7" name="field" value="2_7" required />
                <label for="non-lang_7">速度算</label>

                <input type="radio" id="non-lang_8" name="field" value="2_8" required />
                <label for="non-lang_8">集合</label>

                <input type="radio" id="non-lang_9" name="field" value="2_9" required />
                <label for="non-lang_9">表の読み取り</label>

                <input type="radio" id="non-lang_10" name="field" value="2_10" required />
                <label for="non-lang_10">特殊計算</label>
            </div>
        </fieldset>
        <input type="hidden" name="genre_name" id="genre_name" />

        <h2>問題画像</h2>
        <label for="image1">問題の画像を選択:</label>
        <input type="file" name="image1" id="image1" accept=".jpg" required>
        <img id="preview1" class="preview" src="#" alt="プレビュー" style="display: none;">
        <a href="generator_test.php">問題画像を作成</a>
        
        <label for="image2">解説の画像を選択:</label>
        <input type="file" name="image2" id="image2" accept=".jpg" required>
        <img id="preview2" class="preview" src="#" alt="プレビュー" style="display: none;">
        <a href="generator_answer.php">回答画像を作成</a>

        <h2>選択肢</h2>
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

        <h2>制限時間</h2>
        <label for="time_limit">制限時間を入力（秒）:</label>
        <input type="number" id="time_limit" name="time_limit" min="1" value="30" required>

        <h2>問題文の要約(文字数20文字)</h2>
        <input type="text" id="sentence" name="sentence" maxlength="20" required><br>

        <input type="submit" value="問題を作成し画像をアップロード">
    </form>

    <script>
        document.getElementById('questionForm').addEventListener('submit', function(event) {
            const selectedRadio = document.querySelector('input[name="field"]:checked');
            if (selectedRadio) {
                const label = document.querySelector(`label[for="${selectedRadio.id}"]`);
                document.getElementById('genre_name').value = label.textContent;
            }
        });

        function addChoice() {
            const optionsDiv = document.getElementById("choice");
            const optionCount = optionsDiv.getElementsByClassName("choice").length;
            const placeholderLetter = String.fromCharCode(65 + optionCount);

            const newOption = document.createElement("div");
            newOption.className = "choice";
            newOption.innerHTML = `<input type="radio" name="correct" value="${optionCount}" required>
                                <input type="text" name="choice[]" placeholder="選択肢 ${placeholderLetter}" required>`;

            optionsDiv.appendChild(newOption);
        }

        function removeChoice() {
            const optionsDiv = document.getElementById("choice");
            const optionCount = optionsDiv.getElementsByClassName("choice").length;

            if (optionCount > 1) {
                optionsDiv.removeChild(optionsDiv.lastElementChild);
            }
        }

        function previewImage(event, previewId) {
            const preview = document.getElementById(previewId);
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        }

        document.getElementById('image1').addEventListener('change', function(event) {
            previewImage(event, 'preview1');
        });

        document.getElementById('image2').addEventListener('change', function(event) {
            previewImage(event, 'preview2');
        });
    </script>

</body>
</html>
