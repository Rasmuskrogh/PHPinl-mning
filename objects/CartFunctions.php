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


        function Checkout ($token) {   
             $sql ="SELECT b.*, c.firstname, c.lastname
            FROM cart a
            JOIN products b
            ON a.productID = b.ID
            JOIN users c
            ON a.userID = c.ID
            WHERE a.Token=:Token_IN";
            $stm = $this->db_conn->prepare($sql);
            $stm->bindParam(":Token_IN", $token);
            $stm->execute();
            $row= $stm->fetch();
            echo "Köpare:", " ", $row["firstname"], " ", $row["lastname"]; 
            echo ("<br>");
            echo ("<br>");
            echo "Produkter:";
            while ($row= $stm->fetch()) {
                echo ("<pre>");
                echo "Name:", $row["Name"], " ", "Type:", $row["Type"], " ", "Description:", $row["Description"], " ", "Price", $row["Price"];
                echo ("</pre>");
            }
        }            
    }
    