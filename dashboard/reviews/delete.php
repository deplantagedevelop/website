<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $url = "/";
    $id = $_GET["id"];
        $delete_reviews = $conn->prepare('DELETE FROM reviews WHERE ID = :reviewid');
        $delete_reviews -> execute(array(
            ':reviewid' => $id));
        header('Location: ' . $_SERVER['HTTP_REFERER']);
?>