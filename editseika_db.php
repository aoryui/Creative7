<?php
require_once __DIR__ . '/database/class.php';
$form = new form();
require_once __DIR__ . '/pre.php';
if (isset($_SESSION['userid'])) {
    $userid = $_SESSION['userid'];
}
$title = $_POST['title-input'];
$message = $_POST['message-input'];
$site = $_POST['site-input'];
$shosai = $_POST['shosai-input'];
$selection = $_POST['selection-input'];
$seikaid = $_POST['seikaid'];

$datetime = date('Y/m/d H:i');

$form->updateSeika($seikaid, $title, $message, $site, $shosai, $selection, $datetime);

if (!($_FILES["uploadfile"]["name"] == "")) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./upload/" . $filename;

    $form->updateSeikaPic($seikaid, $filename);

    move_uploaded_file($tempname, $folder);
}

// リダイレクト
header("Location: seikabutuitirann.php");
exit;
