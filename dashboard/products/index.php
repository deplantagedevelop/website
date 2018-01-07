<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    //Check for page request
    $limit = 20;
    if(empty($_GET['pagina'])) {
        $currentRow = 0;
        $_GET['pagina'] = 0;
    } else {
        if(is_numeric($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
            $currentRow = ($pagina - 1) * $limit;
        } else {
            $user->redirect('/dashboard/products');
        }
    }

    if(isset($_GET['search'])) {
        $search = $_GET['search'];
        $searchquery = ' WHERE p.title LIKE "%' . $search . '%"';
    } else {
        $search = '';
        $searchquery = '';
    }

    $products = $product->getProducts($searchquery, $currentRow, $limit);

    $rowCounts = $conn->prepare('SELECT COUNT(*) as amount FROM products AS p' . $searchquery);
    $rowCounts->execute();
    $rowCount = $rowCounts->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($rowCount['amount'] / $limit);
?>
    <div class="content-header">
        <a href="/dashboard/product_category" class="back-btn"><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;
            Categorieën</a>
        <form method="get" class="search-product">
            <input type="text" name="search" class="search" value="<?php echo $search; ?>" placeholder="Zoeken">
        </form>
    </div>
    <div class="content">
    <?php
        if ($products->rowCount() > 0) {
            ?>
            <table class="dash-table">
                <thead>
                <tr>
                    <th>Productnaam</th>
                    <th>Categorie</th>
                    <th>Subcategorie</th>
                    <th>Prijs</th>
                    <th>Beschikbaar</th>
                    <th>Bewerken</th>
                    <th>Verwijderen</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($products as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['title']; ?></td>
                            <td><?php echo $item['category']; ?></td>
                            <td><?php echo $item['subcategory']; ?></td>
                            <td><?php echo $item['price']; ?></td>
                            <td><?php echo ($item['available'] == 1) ? 'Ja' : 'Nee'; ?></td>
                            <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a
                                        href="/dashboard/products/edit?id=<?php echo $item['ID']; ?>">Bewerk</a></td>
                            <td><i class="fa fa-trash-o" aria-hidden="true"></i> <a onclick="return confirm('Weet u zeker dat u het product wil verwijderen?');"
                                        href="/dashboard/products/delete?id=<?php echo $item['ID']; ?>">Verwijder</a></td>
                        </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
            <?php
        } else {
            echo 'Geen producten gevonden<br>';
        }
    ?>
    </div>
    <?php
    if($products->rowCount() > 0) {
        ?>
        <div class="flex-pagination">
            <?php
                //Reset category Get because of products, only check for get in URL now.
                if (isset($_GET['categorie'])) {
                    $category = $_GET['categorie'];
                } else {
                    $category = '';
                }

                if(isset($_GET['search'])) {
                    $search = '&search=' . $_GET['search'];
                } else {
                    $search = '';
                }

                if ($_GET['pagina']) {
                    $current = $_GET['pagina'];
                    if ($current != 1) {
                        echo '<a href="/dashboard/products/?pagina=' . ($current - 1) . $search .'"> << </a>';
                        echo '<a href="?pagina=' . ($current - 1) . $search . '"> < </a>';
                    }
                } else {
                    $current = 1;
                }

                for ($i = $current; $i <= $current + 2; $i++) {
                    if ($_GET['pagina'] == $i) {
                        echo '<a href="?pagina=' . $i . $search . '" class="current">' . $i . '</a>';
                    } elseif (empty($_GET['pagina']) && $i === 1) {
                        echo '<a href="?pagina=' . $i . $search . '" class="current">' . $i . '</a>';
                    } else {
                        if ($current != $total_pages) {
                            if ($current != $total_pages - 1) {
                                echo '<a href="?pagina=' . $i . $search . '">' . $i . '</a>';
                            }
                        }
                    }
                }
                if ($_GET['pagina'] != $total_pages) {
                    if ($current <= $total_pages - 3) {
                        echo '<a href="#">...</a>';
                        echo '<a href="?pagina=' . $total_pages . $search . '">' . $total_pages . '</a>';
                    }
                    if ($current == $total_pages - 1) {
                        echo '<a href="?pagina=' . $total_pages . $search . '">' . $total_pages . '</a>';
                    }
                    if ($current != $total_pages) {
                        echo '<a href="?pagina=' . ($current + 1) . $search . '"> > </a>';
                        echo '<a href="?pagina=' . $total_pages . $search . '"> >> </a>';
                    }
                }
            ?>
        </div>
        <?php
    }
    ?>
    <a href="/dashboard/products/create" class="create-btn">Product toevoegen</a>

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

