<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');

    if(isset($_GET['id'])) {
        $id = $_GET["id"];
        $customer_delete = $conn->prepare("DELETE FROM customer WHERE ID = :customerID");
        $customer_delete->execute(array(
            ':customerID' => $id
        ));
        $user->redirect('/dashboard/role');
    } else {
        echo 'Gebruiker niet gevonden';
    }


    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
?>