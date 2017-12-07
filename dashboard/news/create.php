<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');

//
$categories = $conn->prepare("SELECT * FROM newscategory");
$categories->execute();
$category = $categories->fetchAll();
$categories = NULL;

//Functions


function uploadImage($image, $imagefile) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/news/";
    $target_file = $target_dir . basename($image);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    } else {
        move_uploaded_file($imagefile["tmp_name"], $target_file);
    }
}

function createProduct($title, $description, $image, $category, $imagefile, $checked)
{
    global $conn;
    try {
        $imageFileType = pathinfo(basename($image), PATHINFO_EXTENSION);
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo 'Het nieuwsartikel kon niet worden toegevoegd, controleer als de geuploade afbeelding wel een jpg, png of jpeg bestand is!';
            return false;
        } else {
            $stmt = $conn->prepare("INSERT INTO news(title, description, image, categoryID, checked) 
                                                       VALUES(:title, :description, :image, :categoryID, :checked)");
            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":description", $description);
            $stmt->bindparam(":image", $image);
            $stmt->bindparam(":categoryID", $category);
            $stmt->bindparam(":checked", $checked);
            $stmt->execute();
            $this->uploadImage($image, $imagefile);
            echo 'Nieuwsartikel is toegevoegd';
            return $stmt;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
    <div class="newscategory-form">
        <form method="post">
            <span> Titel artikel: </span> <br>
            <input type="text" name="title" placeholder="Titel" value="<?php echo $_POST['title']; ?>" required><br>
            <span> Beschrijving artikel: </span> <br>
            <input type="text" name="description" placeholder="Beschrijving" value="<?php echo $_POST['description']; ?>"required> <br>
            <span> Actief of non-actief: </span> <br>
            <input type="radio" name="active" value="true" required> Actief <input type="radio" name="active"
                                                                                   value="false"> Non-actief <br>
            <input type="file" name="image" id="image" onchange="readURL(this);" required><br>
            <select name="category">
                <?php
                foreach ($category as $item) {
                    ?>
                    <option value="<?php echo $item['ID'] ?>"><?php echo $item['name']; ?></option>
                    <?php
                }
                ?>
            </select><br>
            <input type="submit" name="submit" value="toevoegen">
        </form>
    </div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = uniqid() . "-" . $_FILES['image']['name'];
    $imagefile = $_FILES['image'];
    $categoryID = $_POST['category'];
    $checked = $_POST['active'];
    createProduct($title, $description, $image, $categoryID, $imagefile, $checked);
}
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');