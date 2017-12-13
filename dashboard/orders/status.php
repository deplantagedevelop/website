<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
$url = "/";
    $id = $_GET["id"];

    $status = $conn->prepare("UPDATE orders SET status='afgerond' WHERE ID=:id");
    $status->execute(array(
        ":id" => $id
    ));

header('Location: ' . $_SERVER['HTTP_REFERER']);