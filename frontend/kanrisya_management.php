<?php
// ヘッダーの読み込み。管理者ページ用のヘッダーが含まれていると思われる。
require_once __DIR__ . '/header_kanrisya.php'; 

// formクラスの読み込み（フォーム関連の処理を担当するクラス）
require_once __DIR__ . '/../backend/class.php';
// 管理者用の処理が含まれていると思われるPHPファイル
require_once __DIR__ . '/../backend/kanrisya_pre.php';

// セッションからuseridがセットされている場合、そのユーザーIDを取得
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid']; // セッションIDをuserid変数に代入
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <!-- メタデータの設定。文字コードUTF-8、モバイル対応のviewport設定 -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>テキストから画像へ</title>
    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="../css/kanrisya_management.css">
</head>
<body>
    <!-- 全体の枠組み（ボーダーフレーム） -->
    <div class="border-frame">
        <!-- 中身をフレックスボックスで表示する -->
        <div class="flex-inner" data-box-color="white">
            <!-- 管理者用のタイトル -->
            <h2>利用者管理一覧</h2>
            
            <!-- ユーザー情報一覧へのリンク（画像とテキストで表示） -->
            <a href="kanrisya.php"><img src="../image/icon/kanrisya.png" class="kanrisya" id="png1" alt="ユーザー情報一覧" href="kanrisya.php"></a>
            <a id="text1">ユーザー情報一覧</a>
            
            <!-- 問題一覧へのリンク -->
            <a href="question_list.php"><img src="../image/icon/problem.png" id="png2" alt="問題一覧"></a>
            <a id="text2">問題一覧</a>
            
            <!-- 画像作成へのリンク -->
            <a href="generator_test.php"><img src="../image/icon/test-icon.png" id="png3" alt="画像作成"></a>
            <a id="text3">画像作成</a><br>
            
            <!-- 新規問題作成へのリンク -->
            <a href="question_insert.php"><img src="../image/icon/sinki.png" id="png4" alt="問題作成"></a>
            <a id="text4">問題作成</a>
            
            <!-- ユーザー意見欄へのリンク -->
            <a href="user_opinion.php"><img src="../image/icon/users_6.png" id="png5" alt="ユーザー意見欄"></a>
            <a id="text5">ユーザー意見欄</a>
            
            <!-- アクセス制限設定画面へのリンク -->
            <a href="restrictions.php"><img src="../image/icon/access-lock.png" id="png6" alt="アクセス制限"></a>
            <a id="text6">アクセス制限</a>
        </div>
    </div>
</body>
</html>
