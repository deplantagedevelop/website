<?php include('header.php');

    $categories = $conn->query('SELECT pc.name, pc.ID, COUNT(p.id) AS amount FROM productcategory AS pc LEFT JOIN products AS p ON p.categoryID = pc.ID GROUP BY pc.ID');
    $categories->execute();

    $products = $conn->prepare('SELECT * FROM products');
    $products->execute();

?>
<section class="content main-content">
    <div class="shop-content">
        <div class="shop-left">
            <span class="title">Categorieën</span>
            <ul>
                <?php
                if ($categories->rowCount() > 0) {
                    foreach ($categories as $category) {
                        ?>
                        <li><?php echo $category["name"] . ' ('. $category["amount"] .')'; ?></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <span class="title">Prijs</span>
            <?php echo $products->rowCount(); ?> resultaten
        </div>
        <div class="shop-right">
            <div class="product">
                <img src="/assets/images/products/waardebon.jpg">

            </div>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>