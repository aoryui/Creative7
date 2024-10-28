<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題表</title>
    <style>
        table { /* cssを別ファイルに移しといてください */
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<a href="question_list.php">問題一覧</a>
<h2>問題編集</h2>
<table>
    <tbody>
        <tr>
            <th>&nbsp;</th>
            <th>データ</th>
            <th>更新データ</th>
            <th>編集</th>
        </tr>
        <tr>
            <th>言語非言語</th>
            <th></th>
            <th></th>
            <th><button class="edit" onclick="edit()">編集</button></th>
        </tr>
        <tr>
            <th>ジャンル名</th>
            <th></th>
            <th></th>
            <th><button class="edit" onclick="edit()">編集</button></th>
        </tr>
        <tr>
            <th>問題画像</th>
            <th></th>
            <th></th>
            <th><button class="edit" onclick="edit()">編集</button></th>
        </tr>
        <tr>
            <th>回答画像</th>
            <th></th>
            <th></th>
            <th><button class="edit" onclick="edit()">編集</button></th>
        </tr>
        <tr>
            <th>選択肢</th>
            <th></th>
            <th></th>
            <th><button class="edit" onclick="edit()">編集</button></th>
        </tr>
        <tr>
            <th>制限時間</th>
            <th></th>
            <th></th>
            <th><button class="edit" onclick="edit()">編集</button></th>
        </tr>
        <tr>
            <th>問題文要約</th>
            <th></th>
            <th></th>
            <th><button class="edit" onclick="edit()">編集</button></th>
        </tr>
    </tbody>
</table>


</body>
</html>
