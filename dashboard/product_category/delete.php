<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $products = $conn->prepare("SELECT categoryID FROM products WHERE categoryID = :CategoryID");
        $products->bindParam(":CategoryID", $id);
        $products->execute();

        if($products->rowCount() > 0) {
            echo '<p>Het verwijderen van de categorie is mislukt, er is een product aanwezig die deze categorie al bevat, verwijder eerst het product of wijzig de categorie voordat u de categorie kan verwijderen. Klik <a href="/dashboard/product_category/">hier</a> om terug te gaan</p>';
        } else {
            $delete_productcategory = $conn->prepare("DELETE FROM productcategory WHERE ID = :productcategoryID");
            $delete_productcategory->execute(array(
                ':productcategoryID' => $id
            ));
            $user->redirect('/dashboard/product_category');
        }
    } else {
        echo 'Productcategorie niet gevonden';
    }