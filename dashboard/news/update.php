<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);

    function uploadImage($image, $imagefile) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/news/";
        $target_file = $target_dir . basename($image);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        } else {
            move_uploaded_file($imagefile["tmp_name"], $target_file);
        }
    }

    function getNews($id) {
        global $conn;
        try {
            $data = $conn->prepare('SELECT p.*, pc.name as category FROM news AS p INNER JOIN newscategory AS pc ON p.categoryID = pc.ID WHERE p.ID = ' . $id);
            $data->execute();

            return $data;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    function editNews($title, $description, $category, $active, $image, $imagefile, $id) {
        global $conn;
        try {
            if($imagefile['name'] == '') {
                $stmt = $conn->prepare("UPDATE news SET title = :title, description = :description, active = :active, categoryID = :categoryID WHERE ID = " . $id);
            } else {
                $stmt = $conn->prepare("UPDATE news SET title = :title, description = :description, active = :active, image = :image, categoryID = :categoryID WHERE ID = " . $id);
                $stmt->bindparam(":image", $image);

                $newsitem = $conn->prepare("SELECT image FROM news WHERE ID = " . $id);
                $newsitem->execute();
                $newsitemimage = $newsitem->fetch(PDO::FETCH_ASSOC);

                $imageFileType = pathinfo(basename($image),PATHINFO_EXTENSION);
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    return false;
                } else {
                    uploadImage($image, $imagefile);
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/images/news/' . $newsitemimage['image']);
                }
            }

            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":description", $description);
            $stmt->bindparam(":active", $active);
            $stmt->bindparam(":categoryID", $category);
            $stmt->execute();

            return true;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    $id = $_GET["id"];
    $message = '';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $news = getNews($id);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];
            $categoryID = $_POST['category'];
            $active = $_POST['active'];
            $image = uniqid() . "-" . $_FILES['image']['name'];
            $imagefile = $_FILES['image'];

            if (editNews($title, $description, $categoryID, $active, $image, $imagefile, $id) === true) {
                $message = 'Nieuws is succesvol gewijzigd!';
            } else {
                $message = 'Nieuws kon niet worden toegevoegd, controleer als de geuploade afbeelding wel een jpg, png of jpeg bestand is!';
            }
            //Get newsitem again to update values
            $news = getNews($id);
        }
        $categories = $conn->prepare("SELECT * FROM newscategory");
        $categories->execute();

        $newsitems = $conn->prepare("SELECT nc.name AS category, n.* FROM news AS n INNER JOIN newscategory AS nc ON n.categoryID = nc.ID WHERE n.ID = '" .
            $id . "'");
        $newsitems->execute();

        foreach ($newsitems as $item) {
            $newscategory_name = $item["category"];
            $active = $item["active"];
            ?>

            <a href="/dashboard/news" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
            <div class="content">
                <div class="dashboard-left">
                    <form method="post" enctype="multipart/form-data">
                        <label>Nieuws titel</label>
                        <input type="text" name="title" value="<?php echo $item["title"]; ?>" placeholder="Titel" required>
                        <label>Nieuws beschrijving</label>
                        <textarea name="description" placeholder="Beschrijving" required><?php echo $item["description"]; ?></textarea>
                        <label>Nieuws afbeelding</label>
                        <input type="file" name="image" id="image" value="<?php echo $item["image"]; ?>"
                               onchange="readURL(this);">
                        <label>Nieuwscategorie</label>
                        <select name="category">
                            <?php
                                foreach ($categories as $ncn) {
                                    if ($newscategory_name == $ncn["name"]) {
                                        ?>
                                        <option value="<?php echo $ncn["ID"]; ?>"
                                                selected><?php echo $ncn["name"]; ?></option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="<?php echo $ncn["ID"]; ?>"><?php echo $ncn["name"]; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                        </select>
                        <span> Actief of non-actief: </span><br>
                        <input type="radio" class="radio-btn" name="active" value="1" <?php if ($active == 1) {
                            echo "checked='checked'";
                        } ?>> Ja
                        <input type="radio" class="radio-btn" name="active" value="0" <?php if ($active == 0) {
                            echo "checked='checked'";
                        } ?>> Nee
                        <input type="submit" name="submit" value="wijzigen">
                    </form>
                </div>
                <div class="dashboard-right">
                    <img id="product-image" src="/assets/images/news/<?php echo $item['image']; ?>">
                </div>
            </div>
            <?php
            echo $message;
        }
    }

    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
?>