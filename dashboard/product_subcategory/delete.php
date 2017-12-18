<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];
    $delete_productsubcategory = $conn->prepare("DELETE FROM productsubcategory WHERE ID = :productsubcategoryID");
    $delete_productsubcategory->execute(array(
        ':productsubcategoryID' => $id
    ));
    header('Location: ' . $_SERVER['HTTP_REFERER']);