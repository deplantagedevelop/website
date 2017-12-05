<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];
    $delete_newscategory = $conn->prepare("DELETE FROM newscategory WHERE ID = :newscategoryID");
    $delete_newscategory->execute(array(
        ':newscategoryID' => $id
    ));
    header('Location: ' . $_SERVER['HTTP_REFERER']);