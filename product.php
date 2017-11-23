<?php include('header.php'); ?>
<section class="content main-content">
    <?php
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            $product = $conn->prepare('SELECT * FROM products WHERE id = ' . $id);
            $product->execute();
            foreach ($product as $item) {
                ?>
                <div class="product-content">
                    <div class="left-product">
                        <img src="/assets/images/products/<?php echo $item["image"]; ?>">
                    </div>
                    <div class="right-product">

                    </div>
                </div>
                <?php
            }
        }
    ?>
</section>
<?php include('footer.php'); ?>
