<?php

class Product {

    private $db_conn;

    function __construct($db) {
        $this->db_conn = $db;
    }

    function createProduct ($name, $description, $type, $price) {
        if(!empty($name) && !empty($description) && !empty($type) && !empty($price)) {
            $sql ="SELECT ID FROM products WHERE Name=:name_IN AND Type=:type_IN";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":name_IN", $name);
            $stm->bindParam(":type_IN", $type);
        
            if(!$stm->execute()) {
                echo "unable to execute query";
                die();
            }

            $row = $stm->rowCount();
            if($row > 0) {

                echo "Product already exists";
                die();
            }

            $sql = "INSERT INTO products (Name, Description, Type, Price) VALUES(:name_IN, :description_IN, :type_IN, :price_IN)";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":name_IN", $name);
            $stm->bindParam(":description_IN", $description);
            $stm->bindParam(":type_IN", $type);
            $stm->bindParam(":price_IN", $price);

            if(!$stm->execute()) {
                echo "Could not execute query";
                die();
            }

            echo " Name:$name Description:$description Type:$type Price:$price";



        } else {
            echo " All arguments need values";
        }

        
    }
    
    function getAllProducts() {
        $sql = "SELECT name, description, type, price FROM products";
        $stm = $this->db_conn->prepare($sql);
        $stm->execute();
        echo json_encode($stm->fetchAll());
        
    }

    function getProduct($productId) {
        $sql = "SELECT ID, Name, Description, Type, Price FROM products WHERE ID=:productId_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":productId_IN", $productId);
        
        
        if(!$stm->execute()) {
            echo "Could not execute query";
        } else if($stm->rowCount() < 1 ) {
            echo "product does not exist";
        } else {
            $row = $stm->fetch();
            echo json_encode($row);
        }
    }

    function removeProduct($productId) {
        $sql = "DELETE FROM products WHERE ID=:productId_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam("productId_IN", $productId);
        $stm->execute();

        if($stm->rowCount() > 0) {
            echo "Product with id: $productId removed";
        } else {
            echo "No product with id: $productId found";
        }

    }

    function updateProduct($id, $name = "", $description = "", $type = "", $price = "") {
        
        $error = new StdClass();

        if(!empty($name)) {
            $error->message = $this->updateName($id, $name);
        }
        if(!empty($description)) {
            $error->message = $this->updateDescription($id, $description);
        }

        if(!empty($type)) {
            $error->message = $this->updateType($id, $type);
        }

        if(!empty($price)) {
            $error->message = $this->updatePrice($id, $price);
        }

        return $error;

    }

    function updateName($id, $name) {
        $sql = "UPDATE products SET Name=:name_IN WHERE ID=:id_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":id_IN", $id);
        $stm->bindParam(":name_IN", $name);
        $stm->execute();

        if($stm->rowCount() < 1) {
            return "No user with id:$id was found";
        }
    }

    function updateDescription($id, $description) {
        $sql = "UPDATE products SET Description=:description_IN WHERE ID=:id_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":id_IN", $id);
        $stm->bindParam(":description_IN", $description);
        $stm->execute();

        if($stm->rowCount() < 1) {
            return "No product with id:$id was found";
        }
    }

    function updateType($id, $type) {
        $sql = "UPDATE products SET Type=:type_IN WHERE ID=:id_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":id_IN", $id);
        $stm->bindParam(":type_IN", $type);
        $stm->execute();

        if($stm->rowCount() < 1) {
            return "No product with id:$id was found";
        }
    }

    function updatePrice($id, $price) {
        $sql = "UPDATE products SET Price=:price_IN WHERE ID=:id_IN";
        $stm = $this->db_conn->prepare($sql);
        $stm->bindParam(":id_IN", $id);
        $stm->bindParam(":price_IN", $price);
        $stm->execute();

        if($stm->rowCount() < 1) {
            return "No product with id:$id was found";
        }
    }
}
  
?>