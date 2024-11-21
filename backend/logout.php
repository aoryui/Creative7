<?php
session_start();

$_SESSION = [];
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 1000, '/');
}
session_destroy();

setcookie("userid", '', time() - 1000, '/');
setcookie("userName", '', time() - 1000, '/');
?>
<!DOCTYPE html>
<html>
<head>
    <script>
        function redirectAndClose() {

        // 少し遅れてウィンドウを閉じる
        setTimeout(() => {
            if (window.opener) {
                window.close(); // ウィンドウを閉じる
            } else {
                alert("このウィンドウはスクリプトで開かれていないため閉じられません。");
            }
        }, 1000); // 適宜タイミングを調整
    }
    </script>
</head>
<body onload="redirectAndClose()">
</body>
</html>