<div class="home-products">
    <?php
    if ($monthlyitems->rowCount() > 0) {
        foreach ($monthlyitems as $monthlyitem) {
            ?>
            <div class="single-product">
                <div class="product-image" style="background-image: url('/assets/images/<?php echo $monthlyitem["image"] ?>')">
                    <div class="overlay">
                        <h2><?php echo $monthlyitem["type"]; ?></h2>
                    </div>
                </div>
                <div class="product-info">
                    <h2><?php echo $monthlyitem["title"]; ?></h2>
                    <p><?php echo $monthlyitem["description"]; ?></p>
                </div>
            </div>
            <?php
        }
    }
    ?>
    <p><a href="/dashboard/monthly_product/wijzigen_koffie.php">Wijzigen</a></p>
</div>