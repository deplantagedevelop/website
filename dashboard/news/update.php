<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
$url = "/";
$id = $_GET["id"];
$changed = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = uniqid() . "-" . $_FILES['image']['name'];
    $imagefile = $_FILES['image'];

    if ($imagefile['name'] == '') {
        $stmt = $conn->prepare("UPDATE news SET title= :title, description = :description WHERE id=:id");

    } else {
        $stmt = $conn->prepare("UPDATE news SET title = :title, description = :description, image = :image WHERE id= :id ");
        $stmt->bindparam(":image", $image);

        $product = $conn->prepare("SELECT image FROM news WHERE ID = " . $id);
        $product->execute();

        $productimage = $product->fetch(PDO::FETCH_ASSOC);
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/news/";
        $target_file = $target_dir . basename($image);
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            return false;
        } else {
            unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/images/news/' . $productimage['image']);
            move_uploaded_file($imagefile["tmp_name"], $target_file);
        }
    }
}
$categories = $conn->prepare("SELECT * FROM newscategory");
$categories->execute();
$category = $categories->fetchAll();
$categories = NULL;
$newsitems = $conn->prepare("SELECT nc.name, n.checked, image, title, description FROM news AS n INNER JOIN newscategory AS nc ON n.categoryID = nc.ID WHERE n.ID = '" . $id . "'");
$newsitems->execute();
$newsitem = $newsitems->fetchAll();
$newsitems = NULL;


foreach ($newsitem as $item) {

    $newscategory_name = $item["name"];
    $active = $item["checked"];

    ?>

    <a href="/dashboard/news_category"> ga terug </a> <br> <br>

    <form class="newscategory-form" method="post">
        <input type="text" name="title" value="<?php echo $item["title"]; ?>" placeholder="Productnaam" required><br>
        <textarea name="description" placeholder="Beschrijving"
                  required><?php echo $item["description"]; ?></textarea><br>
        <input type="file" name="image" id="image" value="<?php echo $item["image"]; ?>" onchange="readURL(this);"><br>
        <span> Categorienaam: </span> <br>
        <select name="category">
            <?php
            foreach ($category as $ncn) {
                if ($newscategory_name == $ncn["name"]) {
                    ?>
                    <option value="<?php echo $ncn["ID"]; ?>" selected><?php echo $ncn["name"]; ?></option>
                    <?php
                } else {
                    ?>
                    <option value="<?php echo $ncn["ID"]; ?>"><?php echo $ncn["name"]; ?></option>
                    <?php
                }
            }
            ?>
        </select> <br>
        <span> Actief: </span> <br>
        <input type="radio" name="active" value="true" <?php if ($active == "true") {
            echo "checked='true'";
        } ?>> Ja
        <input type="radio" name="active" value="false" <?php if ($active == "false") {
            echo "checked='true'";
        } ?>> Nee <br> <br>
        <input type="submit" name="submit" value="wijzigen">
    </form>

    <?php
}
if ($changed) {
    echo "Uw wijzigen zijn opgeslagen! <a href='index.php'>  Terug naar nieuwscategorieën </a>";
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
function uploadImage($image, $imagefile)
{
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/products/";
    $target_file = $target_dir . basename($image);
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    } else {
        move_uploaded_file($imagefile["tmp_name"], $target_file);
    }
}

?>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#product-image')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>