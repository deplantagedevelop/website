    <?php include('header.php');
    $productvars = $conn->prepare('SELECT MIN(price) AS minprice, MAX(price) AS maxprice FROM products');
    $productvars->execute();
    $productvar = $productvars->fetch(PDO::FETCH_ASSOC);

    //Check for page request
    $limit = 12;
    if(empty($_GET['pagina'])) {
        $currentRow = 0;
        $_GET['pagina'] = 0;
    } else {
        $pagina = $_GET['pagina'];
        $currentRow = ($pagina - 1) * $limit;
    }

    if(isset($_GET['categorie'])) {
        $category = $_GET['categorie'];
        $categoryquery = ' AND pc.name = "' . $category . '"';
    } else {
        $categoryquery = '';
        $category = '';
        $class = '';
    }

    if((isset($_GET['minprice'])) && (isset($_GET['maxprice']))) {
        $minprice = $_GET['minprice'];
        $maxprice = $_GET['maxprice'];
        if(empty($maxprice)) {
            $maxprice = $productvar['maxprice'];
        } elseif(empty($minprice)) {
            $minprice = $productvar['minprice'];
        }

        $minpricequery = ' AND p.price >= ' . $minprice;
        $maxpricequery = ' AND p.price <= ' . $maxprice;

        if($maxprice == '') {
            $user->redirect('/shop');
        }
    } else {
        if(isset($_GET['minprice']) && !empty($_GET['minprice'])) {
            $minprice = $_GET['minprice'];
            $minpricequery = ' AND p.price >= ' . $minprice;
        } else {
            $minprice = '';
            $minpricequery = '';
        }

        if(isset($_GET['maxprice']) && !empty($_GET['maxprice'])) {
            $maxprice = $_GET['maxprice'];
            $maxpricequery = ' AND p.price <= ' . $maxprice;
        } else {
            $maxprice = '';
            $maxpricequery = '';
        }
    }

    if(isset($_GET['search'])) {
        $search = $_GET['search'];
        $searchquery = ' AND p.title LIKE "%' . $search . '%"';
    } else {
        $search = '';
        $searchquery = '';
    }

    if(isset($_GET['order'])) {
        $order = $_GET['order'];
        if($order === 'date-asc') {
            $orderquery = ' ORDER BY date ASC';
        } elseif ($order === 'date-desc') {
            $orderquery = ' ORDER BY date DESC';
        } elseif ($order === 'order-name') {
            $orderquery = ' ORDER BY title ASC';
        } elseif ($order === 'price-asc') {
            $orderquery = ' ORDER BY price ASC';
        } elseif ($order === 'price-desc') {
            $orderquery = ' ORDER BY price DESC';
        }
    } else {
        $order = '';
        $orderquery = ' ORDER BY date DESC';
    }

    if(isset($_POST["add_to_cart"])) {
        if(isset($_SESSION["shopping_cart"])) {
            //Check if Item is not in the cart and create new item after that
            $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
            if(!in_array($_GET["id"], $item_array_id)) {
                $count = count($_SESSION["shopping_cart"]);
                $item_array = array(
                    'item_id'     => $_GET["id"],
                    'item_name'   => $_POST["hidden_name"],
                    'item_price'  => $_POST["hidden_price"],
                    'item_image'  => $_POST["hidden_image"],
                    'item_amount' => $_POST["hidden_amount"]
                );
                $_SESSION["shopping_cart"][$count + 1] = $item_array;
                $user->redirect('/shop');
            } else {
                //Do this to check if Item is already in cart and update amount by 1
                $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
                foreach($_SESSION["shopping_cart"] as $item => $key) {
                    if($key['item_id'] == $_GET["id"]) {
                        $amount = $key['item_amount'];
                        $item_array = array(
                            'item_id'     => $_GET["id"],
                            'item_name'   => $_POST["hidden_name"],
                            'item_price'  => $_POST["hidden_price"],
                            'item_image'  => $_POST["hidden_image"],
                            'item_amount' => $_POST["hidden_amount"] + $amount
                        );
                        unset($_SESSION["shopping_cart"][$item]);
                        $_SESSION["shopping_cart"][$item] = $item_array;
                        $user->redirect('/shop');
                    }
                }
            }
        } else {
            $item_array = array(
                'item_id'     => $_GET["id"],
                'item_name'   => $_POST["hidden_name"],
                'item_price'  => $_POST["hidden_price"],
                'item_image'  => $_POST["hidden_image"],
                'item_amount' => $_POST["hidden_amount"]
            );

            $_SESSION["shopping_cart"][0] = $item_array;
            $user->redirect('/shop');
        }
    }

    /* Queries */
    $categories = $conn->query('SELECT pc.name, pc.ID, COUNT(p.id) AS amount FROM productcategory AS pc INNER JOIN products AS p ON p.categoryID = pc.ID WHERE p.available = 1 GROUP BY pc.ID');
    $categories->execute();

    $subcategories = $conn->query('SELECT * FROM productsubcategory');
    $subcategories->execute();

    $products = $conn->prepare('SELECT p.*, pc.name as category FROM products AS p INNER JOIN productcategory AS pc ON p.categoryID = pc.ID WHERE available = 1 ' . $categoryquery . $searchquery . $minpricequery . $maxpricequery . $orderquery . ' LIMIT ' . $currentRow . ', ' . $limit);
    $products->execute();

    $rowCounts = $conn->prepare('SELECT COUNT(*) as amount FROM products AS p INNER JOIN productcategory AS pc ON p.categoryID = pc.ID WHERE available = 1 ' . $categoryquery . $searchquery . $minpricequery . $maxpricequery);
    $rowCounts->execute();
    $rowCount = $rowCounts->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($rowCount['amount'] / $limit);
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
                    if(isset($_GET['categorie']) || isset($_GET['search'])) {
                        ?>
                        <li><a href="/shop">Toon alles</a></li>
                        <?php
                    }
                }
                ?>
            </ul>
            <span class="title">Prijs</span>
            <form method="get" class="price-form">
                <input type="number" class="price" name="minprice" id="min-price" min="<?php echo $productvar['minprice']; ?>" max="<?php echo $productvar['maxprice']; ?>" placeholder="<?php echo $productvar['minprice']; ?>" value="<?php echo $productvar['minprice']; ?>">
                <span>tot</span>
                <input type="number" class="price" name="maxprice" id="max-price" min="<?php echo $productvar['minprice']; ?>" max="<?php echo $productvar['maxprice']; ?>" placeholder="<?php echo $productvar['maxprice']; ?>" value="<?php echo $productvar['maxprice']; ?>">
                <button class="price-filter-btn">></button>
            </form>

            <?php echo $rowCount['amount']; ?> resultaten
        </div>
        <div class="shop-right">
            <div class="products-filters">
                <div class="left-filter">
                    <span>Sorteer op:</span>
                    <select class="select-filter" id="product-filter">
                        <option id="order-date-asc" name="date-asc" <?php if($order === 'date-asc') { echo 'selected'; } ?>>Datum oplopend</option>
                        <option id="order-date-desc" name="date-desc" <?php if($order === 'date-desc') { echo 'selected'; } ?>>Datum aflopend</option>
                        <option id="order-name" name="order-name" <?php if($order === 'order-name') { echo 'selected'; } ?>>Naam A-Z</option>
                        <option id="order-price-asc" name="price-asc" <?php if($order === 'price-asc') { echo 'selected'; } ?>>Prijs oplopend</option>
                        <option id="order-price-desc" name="price-desc" <?php if($order === 'price-desc') { echo 'selected'; } ?>>Prijs aflopend</option>
                    </select>
                </div>
                <div class="right-filter">
                    <span>Zoek:</span>
                    <form method="get" class="search-form">
                        <input type="text" name="search" class="search" value="<?php echo $search; ?>" placeholder="zoeken">
                    </form>
                </div>
            </div>
            <div class="shop-products">
            <?php
            if ($products->rowCount() > 0) {
                foreach ($products as $product) {
                    ?>
                    <div class="product">
                        <a href="/product?id=<?php echo $product["ID"]; ?>">
                            <img src="/assets/images/products/<?php echo $product["image"]; ?>">
                            <div class="product-description">
                                <b><?php echo $product["title"]; ?></b>
                                <i><?php echo $product["category"]; ?></i>
                                <span class="price">&euro; <?php echo str_replace('.', ',', $product["price"]); ?></span>
                            </div>
                        </a>
                        <div class="product-cart">
                            <form method="post" action="/shop?action=add&id=<?php echo $product["ID"]; ?>">
                                <input type="hidden" name="hidden_amount" value="1" />
                                <input type="hidden" name="hidden_name" value="<?php echo $product["title"]; ?>" />
                                <input type="hidden" name="hidden_price" value="<?php echo $product["price"]; ?>" />
                                <input type="hidden" name="hidden_image" value="<?php echo $product["image"]; ?>" />
                                <button type="submit" name="add_to_cart" class="cart-btn"><img src="/assets/images/cart.png"></button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<h1>Er konden geen producten gevonden worden op uw zoekwoord, probeer het nogmaals met een ander woord.</h1>';
            }
            ?>
            </div>
            <?php
            if ($products->rowCount() > 0) {
                ?>
                <div class="flex-pagination">
                    <?php
                        //Reset category Get because of products, only check for get in URL now.
                        if (isset($_GET['categorie'])) {
                            $category = $_GET['categorie'];
                        } else {
                            $category = '';
                        }
                        if ($_GET['pagina']) {
                            $current = $_GET['pagina'];
                            if ($current != 1) {
                                echo '<a href="/shop' . $category . '"> << </a>';
                                echo '<a href="?pagina=' . ($current - 1) . $category . '"> < </a>';
                            }
                        } else {
                            $current = 1;
                        }

                        for ($i = $current; $i <= $current + 2; $i++) {
                            if ($_GET['pagina'] == $i) {
                                echo '<a href="?pagina=' . $i . $category . '" class="current">' . $i . '</a>';
                            } elseif (empty($_GET['pagina']) && $i === 1) {
                                echo '<a href="?pagina=' . $i . $category . '" class="current">' . $i . '</a>';
                            } else {
                                if ($current != $total_pages) {
                                    if ($current != $total_pages - 1) {
                                        echo '<a href="?pagina=' . $i . $category . '">' . $i . '</a>';
                                    }
                                }
                            }
                        }
                        if ($_GET['pagina'] != $total_pages) {
                            if ($current <= $total_pages - 3) {
                                echo '<a href="#">...</a>';
                                echo '<a href="?pagina=' . $total_pages . $category . '">' . $total_pages . '</a>';
                            }
                            if ($current == $total_pages - 1) {
                                echo '<a href="?pagina=' . $total_pages . $category . '">' . $total_pages . '</a>';
                            }
                            if ($current != $total_pages) {
                                echo '<a href="?pagina=' . ($current + 1) . $category . '"> > </a>';
                                echo '<a href="?pagina=' . $total_pages . '"> >> </a>';
                            }
                        }
                    ?>
                </div>
                <?php
                }
                ?>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>