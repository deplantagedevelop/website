<?php include('header.php'); ?>
<section class="content main-content">
    <div class="order-succes">
    <?php
    if(isset($_GET['id'])) {
        if (!empty($_SESSION['order_succes'])) {
            $ordernumber = $_SESSION['order_number'];
            ?>
            <h1>Uw bestelling is geplaatst, uw ordernummer is <a href="/vieworder.php?id=<?php echo $ordernumber; ?>"> <?php echo $ordernumber;  ?></a> !</h1>
            <p>Klik <a href="/orders">hier</a> om al uw orders te bekijken. U ontvangt zo snel mogelijk een bevestigingsmail. </p>
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