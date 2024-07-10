<?php
require_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
    <link rel="stylesheet" href="../css/genre_selection.css">
</head>
<body>
    <div class="border-frame">
        <div class="container">
            <div class="categorie-box">
                <div class="categorie">
                    <ul>
                        <li><label><input type="radio" name="language" value="二語の関係"> 二語の関係</label></li>
                        <li><label><input type="radio" name="language" value="文章整序"> 文章整序</label></li>
                        <li><label><input type="radio" name="language" value="空欄補充"> 空欄補充</label></li>
                        <li><label><input type="radio" name="language" value="語句の意味"> 語句の意味</label></li>
                        <li><label><input type="radio" name="language" value="語句の用法"> 語句の用法</label></li>
                    </ul>
                </div>
            </div>
            <div class="categorie-boxes">
                <div class="categorie">
                    <ul>
                        <li><label><input type="radio" name="non-language" value="速度の計算"> 速度の計算</label></li>
                        <li><label><input type="radio" name="non-language" value="確率の計算"> 確率の計算</label></li>
                        <li><label><input type="radio" name="non-language" value="税率の計算"> 税率の計算</label></li>
                        <li><label><input type="radio" name="non-language" value="濃度の計算"> 濃度の計算</label></li>
                        <li><label><input type="radio" name="non-language" value="表計算"> 表計算</label></li>
                    </ul>
                </div>
            </div>
        </div>
        <button class="start-button" onclick="startQuiz()">スタート</button>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const radioButtons = document.querySelectorAll('input[type="radio"]');
            radioButtons.forEach(radio => {
                radio.addEventListener('click', function() {
                    if (this.previousChecked) {
                        this.checked = false;
                        this.previousChecked = false;
                    } else {
                        radioButtons.forEach(rb => rb.previousChecked = false);
                        this.previousChecked = true;
                    }
                });
            });
        });

        function startQuiz() {
            const languageInputs = document.querySelectorAll('input[name="language"]');
            const nonLanguageInputs = document.querySelectorAll('input[name="non-language"]');
            let selectedCategory = '';

            // 言語系のラジオボタンが選択されているかチェック
            for (let i = 0; i < languageInputs.length; i++) {
                if (languageInputs[i].checked) {
                    selectedCategory = languageInputs[i].value;
                    break;
                }
            }

            // 非言語系のラジオボタンが選択されているかチェック
            if (!selectedCategory) {
                for (let i = 0; i < nonLanguageInputs.length; i++) {
                    if (nonLanguageInputs[i].checked) {
                        selectedCategory = nonLanguageInputs[i].value;
                        break;
                    }
                }
            }

            // 選択されたカテゴリに基づいて次のページにリダイレクト
            if (selectedCategory) {
                // 次のページのURLを 'quiz.php' と仮定しています。実際のプロジェクトに合わせてこのURLを変更してください。
                window.location.href = 'quiz.php?category=' + encodeURIComponent(selectedCategory);
            } else {
                alert('カテゴリを選択してください');
            }
        }
    </script>
</body>
</html>
