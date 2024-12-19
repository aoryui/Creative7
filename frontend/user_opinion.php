<!DOCTYPE html>
<html lang="ja">
<?php
require_once __DIR__ . '/header_kanrisya.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Googleスプレッドシートの内容</title>
    <meta http-equiv="Cache-Control" content="no-store">
    <link rel="stylesheet" href="../css/user_opinion.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <h1></h1>
    <h1></h1>
    <h1></h1><!-- ヘッダーにかぶらないように -->
    <div class="btn-container">
        <!-- スプレッドシートを開くボタン -->
        <a href="https://docs.google.com/spreadsheets/d/1Cfi4TYYUqbFLIR3OfGuDXDXQDhRqsLxzeFNw1j36_oE/edit?usp=sharing" class="btn-link">
            スプレッドシートを開く
        </a>

        <button id="clear-button">シートの内容を削除</button>
<script>
    document.getElementById("clear-button").addEventListener("click", () => {
    const button = document.getElementById("clear-button");

    // ボタンを無効化
    button.disabled = true;
    button.textContent = "処理中..."; // 処理中の表示を変更する

    // Apps Script の公開URLを指定
    fetch("https://script.google.com/macros/s/AKfycbxYRrCrPA8Nnc8wjqCbh09skG-qCKbwCu8-1dbqosQqDZElASgtpV8VbCbFgOYwJ0An-A/exec")
    .then(response => response.text())
    .then(data => {
    alert(data); // スクリプトからのレスポンスを表示
    button.disabled = false; // ボタンを再び有効化
    button.textContent = "シートの内容を削除(キャッシュクリアしてください)"; // 元の表示に戻す
    })
    .catch(error => {
      console.error("エラー:", error);
      alert("エラーが発生しました。");
      button.disabled = false; // ボタンを再び有効化
      button.textContent = "シートの内容を削除"; // 元の表示に戻す
    });
});
</script>

    </div>

    <div class="container">
        <!-- Googleスプレッドシートの埋め込み -->
        <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQWTdWjVhp7m51ffHyy8OFP3lRyXVyNrCNL8HHw4pn_gsxqLciBexJxWnkhX3hCEVDIh6e5F-VGGvlX/pubhtml?widget=true&amp;headers=false"></iframe>
        <!--スプレッドシートをサーバーに全表示したいときhttps://docs.google.com/spreadsheets/d/1Cfi4TYYUqbFLIR3OfGuDXDXQDhRqsLxzeFNw1j36_oE/edit?usp=sharing-->
    </div>
</body>
</html>