<?php
// 許可されたIPアドレスのリスト
$allowed_ips = ['121.113.92.40'];

// クライアントのIPアドレスを取得
$client_ip = $_SERVER['REMOTE_ADDR'];

// IPアドレスが許可リストに含まれているかチェック
if (!in_array($client_ip, $allowed_ips)) {
    // 含まれていない場合は403エラーページを表示
    header('HTTP/1.1 403 Forbidden');
    echo 'You are not allowed to access this page.';
    exit;
}

// 許可されたIPアドレスの場合のみページの内容を表示
?>