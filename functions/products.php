<?php
class Product {

    private $db;

    function __construct($conn) {
        //Use construct so we can use the current connection easily.
        $this->db = $conn;
    }

    public function createProduct($title, $description, $price, $image, $category) {
        try {
            $stmt = $this->db->prepare("INSERT INTO products(title, description, price, image, categoryID) 
                                                       VALUES(:title, :description, :price, :image, :categoryID)");

            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":description", $description);
            $stmt->bindparam(":price", $price);
            $stmt->bindparam(":image", $image);
            $stmt->bindparam(":categoryID", $category);
            $stmt->execute();

            return $stmt;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getProducts() {
        try {
            $data = $this->db->prepare('SELECT p.*, pc.name as category FROM products AS p INNER JOIN productcategory AS pc ON p.categoryID = pc.ID');
            $data->execute();

            return $data;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getCategories() {
        try {
            $data = $this->db->prepare('SELECT * FROM productcategory');
            $data->execute();

            return $data;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function uploadImage() {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/products/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

            } else {
                echo "Sorry, het bestand kon niet worden geupload.";
            }
        }
    }
}