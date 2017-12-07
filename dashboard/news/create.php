<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
$user = new User($conn);

$categories = $conn->prepare("SELECT * FROM newscategory");
$categories->execute();

function uploadImage($image, $imagefile) {
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/news/";
    $target_file = $target_dir . basename($image);
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    } else {
        move_uploaded_file($imagefile["tmp_name"], $target_file);
    }
}

function createArticle($title, $description, $image, $category, $imagefile, $active)
{
    global $conn;
    try {
        $imageFileType = pathinfo(basename($image), PATHINFO_EXTENSION);
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo 'Het nieuwsartikel kon niet worden toegevoegd, controleer als de geuploade afbeelding wel een jpg, png of jpeg bestand is!';
            return false;
        } else {
            $stmt = $conn->prepare("INSERT INTO news(title, description, image, categoryID, active) 
                                                       VALUES(:title, :description, :image, :categoryID, :active)");
            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":description", $description);
            $stmt->bindparam(":image", $image);
            $stmt->bindparam(":categoryID", $category);
            $stmt->bindparam(":active", $active);
            $stmt->execute();
            uploadImage($image, $imagefile);
            echo 'Nieuwsartikel is toegevoegd';
            return $stmt;
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

?>
    <a href="/dashboard/news" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
    <div class="content">
        <div class="dashboard-left">
            <form method="post" enctype="multipart/form-data">
                <label>Nieuws titel</label>
                <input type="text" name="title" placeholder="Titel" required>
                <label>Nieuws beschrijving</label>
                <textarea name="description" placeholder="Beschrijving" required></textarea>
                <label>Nieuws afbeelding</label>
                <input type="file" name="image" id="image" onchange="readURL(this);" required>
                <label>Nieuwscategorie</label>
                <select name="category">
                    <?php
                    foreach ($categories as $item) {
                        ?>
                        <option value="<?php echo $item['ID'] ?>"><?php echo $item['name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <span> Actief of non-actief: </span><br>
                <input type="radio" class="radio-btn" name="active" value="1" checked="checked"> Ja
                <input type="radio" class="radio-btn" name="active" value="0"> Nee<br>
                <input type="submit" name="submit" value="Toevoegen">
            </form>
        </div>
        <div class="dashboard-right">
            <img id="product-image">
        </div>
    </div>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $image = uniqid() . "-" . $_FILES['image']['name'];
    $imagefile = $_FILES['image'];
    $categoryID = $_POST['category'];
    $active = $_POST['active'];
    createArticle($title, $description, $image, $categoryID, $imagefile, $active);
}
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');