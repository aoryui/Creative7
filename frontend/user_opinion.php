<!DOCTYPE html>
<html lang="ja">
<?php
require_once __DIR__ . '/header_kanrisya.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Googleスプレッドシートの表示</title>
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            margin-top: 20px;
        }
        iframe {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 8px;
            margin-top: 10px;
        }
        .btn-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: rgb(84, 196, 99);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1></h1>
    <h1></h1>
    <h1></h1>
    <h1>スプレットシート内容</h1>
    <div class="container">
        <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQWTdWjVhp7m51ffHyy8OFP3lRyXVyNrCNL8HHw4pn_gsxqLciBexJxWnkhX3hCEVDIh6e5F-VGGvlX/pubhtml?widget=true&amp;headers=false"
                allowfullscreen>
        </iframe>
    </div>
    <a href="https://docs.google.com/spreadsheets/d/1Cfi4TYYUqbFLIR3OfGuDXDXQDhRqsLxzeFNw1j36_oE/edit?usp=sharing" class="btn-link">
        削除はこちら
    </a>
</body>
</html>

