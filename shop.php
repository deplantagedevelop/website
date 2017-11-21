<?php include('header.php');

    $categories = $conn->query('SELECT * FROM productcategory');

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
                        <li><?php echo $category["name"]; ?></li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="shop-right">
            
        </div>
    </div>
</section>
<?php include('footer.php'); ?>