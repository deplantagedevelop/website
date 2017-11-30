<?php include('header.php');
    $user = new User($conn);
    if($user->is_loggedin()) {
        if($user->has_role('Administrator')) {
            echo 'Ik ben admin';
        } elseif ($user->has_role('Medewerker')) {
            echo 'Ik ben medewerker';
        }
    } else {
        $user->redirect('/404');
    }
    echo '<a href="reviews/"> reviews </a>';
?>
<?php include('footer.php'); ?>
