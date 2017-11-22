<?php include('header.php');

    if(isset($_GET['categorie'])) {
        $category = $_GET['categorie'];
        $categoryquery = ' WHERE pc.name = "' . $category . '"';
    } else {
        $categoryquery = '';
        $class = '';
    }

    if(isset($_GET['search'])) {
        $search = $_GET['search'];
        $searchquery = ' WHERE p.title LIKE "%' . $search . '%"';
    } else {
        $searchquery = '';
    }

    /* Queries */
    $categories = $conn->query('SELECT pc.name, pc.ID, COUNT(p.id) AS amount FROM productcategory AS pc LEFT JOIN products AS p ON p.categoryID = pc.ID GROUP BY pc.ID');
    $categories->execute();

    $products = $conn->prepare('SELECT p.*, pc.name as category FROM products AS p INNER JOIN productcategory AS pc ON p.categoryID = pc.ID' . $categoryquery . $searchquery);
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
                        if(isset($_GET['categorie'])) {
                            if($category["name"] === $_GET['categorie']) {
                                $class = 'class="selected"';
                            } else {
                                $class = '';
                            }
                        }
                        ?>
                        <li><a href="?categorie=<?php echo $category["name"]; ?>" <?php echo $class; ?>> <?php echo $category["name"] . ' ('. $category["amount"] .')'; ?></a></li>
                        <?php
                    }
                    if(isset($_GET['categorie'])) {
                        ?>
                        <li><a href="/shop">Toon alles</a></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <span class="title">Prijs</span>
            <?php echo $products->rowCount(); ?> resultaten
        </div>
        <div class="shop-right">
            <div class="products-filters">
                <div class="left-filter">
                    <span>Soorteer op:</span>
                    <select class="select-filter">
                        <option>Naam A-Z</option>
                        <option>Prijs oplopend</option>
                        <option>Prijs aflopend</option>
                    </select>
                </div>
                <div class="right-filter">
                    <span>Zoek:</span>
                    <form method="get" class="search-form">
                        <input type="text" name="search" class="search" placeholder="zoeken">
                    </form>
                </div>
            </div>
            <div class="shop-products">
            <?php
            if ($products->rowCount() > 0) {
                foreach ($products as $product) {
                    ?>
                    <div class="product">
                            <img src="/assets/images/products/<?php echo $product["image"]; ?>">
                            <div class="product-description">
                                <b><?php echo $product["title"]; ?></b>
                                <i><?php echo $product["category"]; ?></i>
                                <span class="price">&euro; <?php echo str_replace('.', ',', $product["price"]); ?></span>
                            </div>
                        <div class="product-cart">
                            <a href="/shop"><img src="/assets/images/cart.png"></a>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            </div>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>