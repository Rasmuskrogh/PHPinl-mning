<?php

    include("../../config/database.php");
    include("../../objects/Products.php");
    include("../../objects/Users.php");
    include("../../objects/CartFunctions.php");

    $token = "";
    if(isset($_GET["Token"])) {
        $token = $_GET["Token"];
    } else {
        $error = new stdClass();
        $error->message ="Please login to access this page";
        $error->code = "0004";
        print_r(json_encode($error));
        die();
    }

    $user = new User($db);
    $cart = new Cart($db);

    if($user->validateToken($token)) {
        
        $productId= $_GET["ProductID"];
        $Name= $_GET["Name"];
        $UserId=$_GET["UserID"];
        $Username=$_GET["Username"];
        print_r($cart->addToCart($productId, $UserId, $Username, $Name));

    } else {
        $error = new stdClass();
        $error->message ="You have been logged out. Please login again";
        $error->code = "0005";
        print_r(json_encode($error));
        die();
    }

    ?>

