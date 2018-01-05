<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
$user = new User($conn);
$products = new Product($conn);
$categories = $products->getCategories();

$message = '';
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = $products->getProduct($id);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $categoryID = $_POST['category'];
        $available = $_POST['available'];
        $image = uniqid() . "-" . $_FILES['image']['name'];
        $imagefile = $_FILES['image'];

        if($products->editProduct($title, $description, $price, $categoryID, $available, $image, $imagefile, $id) === true) {
            $message = 'Product is succesvol gewijzigd!';
        } else {
            $message = 'Product kon niet worden gewijzigd, controleer als de geuploade afbeelding wel een jpg, png of jpeg bestand is!';
        }
        //Get product again to update values
        $product = $products->getProduct($id);
    }
    if ($product->rowCount() > 0) {
        foreach($product as $item) {
        ?>
        <a href="/dashboard/products" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
        <div class="content">
            <div class="dashboard-left">
                <form method="post" enctype="multipart/form-data">
                    <label>Product titel</label>
                    <input type="text" name="title" value="<?php echo $item["title"]; ?>" placeholder="Productnaam" required>
                    <label>Product beschrijving</label>
                    <textarea name="description" placeholder="Beschrijving" required><?php echo $item["description"]; ?></textarea>
                    <label>Product prijs</label>
                    <input type="number" name="price" value="<?php echo $item["price"]; ?>" placeholder="Prijs" step=".01" required>
                    <label>Product afbeelding</label>
                    <input type="file" name="image" id="image" value="<?php echo $item["image"]; ?>" onchange="readURL(this);">
                    <label>Productcategorie</label>
                    <select name="category">
                        <?php
                        foreach ($categories as $category) {
                            if($item["categoryID"] == $category['ID']) {
                                ?>
                                <option value="<?php echo $category['ID'] ?>" selected><?php echo $category['name']; ?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php echo $category['ID'] ?>"><?php echo $category['name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <span>Product beschikbaar:</span><br>
                    <input type="radio" class="radio-btn" name="available" value="1" <?php echo ($item['available'] == 1) ? 'checked="checked"' : ''; ?>> Ja
                    <input type="radio" class="radio-btn" name="available" value="0" <?php echo ($item['available'] == 0) ? 'checked="checked"' : ''; ?>> Nee
                    <input type="submit" value="Wijzigen">
                </form>
            </div>
            <div class="dashboard-right">
                <img id="product-image" src="/assets/images/products/<?php echo $item['image']; ?>">
            </div>
        </div>
        <?php
            echo $message;
        }
    } else {
        $user->redirect('/dashboard/products');
    }
}


include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');