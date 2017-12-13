<?php
include("../header.php");
$url = "/";
$id = $_GET["id"];
$customer_delete = $conn->prepare("DELETE FROM customer WHERE ID = :customerID");
$customer_delete->execute(array(
    ':customerID' => $id
));

include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');?>