<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPIタイサくん</title>
</head>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
}

.container {
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #bcd;
    padding: 10px;
    border-radius: 5px;
}

.menu-icon {
    font-size: 24px;
}

h1 {
    margin: 0;
    font-size: 24px;
}

.login {
    font-size: 16px;
    color: #666;
}

main {
    margin-top: 20px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.categories {
    display: flex;
    justify-content: space-around;
}

.category {
    background-color: white;
    padding: 15px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 45%;
}

.category h3 {
    text-align: center;
    margin-top: 0;
}

.category ul {
    list-style-type: none;
    padding: 0;
}

.category li {
    margin: 10px 0;
    text-align: center;
}

</style>

<body class="body2">
    <div class="container">
        <header>
            <div class="menu-icon">&#9776;</div>
            <h1 class="genreh1">SPIタイサくん</h1>
            <div class="login">ログイン</div>
        </header>
        <main class="main2">
            <h2 class="genreh2">ジャンル選択</h2>
            <div class="categories">
                <div class="category">
                    <h3>言語系</h3>
                    <ul>
                        <li>二語の関係</li>
                        <li>文章整序</li>
                        <li>空欄補充</li>
                        <li>語句の意味</li>
                        <li>語句の用法</li>
                    </ul>
                </div>
                <div class="category">
                    <h3>非言語系</h3>
                    <ul>
                        <li>速度の計算</li>
                        <li>確率の計算</li>
                        <li>税率の計算</li>
                        <li>濃度の計算</li>
                        <li>表計算</li>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</body>
</html>