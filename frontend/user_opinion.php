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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffefd5;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
        }
        h1 {
            margin-top: 20px;
            font-size: 2em;
            color: #4CAF50;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
            margin-top: 20px;
        }
        iframe {
            width: 95%;
            height: 330px;
            border: none;
            border-radius: 8px;
        }
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        .btn-link {
            padding: 10px 20px;
            background-color: rgb(84, 196, 99);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            cursor: pointer;
            border: none; /* デフォルトのボーダーを削除 */
            outline: none; /* フォーカス時の黒い枠を削除 */
        }
        .btn-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1></h1>
    <h1></h1>
    <h1>スプレッドシート操作</h1>
    <div class="btn-container">
        <a href="https://docs.google.com/spreadsheets/d/1Cfi4TYYUqbFLIR3OfGuDXDXQDhRqsLxzeFNw1j36_oE/edit?usp=sharing" class="btn-link">
            スプレッドシートを開く
        </a>
        <button class="btn-link" onclick="clearContent()">シートの内容を削除</button>
    </div>
    <div class="container">
        <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQWTdWjVhp7m51ffHyy8OFP3lRyXVyNrCNL8HHw4pn_gsxqLciBexJxWnkhX3hCEVDIh6e5F-VGGvlX/pubhtml?gid=644288189&amp;single=true&amp;widget=true&amp;headers=false">
        </iframe>
    </div>
    <script>
        function clearContent() {
            google.script.run.clearSpreadsheetContent();
            alert("スプレッドシートの内容を削除しました！");
        }
    </script>
</body>
</html>
