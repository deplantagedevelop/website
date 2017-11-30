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
}