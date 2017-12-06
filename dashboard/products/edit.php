<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
$user = new User($conn);
$products = new Product($conn);

$categories = $products->getCategories();
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = $products->getProduct($id);
    if ($product->rowCount() > 0) {
        foreach($product as $item) {
        ?>
        <div class="content">
            <div class="dashboard-left">
                <form method="post" enctype="multipart/form-data">
                    <input type="text" name="title" value="<?php echo $item["title"]; ?>" placeholder="Productnaam" required>
                    <textarea name="description" placeholder="Beschrijving" required><?php echo $item["description"]; ?></textarea>
                    <input type="number" name="price" value="<?php echo $item["price"]; ?>" placeholder="Prijs" required>
                    <input type="file" name="image" id="image" value="<?php echo $item["image"]; ?>" onchange="readURL(this);">
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
                                }
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <input type="submit" value="Wijzigen">
                </form>
            </div>
            <div class="dashboard-right">
                <img id="product-image" src="/assets/images/products/<?php echo $item['image']; ?>">
            </div>
        </div>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $categoryID = $_POST['category'];
                $image = uniqid() . "-" . $_FILES['image']['name'];
                $imagefile = $_FILES['image'];
                var_dump($imagefile);
                exit;

                $products->editProduct($title, $description, $price, $categoryID, $image, $imagefile, $id);


            }
        }
    } else {
        $user->redirect('/dashboard/products');
    }
}


include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');