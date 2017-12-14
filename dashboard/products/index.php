<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    $products = $product->getProducts();
    if ($products->rowCount() > 0) {
    ?>
        <table class="dash-table">
           <thead>
                <tr>
                    <th>Productnaam</th>
                    <th>Categorie</th>
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
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo ($item['available'] == 1) ? 'Ja' : 'Nee'; ?></td>
                    <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="/dashboard/products/edit?id=<?php echo $item['ID']; ?>">Bewerk</a></td>
                    <td><i class="fa fa-trash-o" aria-hidden="true"></i> <a href="/dashboard/products/delete?id=<?php echo $item['ID']; ?>">Verwijder</a></td>
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
    <a href="/dashboard/products/create" class="create-btn">Product toevoegen</a>

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

