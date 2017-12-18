<?php
include('header.php');

$id = $_GET["id"];

if(isset($_SESSION['user_session'])) {
    if(isset($_GET['id'])) {
        $userid = $_SESSION['user_session'];
        $id = $_GET['id'];

        function datetime() {
            return date( 'd-m-Y', time());
        }

        $order = $conn->prepare("SELECT o.ID, o.date, o.Status, p.title , SUM(amount*price) as totaal, be.amount FROM orders as o JOIN orderlines as be ON o.ID = be.OrderID JOIN products as p ON be.ProductID = p.ID WHERE o.CustomerID = :userid AND o.ID = :id GROUP BY o.ID");
        $order->bindparam(":userid", $userid);
        $order->bindParam(":id", $id);
        $order->execute();
        $order = $order->fetchAll();

        $products = $conn->prepare("SELECT title, price, amount*price as totaal, amount FROM products P JOIN orderlines OL ON P.ID=OL.ProductID WHERE OL.OrderID=:id");
        $products->execute(array(
            ":id" => $id
        ));

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

                <?php
                foreach ($order as $item) {
                    ?>
                    <div class="rightorder">
                        <div class="breadcrumb">
                            <a href="/orders">Bestellingen /</a>
                            <h5><?php echo $id ?> </h5>
                        </div>

                        <div class="orderinfo">
                            <h2>Bestelnummer <?php echo $id ?></h2>







                    <?php
                }
                ?>

            <?php
            $totalprice = 0;
        foreach ($products as $product) {
            $title = $product["title"];
            $price = $product["totaal"];
            $priceeach = $product['price'];
            $amount = $product["amount"];
            $totalprice = $totalprice + $price;
            echo "<h3> $title </h3> <a>Aantal &nbsp <b>$amount</b> </a><br><a>Prijs p.st. &nbsp <b>$priceeach</b></a><br><a>Totaal &nbsp <b>€$price</b> </a>";
        }
?>
                <h3>Totaal &nbsp<?php echo $totalprice ?></h3>
            </div>
        </div>

        </section>

        <?php
    }
} else {
    $user->redirect('/404');
}


