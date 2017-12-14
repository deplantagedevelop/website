<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];
    $delete_subproductcategory = $conn->prepare("DELETE FROM subproductcategory WHERE ID = :subproductcategoryID");
    $delete_subproductcategory->execute(array(
        ':subproductcategoryID' => $id
    ));
    header('Location: ' . $_SERVER['HTTP_REFERER']);