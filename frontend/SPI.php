<?php
// ページタイトルとメタデータ
$title = "SPI試験の概要";
$description = "SPI試験とは、日本の企業で採用試験として広く利用されている試験です。その種類、内容、対策について詳しく説明します。";

// ヘッダー
function displayHeader($title) {
    echo "<header>";
    echo "<h1>" . $title . "</h1>";
    echo "<nav><ul><li><a href='#about'>SPIとは？</a></li><li><a href='#types'>SPIの種類</a></li><li><a href='#prep'>対策方法</a></li></ul></nav>";
    echo "</header>";
}

// フッター
function displayFooter() {
    echo "<footer>";
    echo "<p>&copy; 2024 SPI試験の詳細 | お問い合わせはこちら</p>";
    echo "</footer>";
}

// メインコンテンツ
function displayContent() {
    echo "<section id='about'>";
    echo "<h2>SPIとは？</h2>";
    echo "<p>SPIは、Synthetic Personality Inventoryの略で、多くの日本企業が採用選考の際に実施する適性試験です。基礎学力や論理的思考力、性格面を評価するために使われています。</p>";
    echo "</section>";

    echo "<section id='types'>";
    echo "<h2>SPIの種類</h2>";
    echo "<ul>";
    echo "<li>ペーパーテスト</li>";
    echo "<li>Webテスト</li>";
    echo "<li>テストセンター</li>";
    echo "</ul>";
    echo "</section>";

    echo "<section id='prep'>";
    echo "<h2>SPIの対策方法</h2>";
    echo "<p>SPI試験に対しては、適切な準備が必要です。問題集の活用や、過去問を繰り返し解くことが推奨されています。また、時間配分の練習も重要です。</p>";
    echo "</section>";
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="<?php echo $description; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- SPI.css ファイルを読み込むためのリンク -->
    <link rel="stylesheet" href="../css/SPI.css">
</head>
<body>
    <?php
    displayHeader($title);
    displayContent();
    displayFooter();
    ?>
</body>
</html>
