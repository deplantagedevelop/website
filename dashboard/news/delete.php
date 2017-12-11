<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        $newsitem = $conn ->prepare("SELECT image FROM news WHERE ID = " . $id);
        $newsitem->execute();
        $newsitemimage = $newsitem->fetch(PDO::FETCH_ASSOC);

        $stmt = $conn->prepare("DELETE FROM news WHERE ID = " . $id);
        $stmt->execute();
        unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/images/news/' . $newsitemimage['image']);

        $user->redirect('/dashboard/news');
    } else {
        echo 'Product niet gevonden';
    }