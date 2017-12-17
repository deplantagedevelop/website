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
<section class="content main-content">
    <h1>HILIl;</h1>
</section>
