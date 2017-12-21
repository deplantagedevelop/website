<?php
include('header.php');

    if(isset($_SESSION['user_session'])) {
        $userid = $_SESSION['user_session'];
    }

    $order = $conn->prepare("SELECT o.ID, o.date, o.Status, SUM(amount*price) as totaal, be.amount FROM orders as o JOIN orderlines as be ON o.ID = be.OrderID JOIN products as p ON be.ProductID = p.ID WHERE o.CustomerID = :id GROUP BY o.ID");
    $order->bindparam(":id", $userid);
    $order->execute();
    $order=$order->fetchAll();

    function datetime() {
        return date( 'd-m-Y', time());
    }

?>
<section class="content main-info">

<div class="allcontent">

    <div class="orderleft">
        <h2>Mijn account</h2>
        <ul>
            <a href="/orders"><li>Bestellingen</li></a>
            <a href="/logout"><li>Uitloggen</li></a>
        </ul>
    </div>

    <div class="orderright">
        <h1>Mijn bestellingen</h1>

        <?php
            foreach ($order as $bestelling) {
                ?>
            <div class="fullorder">
                <div class="ordercontent">
                    <div class="contentleft">
                        <p><?php echo "Bestelnummer: <b>" . $bestelling['ID'] . "</b>" ?></p>
                        <a><?php echo datetime(); ?></a>
                    </div>
                    <div class="contentright">
                        <div class="status">
                            <a>Status: <b><?php echo $bestelling['Status']; ?></b></a>
                        </div>
                        <div class="ordertotal">
                            <a>Totaal €<?php echo $bestelling['totaal']; ?></a>
                        </div>
                        <div class="seeorder">
                            <a href="/vieworder?id=<?php echo $bestelling["ID"]; ?>"><b>Bekijk</b></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
    </div>
</div>

</section>


<?php include('footer.php'); ?>
