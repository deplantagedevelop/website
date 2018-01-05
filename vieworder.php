<?php
include('header.php');

$id = $_GET["id"];

if (isset($_SESSION['user_session'])) {
    if (isset($_GET['id'])) {
        $userid = $_SESSION['user_session'];
        $id = $_GET['id'];

        function datetime()
        {
            return date('d-m-Y', time());
        }

        $order = $conn->prepare("SELECT o.ID, o.date, o.Status, p.title, SUM(amount*be.price) as totaal, be.amount FROM orders as o JOIN orderlines as be ON o.ID = be.OrderID JOIN products as p ON be.ProductID = p.ID WHERE o.CustomerID = :userid AND o.ID = :id GROUP BY o.ID");
        $order->bindparam(":userid", $userid);
        $order->bindParam(":id", $id);
        $order->execute();
        $order = $order->fetchAll();

        $products = $conn->prepare("SELECT title, image, OL.price, amount*OL.price as totaal, amount FROM products P JOIN orderlines OL ON P.ID=OL.ProductID WHERE OL.OrderID=:id");
        $products->execute(array(
            ":id" => $id
        ));

        ?>
        <section class="content main-info">
            <div class="fullcontent">

                <div class="leftcontent">
                    <h2>Mijn account</h2>
                    <ul>
                        <li>Bestellingen</li>
                        <li>Accountgegevens</li>
                        <li>Uitloggen</li>
                    </ul>
                </div>

                <?php
                foreach ($order

                as $item) {
                ?>
                <div class="rightorder">
                    <div class="breadcrumb">
                        <a href="/orders">Bestellingen /</a>
                        <h5><?php echo $id ?> </h5>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                    <th><b>Bestelnummer <?php echo $id ?></b></th>
                                    <th><b>Productnaam</b></th>
                                    <th><b>Aantal</b></th>
                                    <th><b>Prijs</b></th>
                                    <th><b>Totaal</b></th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th></th>
                        </tr>
                    <?php
                    }

                    $totalprice = 0;
                    foreach ($products as $product) {
                    $title = $product["title"];
                    $price = $product["totaal"];
                    $priceeach = $product['price'];
                    $amount = $product["amount"];
                    $totalprice = $totalprice + $price;
                    ?>
                        <tr>
                            <td><img src="/assets/images/products/<?php echo $product["image"]; ?>"></td>
                            <td><?php echo $title ?></td>
                            <td><?php echo $amount ?></td>
                            <td>€<?php echo $priceeach ?></td>
                            <td>€<?php echo $price ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><b>Totaal €<?php echo $totalprice ?></b></th>
                        </tr>
                        </tbody>

                    </table>
                </div>
            </div>

        </section>
        <?php
    }
} else {
    $user->redirect('/404');
}


