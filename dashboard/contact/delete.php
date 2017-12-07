<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
$user = new User($conn);
echo 'test';
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM contact WHERE ID = " . $id);
    $stmt->execute();
    $user->redirect('/dashboard/contact');
} else {
    echo 'Product niet gevonden';
}