<?php
session_start();

// ログアウト状態の場合
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $_SESSION['requested_page'] = $_SERVER['REQUEST_URI']; // リクエストされたページの情報を保存
    header("Location: /../frontend/login.php"); // ログインページにリダイレクト
    exit;
}

// ログイン状態の場合
if(isset($_SESSION['requested_page'])) {
    $requested_page = $_SESSION['requested_page'];
    unset($_SESSION['requested_page']); // リクエストされたページの情報を削除
    header("Location: $requested_page"); // リクエストされたページにリダイレクト
    exit;
}

// リクエストが /member内のファイルであるかどうかを確認
$request_uri = $_SERVER['REQUEST_URI'];
$target_dir = '/member/';
if (strpos($request_uri, $target_dir) !== false) {
    $file_path = $_SERVER['DOCUMENT_ROOT'] . $request_uri;

    // リクエストされたパスがディレクトリである場合、home.php ファイルを表示する
    if (is_dir($file_path)) {
        $index_file_path = rtrim($file_path, '/') . '/home.php';
        if (file_exists($index_file_path) && is_file($index_file_path)) {
            readfile($index_file_path);
            exit;
        } else {
            http_response_code(404);
            echo "home.php ファイルが見つかりません";
            exit;
        }
    }

    // リクエストされたパスがファイルである場合、そのファイルを表示する
    if (file_exists($file_path) && is_file($file_path)) {
        readfile($file_path);
        exit;
    } else {
        http_response_code(404);
        echo "リクエストされたページが見つかりません";
        exit;
    }
} else {
    // /secret ディレクトリ内のファイル以外へのアクセスは拒否する
    http_response_code(403);
    echo "Access Forbidden";
    exit;
}
