<?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $news = $conn->prepare("SELECT categoryID FROM news WHERE categoryID = :CategoryID");
        $news->bindParam(":CategoryID", $id);
        $news->execute();

        if($news->rowCount() > 0) {
            echo '<p>Het verwijderen van de categorie is mislukt, er is een nieuwsbericht aanwezig die deze categorie al bevat, verwijder eerst het nieuwsbericht of wijzig de categorie voordat u de categorie kan verwijderen. Klik <a href="/dashboard/news_category/">hier</a> om terug te gaan</p>';
        } else {
            $delete_newscategory = $conn->prepare("DELETE FROM newscategory WHERE ID = :newscategoryID");
            $delete_newscategory->execute(array(
                ':newscategoryID' => $id
            ));
            $user->redirect('/dashboard/news_category/');
        }
    } else {
        echo 'Nieuwsitem niet gevonden';
    }