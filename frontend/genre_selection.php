<?php
require_once __DIR__ . '/header.php'; //ヘッダー指定
?>

 <!-- html開始 -->
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
    <form method="post" action="../backend/genre.php">
    <!-- 言語系 -->
    <div class="contain">
        <label class="checksAll">
            <input type="checkbox" id="ChecksAllLanguage">言語系
        </label>
        <label class="language">
            <input type="checkbox"  class="language-checkbox" id="genre1" name="language[]" value="1">二語の関係
        </label>
        <label class="language">
            <input type="checkbox"  class="language-checkbox" id="genre2" name="language[]" value="2">文章の整序
        </label>
        <label class="language">
            <input type="checkbox"  class="language-checkbox" id="genre3" name="language[]" value="2">文章の整序
        </label>
        <label class="language">
            <input type="checkbox"  class="language-checkbox" id="genre4" name="language[]" value="2">文章の整序
        </label>
        <label class="language">
            <input type="checkbox"  class="language-checkbox" id="genre5" name="language[]" value="2">文章の整序
        </label>
</div>
    <!-- 非言語系 -->
    <div class="contains">
    <label class="checksAll">
            <input type="checkbox" id="ChecksAllNonLanguage">非言語系
        </label>
        <label class="non_language">
            <input type="checkbox" class="non-language-checkbox" id="genre6" name="non_language[]" value="1">速度の計算
        </label>
        <label class="non_language">
            <input type="checkbox" class="non-language-checkbox" id="genre7" name="non_language[]" value="2">確率の計算
        </label>
        <label class="non_language">
            <input type="checkbox" class="non-language-checkbox" id="genre8" name="non_language[]" value="1">速度の計算
        </label>
        <label class="non_language">
            <input type="checkbox" class="non-language-checkbox" id="genre9" name="non_language[]" value="1">速度の計算
        </label>
        <label class="non_language">
            <input type="checkbox" class="non-language-checkbox" id="genre10" name="non_language[]" value="1">速度の計算
        </label>
        <label class="non_language">
            <input type="checkbox" class="non-language-checkbox" id="genre11" name="non_language[]" value="1">速度の計算
        </label>
        <label class="non_language">
            <input type="checkbox" class="non-language-checkbox" id="genre12" name="non_language[]" value="1">速度の計算
        </label>
    </div>
    <button class="button" type="submit">選択</button>
    </form>
    </div>        
</body>
</html>



<!-- javascript -->
<script>
const checkAllLanguage = document.getElementById("ChecksAllLanguage");
const languageCheckboxes = document.querySelectorAll(".language-checkbox");

const checkAllNonLanguage = document.getElementById("ChecksAllNonLanguage");
const nonLanguageCheckboxes = document.querySelectorAll(".non-language-checkbox");

// 言語系全選択のチェックボックスがクリックされた時
checkAllLanguage.addEventListener('click', () => {
    for (let checkbox of languageCheckboxes) {
        checkbox.checked = checkAllLanguage.checked;
    }
});

// 言語系の個別チェックボックスがクリックされた時
for (let checkbox of languageCheckboxes) {
    checkbox.addEventListener('click', () => {
        if (!checkbox.checked) {
            checkAllLanguage.checked = false;
        } else if (document.querySelectorAll(".language-checkbox:checked").length === languageCheckboxes.length) {
            checkAllLanguage.checked = true;
        }
    });
}

// 非言語系全選択のチェックボックスがクリックされた時
checkAllNonLanguage.addEventListener('click', () => {
    for (let checkbox of nonLanguageCheckboxes) {
        checkbox.checked = checkAllNonLanguage.checked;
    }
});

// 非言語系の個別チェックボックスがクリックされた時
for (let checkbox of nonLanguageCheckboxes) {
    checkbox.addEventListener('click', () => {
        if (!checkbox.checked) {
            checkAllNonLanguage.checked = false;
        } else if (document.querySelectorAll(".non-language-checkbox:checked").length === nonLanguageCheckboxes.length) {
            checkAllNonLanguage.checked = true;
        }
    });
}
</script>