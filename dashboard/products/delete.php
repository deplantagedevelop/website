<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $orderlines = $conn->prepare("SELECT ProductID FROM orderlines WHERE ProductID = :ProductID");
        $orderlines->bindParam(":ProductID", $id);
        $orderlines->execute();

        if($orderlines->rowCount() > 0) {
            echo '<p>Het verwijderen van het product is mislukt, dit product is al een keer besteld. Om het product niet meer te tonen moet je terug gaan naar producten en zet de status op "Niet beschikbaar". Klik <a href="/dashboard/products">hier</a> om terug te gaan</p>';
        } else {
            $product->deleteProduct($id);
            $user->redirect('/dashboard/products');
        }
    } else {
        echo 'Product niet gevonden';
    }