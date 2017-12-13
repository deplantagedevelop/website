<?php
    include('header.php');
    include('functions/products.php');
    include('functions/shop.php');
    $product = new Product($conn);
    $user = new User($conn);
    $shop = new Shop($conn);
?>

    <section class="content main-content">
        <div class="cart-header">
            <h1>Winkelwagen</h1>
        </div>
        <table class="cart-table">
            <?php
                if(!empty($_SESSION["shopping_cart"]))
                {
                    $total = 0;
                    foreach($_SESSION["shopping_cart"] as $keys => $values)
                    {
                        if(isset($_GET['action'])) {
                            if($values['item_id'] == $_GET["id"]) {
                                unset($_SESSION["shopping_cart"][$keys]);
                                $count = count($_SESSION["shopping_cart"]);
                                $user->redirect('/cart');
                            }
                        }
                        ?>
                        <tr>
                            <td><img src="/assets/images/products/<?php echo $values["item_image"]; ?>"></td>
                            <td><?php echo $values["item_name"]; ?></td>
                            <td><?php echo $values["item_amount"]; ?></td>
                            <td>&euro; <?php echo number_format($values["item_amount"] * $values["item_price"], 2); ?></td>
                            <td><a href="/cart?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a></td>
                        </tr>
                        <?php
                        $total = $total + ($values["item_amount"] * $values["item_price"]);
                    }
                    ?>
                    <tr>
                        <td>Totaal bedrag</td>
                        <td>&euro; <?php echo number_format($total, 2); ?></td>
                        <td></td>
                    </tr>
                    <?php
                }
            ?>
        </table>
        <?php
        if(!empty($_SESSION["shopping_cart"])) {
            ?>
            <form method="post" action="">
                <input type="submit" value="Bestelling plaatsen">
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if(!$user->is_loggedin()) {
                    echo 'U moet ingelogd zijn om een bestelling te kunnen plaatsten, klik <a href="/inloggen?redirectUrl=cart">hier</a> om in te loggen.';
                } else {
                    $UserID = $_SESSION['user_session'];
                    $shop->createOrder($UserID, 'verwerken');
                    $OrderID = $conn->lastInsertId();
                    foreach($_SESSION["shopping_cart"] as $keys => $values) {
                        $ProductID = $values['item_id'];
                        $amount = $values['item_amount'];

                        $shop->createOrderLine($OrderID, $ProductID, $amount);
                    }
                    unset($_SESSION["shopping_cart"]);

                    echo 'Bestelling is geplaatst!';
                }
            }
        }
        ?>
    </section>

<?php include('footer.php'); ?>