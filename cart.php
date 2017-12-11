<?php include('header.php');
?>

    <section class="content main-content">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Artikel</th>
                    <th>Aantal</th>
                    <th>Prijs</th>
                    <th>Totaal prijs</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php
                if(!empty($_SESSION["shopping_cart"]))
                {
                    $total = 0;
                    foreach($_SESSION["shopping_cart"] as $keys => $values)
                    {
                        ?>
                        <tr>
                            <td><?php echo $values["item_name"]; ?></td>
                            <td><?php echo $values["item_amount"]; ?></td>
                            <td>&euro; <?php echo $values["item_price"]; ?></td>
                            <td>&euro; <?php echo number_format($values["item_amount"] * $values["item_price"], 2); ?></td>
                            <td><a href="/shop?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span></a></td>
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
            </tbody>
        </table>
    </section>

<?php include('footer.php'); ?>