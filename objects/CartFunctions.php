<?php

    class Cart {

        private $db_conn;

        function __construct($db) {
            $this->db_conn = $db;
        }

        function addToCart($productId, $userId) {
            $userSql = "SELECT ID FROM users WHERE Username=:username_IN";
            $stm = $this->$db_conn->prepare($userSql);
            bindParam(":username_IN", $username);
            $stm->execute();
            $userId = $stm->fetch();

            $productSql = "SELECT ID FROM products WHERE Name=:name_IN";
            $stm = $this->$db_conn->prepare($productSql);
            bindParam(":name_IN", $name);
            $stm->execute();
            $productId = $stm->fetch();

            $sql ="INSERT INTO cart(UserID, ProductID) VALUES(:userId_IN, :productId_IN)";
            $stm = $this->$db_conn->prepare($sql);
            bindParam(":userId_IN", $userId);
            bindParam(":productId_IN", $productId);
            
            if(!$stm->execute()) {
                echo "Could not execute query";
                die();
            }

            echo "Product with ID: $productId added to cart by User: $userId";


        }
    }