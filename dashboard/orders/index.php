<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $orders = $conn->prepare("SELECT O.ID id, firstname, middlename, lastname, sum(amount) aantal, O.date datum, status FROM orders O JOIN customer C ON O.customerID = C.ID JOIN orderlines OL ON O.ID=OL.orderID GROUP BY id")
?>

<div class="ordersOverview-top">
    <div class="ordersSort">

    </div>
    <div class="ordersSearch">

    </div>
</div>

<div class="ordersOverview-bottom">
    <table class="dash-table">
        <thead>
            <tr>
                <th> Naam </th> <th> Aantal producten </th> <th> Datum </th> <th> Status </th> <th> Bekijken </th> <th> Afronden </th> <th> Verwijderen </th>
            </tr>
        </thead>
        <tbody>
    <?php
        $orders->execute();
        while ($row = $orders ->fetch()){
            $id = $row["id"];
            $firstname = $row["firstname"];
            $middlename = $row["middlename"];
            $lastname = $row["lastname"];
            $aantal = $row["aantal"];
            $datum = $row["datum"];
            $status = $row["status"];
            echo "<tr>
                    <td> $firstname $middlename $lastname </td>
                    <td> $aantal </td>
                    <td> $datum </td>
                    <td> $status </td>
                    <td> <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> <a href=\"/dashboard/orders/order?id=$id\">Bekijken</a></td>";
            if ($status == "afgerond") {
                echo "<td> Afgerond </td>";
            } else {
                echo "<td> <i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i> <a href=\"/dashboard/orders/status?id=$id\" onclick=\"return confirm('Weet je zeker dat je de status wilt veranderen?');\">Afronden</a></td>";
            }
            echo "<td> <i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i><a href=\"/dashboard/orders/delete?id=$id\" onclick=\"return confirm('Weet je zeker dat je de bestelling wilt verwijderen?');\">Verwijderen</a></td>
                  </tr>";
        }
    ?>
        </tbody>
    </table>
</div>

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
