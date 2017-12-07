<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
$url = "/";
$id = $_GET["id"];
$delete_news = $conn->prepare('DELETE FROM news WHERE ID = :newsid');
$delete_news->execute(array(
    ':newsid' => $id
));
header('Location: ' . $_SERVER['HTTP_REFERER']);