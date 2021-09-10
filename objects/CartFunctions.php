<?php

    class Cart {

        private $db_conn;

        function __construct($db) {
            $this->db_conn = $db;
        }

        function addToCart($productId, $userId, $username, $name, $price, $token) {
            $userSql = "SELECT ID FROM users WHERE Username=:username_IN";
            $stm = $this->db_conn->prepare($userSql);
            $stm->bindParam(":username_IN", $username);
            $stm->execute();
            $userId = $stm->fetch();

            $productSql = "SELECT ID FROM products WHERE Name=:name_IN";
            $stm = $this->db_conn->prepare($productSql);
            $stm->bindParam(":name_IN", $name);
            $stm->execute();
            $productId = $stm->fetch();

            /* if(!empty($userId) && !empty($productId)) {
            $sql = "SELECT UserID, ProductID, Token FROM cart WHERE UserID=:userId_IN AND ProductID=:productId_IN AND Token=:token_IN";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":userId_IN", $userId[0]);
            $stm->bindParam(":productId_IN", $productId[0]);
            $stm->bindParam(":token_IN", $token);

            if(!$stm->execute()) {
                echo "unable to execute query";
                die();
            }

            $row = $stm->rowCount();
            if($row > 0) {
                echo "product already in cart";
                die();
            } */

            $sql ="INSERT INTO cart(UserID, ProductID, Token) VALUES(:userId_IN, :productId_IN, :token_IN)";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":userId_IN", $userId[0]);
            $stm->bindParam(":productId_IN", $productId[0]);
            $stm->bindParam(":token_IN", $token);

            if(!$stm->execute()) {
                echo "Could not execute query";
                die();
            }

            return "Product with ID: $productId[0] with added to cart by User: $userId[0]";
        }

        /* function Checkout ($token, $userId, $productId, $username, $productName) { */
        function Checkout ($username, $productName, $userId, $productId) {   
            $sql ="SELECT Username FROM users WHERE ID=:userId_IN";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":userId_IN", $userId);
            $stm->execute();
            $username = $stm->fetch();

            $sql ="SELECT Name FROM products WHERE ID=:productId_IN";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":productId_IN", $productId);
            $stm->execute();
            $productName = $stm->fetch();

            return "$productName, $username";



        }            
    }
    