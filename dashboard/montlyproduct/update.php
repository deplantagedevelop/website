<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];

    $monthlyproduct = $conn->prepare("SELECT * FROM monthly_product WHERE ID= :id");
    $monthlyproduct->execute(array(
    ':id' => $id));


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $image = uniqid() . "-" . $_FILES['image']['name'];
        $imagefile = $_FILES['image'];

        if($imagefile['name'] == '') {
            $stmt = $conn->prepare("UPDATE monthly_product SET title=:title, description=:description WHERE id=:id");
        } else {
            $stmt = $conn->prepare("UPDATE monthly_product SET title = :title, description = :description, image = :image WHERE id= :id ");
            $stmt->bindparam(":image", $image);

            $product = $conn->prepare("SELECT image FROM monthly_product WHERE ID = " . $id);
            $product->execute();
            $productimage = $product->fetch(PDO::FETCH_ASSOC);

            $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/monthlyproducts/";
            $target_file = $target_dir . basename($image);
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                return false;
            } else {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/images/monthlyproducts/' . $productimage['image']);
                move_uploaded_file($imagefile["tmp_name"], $target_file);
            }
        }


        $stmt->bindparam(":title", $_POST["title"]);
        $stmt->bindparam(":description", $_POST["description"]);
        $stmt->bindparam(":id", $id);
        $stmt->execute();

        $monthlyproduct = $conn->prepare("SELECT * FROM monthly_product WHERE ID= :id");
        $monthlyproduct->execute(array(
            ':id' => $id));
    }

    while ($row = $monthlyproduct->fetch()) {
        $title = $row["title"];
        $description = $row["description"];
        $currentimage = $row["image"];
    }
?>

<form class="update-monthlyproduct" method="post" enctype="multipart/form-data">
    <img src="/assets/images/monthlyproducts/<?php echo $currentimage ?>"> <br>
    <input type="file" name="image" id="image"><br> <br>
    Titel: <br>
    <input type="text" name="title" value="<?php echo "$title";?>"> <br> <br>
    Beschrijving: <br>
    <textarea name="description"><?php echo "$description";?></textarea> <br>
    <input type="submit" name="submit" value="submit">
</form>

