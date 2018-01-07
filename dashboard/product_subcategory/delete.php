<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $products = $conn->prepare("SELECT subcategoryID FROM products WHERE subcategoryID = :subcategoryID");
        $products->bindParam(":subcategoryID", $id);
        $products->execute();

        if($products->rowCount() > 0) {
            echo '<p>Het verwijderen van de subcategorie is mislukt, er is een product aanwezig die deze subcategorie al bevat, verwijder eerst het product of wijzig de subcategorie voordat u de categorie kan verwijderen. Klik <a href="/dashboard/product_subcategory/">hier</a> om terug te gaan</p>';
        } else {
            $delete_productsubcategory = $conn->prepare("DELETE FROM productsubcategory WHERE ID = :productsubcategoryID");
            $delete_productsubcategory->execute(array(
                ':productsubcategoryID' => $id
            ));
            $user->redirect('/dashboard/product_subcategory');
        }
    } else {
        echo 'Productsubcategorie niet gevonden';
    }