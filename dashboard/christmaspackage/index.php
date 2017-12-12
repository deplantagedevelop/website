<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    $contact = $conn->prepare('SELECT * FROM contact ORDER BY date DESC');
    $contact -> execute();

    $products = $product->getProducts();


?>
<table class="dash-table">
    <thead>
    <tr>
        <th>Toevoegen</th>
        <th>Productnaam</th>
        <th>Categorie</th>
        <th>Prijs</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($products as $item) {
        ?>
        <tr>
            <td><input type="checkbox" name="name1" /></td>
            <td><?php echo $item['title']; ?></td>
            <td><?php echo $item['category']; ?></td>
            <td><?php echo $item['price']; ?></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
<div class="packageform">
    <form method="post" enctype="multipart/form-data">
        <label>Kerstpakket titel</label>
        <input type="text" name="title" placeholder="Kerstpakketnaam" required>
        <label>Kerstpakket beschrijving</label>
        <textarea name="description" placeholder="Beschrijving" required></textarea>
        <label>Kerspakket prijs</label>
        <input type="number" name="price" placeholder="Prijs" required>
        <label>Kerspakket afbeelding</label>
        <input type="file" name="image" id="image" onchange="readURL(this);" required>
        <input type="submit" value="Toevoegen">
    </form>
</div>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

?>
