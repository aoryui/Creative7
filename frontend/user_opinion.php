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
        /* 基本設定 */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #ffefd5;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* ヘッダー */
        h1 {
            margin-top: 20px;
            font-size: 2rem;
            color: #4CAF50;
            text-align: center;
        }

        /* コンテナ */
        .container {
            width: 90%;
            max-width: 1200px;
            border-radius: 8px;
            margin: 20px 0;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        iframe {
            width: 100%;
            height: 400px;
            border: none;
        }

        /* ボタンエリア */
        .btn-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        /* ボタン */
        .btn-link {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-link:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        .btn-link:active {
            background-color: #388e3c;
            transform: translateY(0);
        }

        button {
        padding: 12px 24px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #4CAF50;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }
        button:hover {
        background-color: #45a049;
        }
        
        /* モバイル対応 */
        @media (max-width: 600px) {
            h1 {
                font-size: 1.5rem;
            }

            .btn-link {
                font-size: 0.9rem;
                padding: 10px 20px;
            }

            iframe {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <h1>スプレッドシート操作</h1>
    <div class="btn-container">
        <!-- スプレッドシートを開くボタン -->
        <a href="https://docs.google.com/spreadsheets/d/1Cfi4TYYUqbFLIR3OfGuDXDXQDhRqsLxzeFNw1j36_oE/edit?usp=sharing" class="btn-link">
            スプレッドシートを開く
        </a>

    <button id="clear-button">シートの内容を削除</button>
    <script>
    document.getElementById("clear-button").addEventListener("click", () => {
      // Apps Script の公開URLを指定
      fetch("https://script.google.com/macros/s/AKfycbxpj_WTzF5GY7DgcTdNcTRdNI69KX7xpFTBiOq7JCQJN-J7IIlHmZT6lorIEzwEYLgz7w/exec") // コピーしたURLを貼り付け
        .then(response => response.text())
        .then(data => alert(data)) // スクリプトからのレスポンスを表示
        .catch(error => console.error("エラー:", error));
    });
  </script>
    </div>

    <div class="container">
        <!-- Googleスプレッドシートの埋め込み -->
        <iframe src="https://docs.google.com/spreadsheets/d/e/2PACX-1vQWTdWjVhp7m51ffHyy8OFP3lRyXVyNrCNL8HHw4pn_gsxqLciBexJxWnkhX3hCEVDIh6e5F-VGGvlX/pubhtml?gid=644288189&amp;single=true&amp;widget=true&amp;headers=false"></iframe>
    </div>
</body>
</html>
