<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8"> <!-- 文字エンコーディングをUTF-8に設定 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, initial-scale=1"> <!-- レスポンシブ対応 -->
    <title>SPI サイト</title> <!-- ページタイトル -->
    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="../css/home.css"> <!-- PC向けスタイル -->
    <link rel="stylesheet" href="../responsive/home.css"> <!-- レスポンシブ用スタイル -->
    <!-- サイトのファビコン設定 -->
    <link rel="icon" type="image/x-icon" href="../image/icon.png" />
</head>
<body>
    <!-- ヘッダー -->
    <header>
        <div class="container">
            <!-- ナビゲーションメニュー -->
            <nav>
                <ul>
                    <li><a href="">ホーム</a></li> <!-- 現在のページを更新するためのリンク -->
                    <li><a href="SPI.php" class="spi-link">SPIとは</a></li> <!-- SPIに関する説明ページへのリンク -->
                    <li><a href="seihin.php">製品とサービス</a></li> <!-- 製品・サービス情報ページへのリンク -->
                    <li><a href="https://forms.gle/oMCuBp2MY42qXyEu8">お問い合わせ</a></li> <!-- Googleフォームでのお問い合わせリンク -->
                </ul>
            </nav>
        </div>
        <!-- 管理者専用ログインページへのリンク -->
        <a href="kanrisya_login.php" class="kan-right">管理者ログイン</a>
    </header>

    <!-- メインビジュアル -->
    <section class="hero">
        <div class="container">
            <!-- キャッチコピー -->
            <h1>SPI対策して試験合格を確実に</h1> <!-- メインタイトル -->
            <p>シンプルでゲーム性溢れるSPIサイト</p> <!-- サブタイトル -->
            <!-- タイサくんロゴ画像 -->
            <img src="../image/icon/logo.png" class="logo-img" alt="タイサくんロゴ">
            <!-- ユーザーログインページへのリンクボタン -->
            <a href="login.php" class="btn">ユーザーログイン</a>
        </div>
    </section>
</body>
</html>
