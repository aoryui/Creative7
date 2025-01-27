<?php
// ヘッダーの共通部分を読み込む
require_once __DIR__ . '/header.php';
?>
<!DOCTYPE html>
<!-- サインアップ用のCSSスタイルシートをリンク -->
<link rel="stylesheet" href="../css/signup.css">
<link rel="stylesheet" href="../responsive/signup.css">

<!-- ログインページのコンテナ -->
<div class="login-body">
    <div class="login-container">
        <!-- タイトル表示 -->
        <div class="login-ji">
            <h1>新規登録</h1>
        </div>

        <?php
        // サインアップエラーがセッションに設定されていれば、エラーメッセージを表示
        if (isset($_SESSION['signup_error'])) {
            // エラーメッセージを表示し、セッションから削除
            echo '<p class="message-red">' . $_SESSION['signup_error'] . '</p>';
            unset($_SESSION['signup_error']); // メッセージを表示後に削除
        }
        ?>

        <!-- サインアップフォーム -->
        <form action="../backend/touroku.php" method="post" class="form-group">
            
            <!-- ユーザー名入力欄 -->
            <div class="form-group">
                <label for="username" id="usernames">ユーザー名:</label>
                <input type="text" id="username" name="username" required> <!-- 必須項目 -->
            </div>

            <!-- 所属学科選択欄 -->
            <div class="form-group">
                <label for="school" id="schools">所属学科:</label>
                <select id="school" name="school" required> <!-- ドロップダウン選択 -->
                    <option value="">学科を選択</option> <!-- デフォルトで選択される項目 -->
                    <option value="ITエキスパート学科">ITエキスパート学科</option>
                    <option value="ITスペシャリスト学科">ITスペシャリスト学科</option>
                    <option value="情報処理学科">情報処理学科</option>
                    <option value="AIシステム開発学科">AIシステム開発学科</option>
                </select>
            </div>

            <!-- メールアドレス入力欄 -->
            <div class="form-group">
                <label for="address" id="addresses">メールアドレス:</label>
                <input type="email" id="address" name="address" required> <!-- メール形式の入力フィールド -->
            </div>

            <!-- パスワード入力欄 -->
            <div class="form-group">
                <label for="password" id="passwords">パスワード:</label>
                <input type="password" id="password" name="password" required> <!-- パスワード用の入力フィールド -->
            </div>

            <!-- 登録ボタン -->
            <button type="submit" id="submit">登録</button>
        </form>
    </div>
</div>

</body>
</html>
