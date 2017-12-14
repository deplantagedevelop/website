<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];
    $delete_productcategory = $conn->prepare("DELETE FROM productcategory WHERE ID = :productcategoryID");
    $delete_productcategory->execute(array(
        ':productcategoryID' => $id
    ));
    header('Location: ' . $_SERVER['HTTP_REFERER']);