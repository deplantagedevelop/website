<?php
include('header.php');

    if(isset($_SESSION['user_session'])) {
        $userid = $_SESSION['user_session'];
    }

    $order = $conn->prepare("SELECT * FROM orders WHERE CustomerID = :id");

    $order->bindparam(":id", $userid);
    $order->execute();

?>
<section class="content main-info">

<div class="allcontent">

    <div class="orderleft">
        <h2>Mijn account</h2>
        <ul>
            <li>Bestellingen</li>
            <li>Accountgegevens</li>
            <li>Uitloggen</li>
        </ul>
    </div>

    <div class="orderright">
        <h1>Mijn bestellingen</h1>

        <?php
            foreach ($order as $orders) {
                echo $orders['ID'];
            }
        ?>

    </div>




</div>

</section>


<?php include('footer.php'); ?>
