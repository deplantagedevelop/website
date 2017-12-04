<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    $categories = $product->getCategories();

    if(!$user->is_loggedin()) {
        $user->redirect('/404');
    }

    include('../header.php');
    ?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Productnaam"><br>
        <textarea name="description" placeholder="Beschrijving"></textarea><br>
        <input type="text" name="price" placeholder="Prijs"><br>
        <input type="file" name="image" id="image"><br>
        <select name="category">
            <?php
            foreach($categories as $category) {
                ?>
                <option value="<?php echo $category['ID'] ?>"><?php echo $category['name']; ?></option>
                <?php
            }
            ?>
        </select><br>
        <input type="submit" value="Toevoegen"><br>
    </form>
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $image = uniqid() . "-" . $_FILES['image']['name'];
        $imagefile = $_FILES['image'];
        $categoryID = $_POST['category'];

        $product->createProduct($title, $description, $price, $image, $categoryID, $imagefile);

        echo 'Product toegevoegd!';
    }


    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');