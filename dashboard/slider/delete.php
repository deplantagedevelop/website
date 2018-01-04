<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/slide.php');
    $user = new User($conn);
    $slide = new Slide($conn);

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $slide->deleteSlide($id);
        $user->redirect('/dashboard/slider');
    } else {
        echo 'Slide niet gevonden';
    }