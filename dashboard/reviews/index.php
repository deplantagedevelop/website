<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
$user = new User($conn);

if($user->has_role('Administrator')) {
    echo 'test';
}
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

