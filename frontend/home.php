<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPI サイト</title>
    <link rel="stylesheet" href="../css/home.css">
    <link rel="icon" type="../image/x-icon" href="../image/icon.png" />
</head>
<body>
    <!-- ヘッダー -->
    <header>
        <div class="container">
            <nav>
                <ul>
                    <li><a href="">ホーム</a></li> <!-- ""は更新　-->
                    <li><a href="SPI.php" class="spi-link">SPIとは</a></li>
                    <li><a href="seihin.php">製品とサービス</a></li>
                    <li><a href="https://forms.gle/oMCuBp2MY42qXyEu8">お問い合わせ</a></li>
                </ul>
            </nav>

        </div>
        <a href="kanrisya_login.php" class="kan-right">管理者ログイン</a>
    </header>

    <!-- メインビジュアル -->
    <section class="hero">
        <div class="container">
            <h1>SPI対策して試験合格を確実に</h1>
            <p>シンプルでゲーム性溢れるSPIサイト</p>
            <img src="../image/icon/logo.png" class=logo.img alt="タイサくんロゴ">
            <a href="javascript:void(0);" class="btn" onclick="openMaximizedWindow()">ユーザーログイン</a>
        </div>
    </section>

    <script>
        function openMaximizedWindow() {
            const width = screen.availWidth;
            const height = screen.availHeight;
            window.open('login.php', '_blank', `width=${width},height=${height},top=0,left=0`);
        }
    </script>

</body>
</html>
