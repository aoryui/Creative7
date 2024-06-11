<?php
require_once __DIR__ . '/header.php';

if ($username === "ゲスト") {
    $_SESSION['login_error'] = '成果物を投稿するにログインしてください。';
    header('Location: ' . 'login.php');
    exit();
}
?>

<h1>成果物投稿フォーム</h1>
<p>他の人に見てほしい自分が作成した成果物を投稿するページです。
</p>
<div class="form-container">
    <div class="form-wrapper">
        <form action="insertseika.php" method="POST" enctype="multipart/form-data">
            <label for="title-input">タイトル</label>
            <input type="text" id="title-input" name="title-input" placeholder="タイトルを入力してください" required>
            <label for="message-input">コード</label>
            <textarea id="message-input" name="message-input" placeholder="ここにコードを入力してください"></textarea>
            <label for="site-input">外部サイト</label>
            <input type="text" id="site-input" name="site-input" placeholder="外部サイトなどで公開している場合はここにリンクを入力してください">
            <label for="shosai-input">詳細</label>
            <textarea id="shosai-input" name="shosai-input" placeholder="ここに成果物の詳細を入力してください"></textarea>
            <label for="selection-input">開発言語を選択</label>
            <select id="selection-input" name="selection-input">
                <option value="option1">C言語</option>
                <option value="option2">C#</option>
                <option value="option3">C++</option>
                <option value="option4">Java</option>
                <option value="option5">Python</option>
                <option value="option6">HTML</option>
                <option value="option7">JavaScript</option>
                <option value="option8">SQL</option>
                <option value="option9">CSS</option>
                <option value="option10">PHP</option>
                <option value="option11">その他</option>
            </select>
            <input type="file" name="uploadfile" value="">
            <input type="submit" id="submitButton" value="投稿" onclick="disableButton()" class="form-groupb">
        </form>
    </div>
</div>


</body>

</html>