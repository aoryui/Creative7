<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問題表</title>
    <link rel="stylesheet" href="../css/question_edit.css">
</head>
<body>
<a href="question_list.php">問題一覧</a>
<h2>問題編集</h2>
<table>
    <tbody>
        <tr>
            <th>&nbsp;</th>
            <th>データ</th>
            <th>更新データ</th>
            <th>編集</th>
        </tr>
        <tr>
            <th>言語非言語</th>
            <th></th>
            <th></th>
            <th><button onclick="openModal('modal1')">編集</button></th>
        </tr>
        <tr>
            <th>ジャンル名</th>
            <th></th>
            <th></th>
            <th><button onclick="openModal('modal2')">編集</button></th>
        </tr>
        <tr>
            <th>問題画像</th>
            <th></th>
            <th></th>
            <th><button onclick="openModal('modal3')">編集</button></th>
        </tr>
        <tr>
            <th>回答画像</th>
            <th></th>
            <th></th>
            <th><button onclick="openModal('modal4')">編集</button></th>
        </tr>
        <tr>
            <th>選択肢</th>
            <th></th>
            <th></th>
            <th><button onclick="openModal('modal5')">編集</button></th>
        </tr>
        <tr>
            <th>制限時間</th>
            <th></th>
            <th></th>
            <th><button onclick="openModal('modal6')">編集</button></th>
        </tr>
        <tr>
            <th>問題文要約</th>
            <th></th>
            <th></th>
            <th><button onclick="openModal('modal7')">編集</button></th>
        </tr>
    </tbody>
</table>

<!-- 各モーダル -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal1')">&times;</span>
        <h2>言語非言語の編集内容</h2>
    </div>
</div>

<div id="modal2" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal2')">&times;</span>
        <h2>ジャンル名の編集内容</h2>
    </div>
</div>

<div id="modal3" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal3')">&times;</span>
        <h2>問題画像の編集内容</h2>
    </div>
</div>

<div id="modal4" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal4')">&times;</span>
        <h2>回答画像の編集内容</h2>
    </div>
</div>

<div id="modal5" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal5')">&times;</span>
        <h2>選択肢の編集内容</h2>
    </div>
</div>

<div id="modal6" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal6')">&times;</span>
        <h2>制限時間の編集内容</h2>
    </div>
</div>

<div id="modal7" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('modal7')">&times;</span>
        <h2>問題文要約の編集内容</h2>
    </div>
</div>

<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = "block";
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    window.onclick = function(event) {
        const modals = document.getElementsByClassName("modal");
        for (let modal of modals) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
</script>
</body>
</html>
