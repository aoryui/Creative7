<?php
// 必要なファイルを読み込む
require_once __DIR__ . '/pre.php'; // 設定ファイルや共通関数など
require_once __DIR__ . '/class.php'; // フォーム処理やユーザー情報取得のクラス
require_once __DIR__ . '/dbdata.php'; // データベース接続情報

// フォームクラスのインスタンスを作成
$form = new form();

// ユーザーIDに基づいてユーザー情報を取得
$info = $form->getInfo($userid);

// POSTリクエストが送信された場合の処理
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // フォームから送信された現在のパスワードと新しいパスワードを取得
    $inputpass = $_POST['old_password'];
    $newPass = $_POST['new_password'];

    // 新しいパスワードをハッシュ化
    $newpasswordhash = password_hash($newPass, PASSWORD_DEFAULT);

    // 現在のパスワードが正しいか確認
    if (password_verify($inputpass, $info['password'])) {
        // パスワードが正しい場合、新しいパスワードを更新
        $form->getpass($userid, $newpasswordhash);

        // 成功メッセージを表示し、マイページにリダイレクト
        echo "パスワードが正常に更新されました。";
        header("Location: ../frontend/mypage.php?message=" . urlencode("パスワードが正常に更新されました"));
        exit();
    } else {
        // パスワードが間違っている場合、エラーメッセージを表示し、パスワード変更ページにリダイレクト
        echo "パスワードが違います";
        header("Location: ../frontend/change_password.php?message=" . urlencode("パスワードが違います"));
        exit();
    }
} else {
    // POSTリクエスト以外の場合、エラーメッセージを表示
    echo "必要なデータが送信されていません。";
}

?>

<!-- HTML部分 -->
<html>
    <head>
        <!-- パスワード変更ページ用のCSSを読み込む -->
        <link rel="stylesheet" href="../css/changepass.css">
    </head>
</html>
