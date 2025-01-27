<?php
session_start(); // セッションを開始

// セッションに格納するためのリストを初期化
$_SESSION['displayed_questions'] = []; // 出題した問題のIDを保存する配列
$_SESSION['selected_choice'] = []; // ユーザーが選択した選択肢のIDを保存する配列
$_SESSION['interval_time'] = []; // 回答にかかった時間を保存する配列
$_SESSION['already_saved'] = false; // 既にデータが保存されているかどうかを判定するフラグ
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"> <!-- 文字エンコーディングを設定 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- レスポンシブデザイン対応 -->
    <link rel="stylesheet" href="../css/teststart.css"> <!-- テストスタートページ用のCSS -->
    <link rel="stylesheet" href="../responsive/teststart.css"> <!-- レスポンシブ対応のCSS -->
</head>
<body>
    <main>
        <div class="container">
            <div class="content">
                <!-- 説明文 -->
                <p>ランダムで想定された問題が10個出題されます。</p>
                <p>時間までに解いてください。</p>
                <p>時間が過ぎると次の問題に自動的に飛ばされます。</p>
                <p>メモ用紙と筆記用具を用意してください。</p>
            </div>
            <div class="button-container">
                <!-- 「模擬試験を開始する」ボタンのフォーム -->
                <form method="post" action="test.php">
                    <!-- セッションデータをフォームの隠しフィールドに保存して送信 -->
                    <input type="hidden" name="displayed_questions" value='<?php echo json_encode($_SESSION['displayed_questions']); ?>'> <!-- 出題された問題のID -->
                    <input type="hidden" name="selected_choice" value='<?php echo json_encode($_SESSION['selected_choice']); ?>'> <!-- ユーザーが選んだ選択肢 -->
                    <input type="hidden" name="interval_time" value='<?php echo json_encode($_SESSION['interval_time']); ?>'> <!-- 回答にかかった時間 -->
                    <input type="hidden" name="already_saved" value='<?php echo json_encode($_SESSION['already_saved']); ?>'> <!-- データが既に保存されているかどうか -->
                    <input class="button" type="submit" value="模擬試験を開始する"> <!-- ボタンの表示 -->
                </form>
            </div>
        </div>
    </main>
</body>
</html>
