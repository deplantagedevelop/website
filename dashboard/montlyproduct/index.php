<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);
    if (!$user->is_loggedin()) {
        $user->redirect('/inloggen');
    }
    $montlyproduct = $conn->prepare("SELECT * FROM montlyproduct");
?>

<table class="newscategory-table">
    <thead><tr> <th> Product van de maand </th> <th> Naam </th> <th> Beschrijving </th> <th> Wijzigen </th></tr> </thead>


<?php
    $montlyproduct->execute();
    echo "<tbody>";
    while ($row = $montlyproduct->fetch()){
        
    }
?>