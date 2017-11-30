<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    if(!$user->is_loggedin()) {
        $user->redirect('/404');
    }

    ?>
    <form method="post">
        <input type="text" name="title" placeholder="Productnaam"><br>
        <textarea name="description" placeholder="Productnaam"></textarea><br>
        <input type="text" name="price" placeholder="Prijs"><br>
        <input type="file" name="image"><br>
        <input type="text" name="category" placeholder="Categorie"><br>
        <input type="submit" value="Toevoegen"><br>
    </form>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $categoryID = $_POST['category'];

        $product->createProduct($title, $description, $price, $image, $categoryID);
    }


    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');