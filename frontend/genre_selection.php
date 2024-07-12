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
        <label class="language">
        <input type="checkbox" id="genre1" name="language[]" value="1">二語の関係
        </label>
        <label class="language">
        <input type="checkbox" id="genre2" name="language[]" value="2">文章の整序
        </label>

        <!-- 非言語系 -->
         <div class="non_language">
            <input type="checkbox" id="genre3" name="non_language[]" value="1"><label for="genre3">速度の計算</label>
            <input type="checkbox" id="genre4" name="non_language[]" value="2"><label for="genre4">確率の計算</label>
        </div>    
    </div>    
        <button class="next" type="submit">送信</button>
    </form>
    
</body>
</html>
