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
    <form method="post" action="../backend/genre.php">
        <input type="checkbox" id="genre1" name="language[]" value="1"><label for="genre1">二語の関係</label>
        <input type="checkbox" id="genre2" name="language[]" value="2"><label for="genre2">文章の整序</label>
        <input type="checkbox" id="genre3" name="non_language[]" value="1"><label for="genre3">速度の計算</label>
        <input type="checkbox" id="genre4" name="non_language[]" value="2"><label for="genre4">確率の計算</label>
        <button type="submit">送信</button>
    </form>
</body>
</html>
