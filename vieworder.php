<?php
include('header.php');

if (isset($_SESSION['user_session'])) {
    if (isset($_GET['id'])) {
        $userid = $_SESSION['user_session'];
        $id = $_GET['id'];

        function datetime()
        {
            return date('d-m-Y', time());
        }

<<<<<<< HEAD
        $order = $conn->prepare("SELECT o.ID, o.date, o.Status, p.title, SUM(amount*be.price) as totaal, be.amount FROM orders as o JOIN orderlines as be ON o.ID = be.OrderID JOIN products as p ON be.ProductID = p.ID WHERE o.CustomerID = :userid AND o.ID = :id GROUP BY o.ID");
=======
        $order = $conn->prepare("SELECT o.ID, o.date, o.Status, p.title , SUM(be.amount * be.price) as totaal, be.amount FROM orders as o JOIN orderlines as be ON o.ID = be.OrderID JOIN products as p ON be.ProductID = p.ID WHERE o.CustomerID = :userid AND o.ID = :id GROUP BY o.ID");
>>>>>>> 96ad29177b30eb838553fe768d931c545a879119
        $order->bindparam(":userid", $userid);
        $order->bindParam(":id", $id);
        $order->execute();
        $order = $order->fetchAll();

<<<<<<< HEAD
        $products = $conn->prepare("SELECT title, image, OL.price, amount*OL.price as totaal, amount FROM products P JOIN orderlines OL ON P.ID=OL.ProductID WHERE OL.OrderID=:id");
=======
        $products = $conn->prepare("SELECT p.image, p.title, ol.amount, ol.price FROM orderlines AS ol INNER JOIN orders AS o ON ol.OrderID = o.ID INNER JOIN products AS p ON p.ID = ol.ProductID WHERE ol.OrderID = :id");
>>>>>>> 96ad29177b30eb838553fe768d931c545a879119
        $products->execute(array(
            ":id" => $id
        ));

        ?>
        <section class="content main-info">
            <div class="fullcontent">

                <div class="leftcontent">
                    <h2>Mijn account</h2>
                    <ul>
                        <a href="/orders"><li>Bestellingen</li></a>
                        <a href="/logout"><li>Uitloggen</li></a>
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
                    <table>
                        <thead>
                            <tr>
<<<<<<< HEAD
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
=======
                                <th class="tableimg"><b>Bestelnr. <?php echo $id ?></b></th>
                                <th><b>Productnaam</b></th>
                                <th><b>Aantal</b></th>
                                <th class="priceeach"><b>Prijs</b></th>
                                <th><b>Totaal</b></th>
                            </tr>
                        </thead>
                        <tbody>
>>>>>>> 96ad29177b30eb838553fe768d931c545a879119
                    <?php
                    }
                    $totalprice = 0;

                    foreach ($products as $product) {
                        $title = $product["title"];
                        $amount = $product["amount"];
                        $price = $product["price"];
                        $priceeach = $price / $amount;
                        $totalprice = $totalprice + $price;
                        ?>
                            <div class="tableheader">
                                <div>
                                    <td class="tableimg"><img src="/assets/images/products/<?php echo $product["image"]; ?>"></td>
                                    <td><?php echo $title ?></td>
                                    <td><?php echo $amount ?></td>
                                    <td class="priceeach">€<?php echo $priceeach ?></td>
                                    <td>€<?php echo $price ?></td>
                                </tr>
                            </div>
                        <?php
                    }
                    ?>
<<<<<<< HEAD
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

=======
                    </tbody>
                        <tfoot>
                            <tr>
                                <td class="tableimg">
                                    <?php foreach ($order as $status) {
                                        echo "Status: <b>" . $status["Status"] . "</b>";
                                    } ?>
                                </td>
                                <td>
                                    <div class="mediastatus">
                                        <?php foreach ($order as $status) {
                                            echo "Status: <b>" . $status["Status"] . "</b>";
                                        } ?>
                                    </div>
                                </td>
                                <td></td>
                                <td class="priceeach"></td>
                                <td><b>Totaal €<?php echo number_format($totalprice, 2); ?></b></td>
                            </tr>
                        </tfoot>
>>>>>>> 96ad29177b30eb838553fe768d931c545a879119
                    </table>
                </div>
            </div>

        </section>
        <?php
    }
} else {
    $user->redirect('/404');
}


