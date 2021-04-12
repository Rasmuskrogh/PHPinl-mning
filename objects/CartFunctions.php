<?php

    class Cart {

        private $db_conn;

        function __construct($db) {
            $this->db_conn = $db;
        }

        function addToCart($productId, $userId, $username, $name) {
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

            if(!empty($userId) && !empty($productId)) {
                $sql = "SELECT UserID, ProductID FROM cart WHERE UserID=:userId_IN AND ProductID=:productId_IN";
                $stm = $this->db_conn->prepare($sql);
                $stm->bindParam(":userId_IN", $userId[0]);
                $stm->bindParam(":productId_IN", $productId[0]);

                if(!$stm->execute()) {
                    echo "unable to execute query";
                    die();
                }

                $row = $stm->rowCount();
                if($row > 0) {
                    echo "product already in cart";
                    die();
                }

                $sql ="INSERT INTO cart(UserID, ProductID) VALUES(:userId_IN, :productId_IN)";
                $stm = $this->db_conn->prepare($sql);
                $stm->bindParam(":userId_IN", $userId[0]);
                $stm->bindParam(":productId_IN", $productId[0]);

                if(!$stm->execute()) {
                    echo "Could not execute query";
                    die();
                }

                return "Product with ID: $productId[0] with added to cart by User: $userId[0]";
            }

        }
    }