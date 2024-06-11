<?php
require_once __DIR__ . '/database/class.php';
require_once __DIR__ . '/pre.php';

if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}

$form = new form();
$title = $_POST['title-input'];
$message = $_POST['message-input'];
$site = $_POST['site-input'];
$shosai = $_POST['shosai-input'];
$selection = $_POST['selection-input'];

$datetime = date('Y/m/d H:i');

$seikaid = $form->insertseikabutu($userid, $title, $message, $site, $shosai, $selection, $datetime);

if (!($_FILES["uploadfile"]["name"] == "")) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./upload/" . $filename;

    $form->insertSeikaPic($seikaid, $filename);

    move_uploaded_file($tempname, $folder);
}

header("Location: seikabutuitirann.php");
exit; // リダイレクト後にスクリプトの実行を終了するために必要
