<?php
class Product {

    private $db;

    function __construct($conn) {
        //Use construct so we can use the current connection easily.
        $this->db = $conn;
    }

    public function deleteProduct($id) {
        try {
            $product = $this->db->prepare("SELECT image FROM products WHERE ID = " . $id);
            $product->execute();
            $productimage = $product->fetch(PDO::FETCH_ASSOC);

            $stmt = $this->db->prepare("DELETE FROM products WHERE ID = " . $id);
            $stmt->execute();
            unlink($_SERVER['DOCUMENT_ROOT'] . '/assets/images/products/' . $productimage['image']);

            return $stmt;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createProduct($title, $description, $price, $image, $category, $imagefile) {
        try {
            $imageFileType = pathinfo(basename($image),PATHINFO_EXTENSION);
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                echo 'Product kon niet worden toegevoegd, controleer als de geuploade afbeelding wel een jpg, png of jpeg bestand is!';
                return false;
            } else {
                $stmt = $this->db->prepare("INSERT INTO products(title, description, price, image, categoryID) 
                                                       VALUES(:title, :description, :price, :image, :categoryID)");

                $stmt->bindparam(":title", $title);
                $stmt->bindparam(":description", $description);
                $stmt->bindparam(":price", $price);
                $stmt->bindparam(":image", $image);
                $stmt->bindparam(":categoryID", $category);
                $stmt->execute();
                $this->uploadImage($image, $imagefile);
                echo 'Product is toegevoegd';
                return $stmt;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function editProduct($title, $description, $price, $category, $id) {
        try {
            $stmt = $this->db->prepare("UPDATE products SET title = :title, description = :description, price = :price, categoryID = :categoryID WHERE ID = " . $id);
            $stmt->bindparam(":title", $title);
            $stmt->bindparam(":description", $description);
            $stmt->bindparam(":price", $price);
            $stmt->bindparam(":categoryID", $category);
            $stmt->execute();
            echo 'Product is succesvol gewijzigd!';

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

    public function getProduct($id) {
        try {
            $data = $this->db->prepare('SELECT p.*, pc.name as category FROM products AS p INNER JOIN productcategory AS pc ON p.categoryID = pc.ID WHERE p.ID = ' . $id);
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

    public function uploadImage($image, $imagefile) {
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/assets/images/products/";
        $target_file = $target_dir . basename($image);
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {

        } else {
            move_uploaded_file($imagefile["tmp_name"], $target_file);
        }
    }
}