<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $product->deleteProduct($id);
        $user->redirect('/dashboard/products');
    } else {
        echo 'Product niet gevonden';
    }