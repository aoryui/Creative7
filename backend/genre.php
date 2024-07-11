<?php
session_start(); // セッションを開始する

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $field = [];
    $genres = [];

    // チェックボックスの値を取得
    if (isset($_POST['language'])) {
        foreach ($_POST['language'] as $genre) {
            $field[] = 1;
            $genres[] = intval($genre);
        }
    }

    if (isset($_POST['non_language'])) {
        foreach ($_POST['non_language'] as $genre) {
            $field[] = 2;
            $genres[] = intval($genre);
        }
    }

    $_SESSION['field'] = $field;
    $_SESSION['genre'] = $genres;

    echo '<script>console.log('.json_encode($field).')</script>';
    echo '<script>console.log('.json_encode($genres).')</script>';
    
    // リストを表示
    echo implode(",", $field) . "<br>";
    echo implode(",", $genres);

    // ページをリダイレクト
    header('Location: ../frontend/practicestart.php');
    exit(); // リダイレクト後にスクリプトの実行を停止する
} else {
    echo "POSTリクエストではありません";
}
?>
