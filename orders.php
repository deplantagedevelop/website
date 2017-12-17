<?php
include('header.php');

    if(isset($_SESSION['user_session'])) {
        $userid = $_SESSION['user_session'];
    }

    $order = $conn->prepare("SELECT o.ID, o.date, o.Status, amount*price as totaal, amount FROM orders as o JOIN orders as b      WHERE CustomerID = :id");

    $order->bindparam(":id", $userid);
    $order->execute();

$producten = $conn->prepare("SELECT title, amount*price as totaal, amount FROM products P JOIN orderlines OL ON P.ID=OL.ProductID WHERE OL.OrderID=:id");

$producten->bindparam(":id", $userid);
$producten->execute();

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
            foreach ($order as $bestelling) {
                ?>
            <div class="fullorder">
                <div class="ordercontent">
                    <p><?php echo "Bestelnummer: <b>" . $bestelling['ID'] . "</b>" ?></p>
                    <a><?php echo $bestelling['date']; ?></a>
                </div>
            </div>
        <?php
            }
        ?>
    </div>




</div>

</section>


<?php include('footer.php'); ?>
