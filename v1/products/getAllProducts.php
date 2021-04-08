<?php

    include("../../config/database.php");
    include("../../objects/Products.php");
    include("../../objects/Users.php");
    

    $token = "";
    if(isset($_GET["Token"])) {
        $token = $GET["Token"];
    } else {
        echo "No token specified";
    die();
    }

    $product = new Product($db);

    if($product->validateToken($token)) {
        $products = $product->getAllProducts();
        print_r(json_encode($products));
    } else {
        echo "You have been logged out. Please login again to continue shopping.";
    }
?> 