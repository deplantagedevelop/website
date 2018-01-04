<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $id = $_GET["id"];

    $order = $conn->prepare("SELECT firstname, middlename, lastname, email, phonenumber, address, city, postalcode, status FROM orders O JOIN customer C ON O.customerID = C.ID WHERE O.ID = :id");
    $order->execute(array(
        ":id" => $id
    ));
    $products = $conn->prepare("SELECT title, amount*price as totaal, amount FROM products P JOIN orderlines OL ON P.ID=OL.ProductID WHERE OL.OrderID=:id");
    $products->execute(array(
        ":id" => $id
    ));

    ?>
    <a href="/dashboard/orders" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
    <?php
    while ($row = $order->fetch()){
        $firstname = $row["firstname"];
        $middlename = $row["middlename"];
        $lastname = $row["lastname"];
        $email = $row["email"];
        $phonenumber = $row["phonenumber"];
        $address = $row["address"];
        $city = $row["city"];
        $postalcode = $row["postalcode"];
        $status = $row["status"];
        echo "<p class='order-index'> Naam: </p>";
        echo "<p class='reviewText'> $firstname $middlename $lastname </p>";
        echo "<p class='order-index'> Gegevens </p>";
        echo "<table class='order-table'>
                <tr> <td class='order-gegevens'> Email: </td> <td> $email </td> </tr>
                <tr> <td class='order-gegevens'> Telefoon: </td> <td> $phonenumber </td></tr>
                <tr> <td class='order-gegevens'> Adres: </td> <td> $address </td></tr>
                <tr> <td class='order-gegevens'> Woonplaats: </td> <td> $city </td></tr>
                <tr> <td class='order-gegevens'> Postcode: </td> <td> $postalcode </td></tr>
              </table>";
        echo "<p class='order-index'> Status </p>";
        echo "<p class='reviewText'> $status </p>";
        echo "<p class='order-index'> Producten </p>";
    }
    $totalprice = 0;
    echo "<table class='ProductOrder-table'>
            <thead>
                <tr> <th> Productnaam </th> <th> Aantal </th> <th> Prijs </th></tr>
            </thead>
            <tbody>";
    while ($row = $products -> fetch()) {
        $title = $row["title"];
        $price = $row["totaal"];
        $amount = $row["amount"];
        echo "<tr> <td> $title </td> <td> $amount </td> <td> €$price </td></tr>";
        $totalprice += $price;
    }
    echo "</tbody>
            </table>";
    echo "<p class='order-index'> Totaal bedrag: </p>";
    echo "<p class='reviewText'> €$totalprice </p>";

    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
