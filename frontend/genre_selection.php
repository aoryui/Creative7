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
    <div class="flex-inner" data-box-color="white">
        <h2>ジャンルを選択してください</h2>
        
    <form method="post" action="../backend/genre.php"  onsubmit="return validateForm()">
    <!-- 言語系 -->
<fieldset class="contain-left">
    <legend>言語系</legend>
    <div class="select-all-container">
        <input type="checkbox" id="ChecksAllLanguage">
        <label for="ChecksAllLanguage">全選択</label>
    </div>
    <div class="language-list-container">
        <ul class="language-list primary">
            <li><input type="checkbox" class="language-checkbox" id="genre1" name="language[]" value="1">二語の関係</li>
            <li><input type="checkbox" class="language-checkbox" id="genre2" name="language[]" value="2">熟語の意味</li>
            <li><input type="checkbox" class="language-checkbox" id="genre3" name="language[]" value="3">語句の用法</li>
            <li><input type="checkbox" class="language-checkbox" id="genre4" name="language[]" value="4">文章の整序</li>
            <li><input type="checkbox" class="language-checkbox" id="genre5" name="language[]" value="5">空欄の補充</li>
        </ul>
    </div>
</fieldset>

<!-- 非言語系 -->
<fieldset class="contain-right">
    <legend>非言語系</legend>
    <div class="select-all-container">
        <input type="checkbox" id="ChecksAllNonLanguage">
        <label for="ChecksAllNonLanguage">全選択</label>
    </div>
    <div class="non-language-list-container">
        <ul class="non-language-list primary">
            <li><input type="checkbox" class="non-language-checkbox" id="genre6" name="non_language[]" value="1">場合の数</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre7" name="non_language[]" value="2">推論</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre8" name="non_language[]" value="3">割合</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre9" name="non_language[]" value="4">確率</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre10" name="non_language[]" value="5">金額計算</li>
        </ul>
        <ul class="non-language-list secondary">
            <li><input type="checkbox" class="non-language-checkbox" id="genre11" name="non_language[]" value="6">分担計算</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre12" name="non_language[]" value="7">速度算</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre13" name="non_language[]" value="8">集合</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre14" name="non_language[]" value="9">表の読み取り</li>
            <li><input type="checkbox" class="non-language-checkbox" id="genre15" name="non_language[]" value="10">特殊計算</li>
        </ul>
    </div>
</fieldset>
    <button class="button" type="submit">選択</button>
    </form>
    </div>        
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

// フォーム送信時にチェックボックスが選択されているか確認
function validateForm() {
    const languageChecked = document.querySelectorAll('.language-checkbox:checked').length > 0;
    const nonLanguageChecked = document.querySelectorAll('.non-language-checkbox:checked').length > 0;

    if (!languageChecked && !nonLanguageChecked) {
        alert("ジャンルを選択してください");
        return false; // フォーム送信を中止
    }
    return true; // フォーム送信を許可
}
</script>
