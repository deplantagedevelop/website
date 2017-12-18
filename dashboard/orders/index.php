<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');

    $orderquery="";
    $wherequery="";
    $searchquery="";
    $search="";
    if(isset($_GET['select-order'])) {
        $filter = $_GET['select-order'];
        if($filter == 'date-ASC') {
            $orderquery = " ORDER BY date ASC";
        } elseif ($filter == 'date-DESC') {
            $orderquery = " ORDER BY date DESC";
        } elseif ($filter == 'name-ASC') {
            $orderquery = " ORDER BY firstname ASC";
        } elseif ($filter == 'name-DESC') {
            $orderquery = " ORDER BY firstname DESC";
        } elseif ($filter == 'amount-DESC') {
            $orderquery = " ORDER BY aantal DESC";
        } elseif ($filter == 'amount-ASC') {
            $orderquery = " ORDER BY aantal ASC";
        }
    }
    if (isset($_GET["select-status"])) {
        $status = $_GET['select-status'];
        if ($status == 'status-verwerken') {
            $wherequery = " WHERE status = 'verwerken'";
        } elseif ($status == 'status-afgerond') {
            $wherequery = " WHERE status = 'afgerond'";
        } elseif ($status == 'status-afgerond-verwerken') {
            $wherequery = "";
        }
    }

    if (!empty($_GET["search-orders"])) {
        $search = $_GET["search-orders"];
        $searchquery = ' WHERE firstname LIKE "%' . $search . '%" OR lastname LIKE "%' . $search . '%"';
    }

    $orders = $conn->prepare("SELECT O.ID id, firstname, middlename, lastname, sum(amount) aantal, O.date datum, status FROM orders O JOIN customer C ON O.customerID = C.ID JOIN orderlines OL ON O.ID=OL.orderID" . $wherequery  . $searchquery ." GROUP BY id" . $orderquery);

?>

<div class="ordersOverview-top">
    <div class="ordersSort">
        <form method="get" class="sort-orders">
            <select name="select-order">
                <option name="default"> Sorteren op</option>
                <option name="date-DESC" value="date-ASC"> Datum oud-nieuw </option>
                <option name="date-ASC" value="date-DESC"> Datum nieuw-oud</option>
                <option name="name-ASC" value="name-ASC"> Naam A - Z </option>
                <option name="name-DESC" value="name-DESC"> Naam Z - A</option>
                <option name="amount-DESC" value="amount-DESC"> Aantal veel - weinig </option>
                <option name="amount-ASC" value="amount-ASC"> Aantal weinig - veel </option>
            </select>
            <select name="select-status">
                <option name="default"> Sorteren op status</option>
                <option name="status-verwerken" value="status-verwerken"> Verwerken </option>
                <option name="status-afgerond" value="status-afgerond"> Afgerond </option>
                <option name="status-afgerond-verwerken" value="status-afgerond-verwerken"> Beiden </option>
            </select>
            <button type="submit"> Verzenden </button>
            <input class="search-order" type="text" name="search-orders" class="search-orders" value="<?php echo $search; ?>" placeholder="zoeken">
            <button type="submit"> Zoeken </button>
        </form>
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
            echo "<td> <i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i><a href=\"/dashboard/orders/delete?id=$id\" onclick=\"return confirm('Weet je zeker dat je de bestelling wilt verwijderen?');\"> Verwijderen</a></td>
                  </tr>";
        }
    ?>
        </tbody>
    </table>
</div>

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
