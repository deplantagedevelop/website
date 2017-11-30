<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    if(!$user->is_loggedin()) {
        $user->redirect('/404');
    }

    $products = $product->getProducts();
    if ($products->rowCount() > 0) {
    ?>
        <table>
           <thead>
                <tr>
                    <th>Productnaam</th>
                    <th>Categorie</th>
                    <th>Prijs</th>
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
                    <td><?php echo $item['price']; ?></td>
                    <td><a href="#">Bewerk</a></td>
                    <td><a href="#">Verwijder</a></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    <?php
    } else {
        echo 'Geen producten gevonden';
    }
?>

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

