<?php include('header.php'); ?>
<section class="content main-content">
    <div class="order-succes">
    <?php
    if(isset($_GET['id'])) {
        if (!empty($_SESSION['order_succes'])) {
            ?>
            <h1>Uw bestelling is geplaatst, uw ordernummer is <?php echo $_SESSION['order_number'];  ?>!</h1>
            <?php
        } else {
            $user->redirect('/shop');
        }
    } else {
        $user->redirect('/shop');
    }
    ?>
    </div>
</section>
<?php include('footer.php'); ?>