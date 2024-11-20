<?php 
require_once __DIR__ . '/header_kanrisya.php'; //ヘッダー指定
require_once __DIR__ . '/../backend/class.php';
session_start();
$form = new form();
$question_id = isset($_GET['genre']) ? $_GET['genre'] : "1,1";

// カンマで分割して配列に格納
$values = explode(",", $question_id);
$field = $values[0];
$genre = $values[1];

// 該当する全てのデータを取得
$list_questions = $form->getQuestion_fieldgenre($field, $genre);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題表</title>
    <link rel="stylesheet" href="../css/question_list.css">
</head>
<body>
<div class="border-frame">
<a class="btn btn--orange btn--radius" href="question_insert.php">問題作成</a>
<h2 class="question_list">問題リスト</h2>
<form method="GET" action="" class="content-form">
    <select id="genre" name="genre"> 
        <option disabled="disabled">-- 言語 --</option>
        <option value="1,1" <?= $question_id === "1,1" ? 'selected' : ''; ?>>二語の関係</option>
        <option value="1,2" <?= $question_id === "1,2" ? 'selected' : ''; ?>>熟語の意味</option>
        <option value="1,3" <?= $question_id === "1,3" ? 'selected' : ''; ?>>語句の用法</option>
        <option value="1,4" <?= $question_id === "1,4" ? 'selected' : ''; ?>>文章整序</option>
        <option value="1,5" <?= $question_id === "1,5" ? 'selected' : ''; ?>>空欄補充</option>
        <option disabled="disabled">-- 非言語 --</option>
        <option value="2,1" <?= $question_id === "2,1" ? 'selected' : ''; ?>>場合の数</option>
        <option value="2,2" <?= $question_id === "2,2" ? 'selected' : ''; ?>>推論</option>
        <option value="2,3" <?= $question_id === "2,3" ? 'selected' : ''; ?>>割合</option>
        <option value="2,4" <?= $question_id === "2,4" ? 'selected' : ''; ?>>確率</option>
        <option value="2,5" <?= $question_id === "2,5" ? 'selected' : ''; ?>>金額計算</option>
        <option value="2,6" <?= $question_id === "2,6" ? 'selected' : ''; ?>>分担計算</option>
        <option value="2,7" <?= $question_id === "2,7" ? 'selected' : ''; ?>>速度算</option>
        <option value="2,8" <?= $question_id === "2,8" ? 'selected' : ''; ?>>集合</option>
        <option value="2,9" <?= $question_id === "2,9" ? 'selected' : ''; ?>>表の読み取り</option>
        <option value="2,10" <?= $question_id === "2,10" ? 'selected' : ''; ?>>特殊計算</option>
    </select>
    <button type="submit">検索</button>
</form>
<table>
    <thead>
        <tr>
            <th>言語非言語</th>
            <th>ジャンル</th>
            <th>問題文</th>
            <th>編集</th>
            <th>詳細</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_questions as $question): ?>
            <tr>
                <td class="field"><?= $question['field_id'] == 1 ? '言語' : '非言語'; ?></td>
                <td class="genre"><?= htmlspecialchars($question['genre_text']); ?></td>
                <td class="sentence"><?= htmlspecialchars($question['sentence']); ?></td>
                <td class="edit">
                    <a href="question_edit.php?question_id=<?= $question['question_id']; ?>">編集</a>
                </td>
                <td class="link">
                    <a href="question_preview.php?question_id=<?= $question['question_id']; ?>">詳細</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
