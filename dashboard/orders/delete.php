<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $url = "/";
    $id = $_GET["id"];

    $deleteOrder = $conn->prepare("DELETE FROM orders WHERE ID=:id");
    $deleteOrder->execute(array(
        ":id" => $id
    ));
    $deleteOrderlines = $conn->prepare("DELETE FROM orderlines WHERE OrderID=:id");
    $deleteOrderlines->execute(array(
        ":id" => $id
    ));

header('Location: ' . $_SERVER['HTTP_REFERER']);