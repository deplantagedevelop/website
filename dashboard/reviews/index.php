<?php
    include_once('../header.php');
    $user = new User($conn);

    if($user->has_role('Administrator')) {
        echo 'test';
    }
    include('../footer.php');
