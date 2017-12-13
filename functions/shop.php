<?php
    class Shop {

        private $db;

        function __construct($conn) {
            //Use construct so we can use the current connection easily.
            $this->db = $conn;
        }

        public function createOrder($CustomerID, $status) {
            $stmt = $this->db->prepare("INSERT INTO orders(CustomerID, status) 
                                                       VALUES(:CustomerID, :status)");

            $stmt->bindparam(":CustomerID", $CustomerID);
            $stmt->bindparam(":status", $status);
            $stmt->execute();

            return $stmt;
        }

        public function createOrderLine($OrderID, $ProductID, $amount) {
            $stmt = $this->db->prepare("INSERT INTO orderlines(OrderID, ProductID, Amount) 
                                                       VALUES(:OrderID, :ProductID, :Amount)");

            $stmt->bindparam(":OrderID", $OrderID);
            $stmt->bindparam(":ProductID", $ProductID);
            $stmt->bindparam(":Amount", $amount);
            $stmt->execute();

            return $stmt;
        }
    }