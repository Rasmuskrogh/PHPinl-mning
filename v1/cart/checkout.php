<?php

    include("../../config/database.php");
    include("../../objects/Users.php");
    include("../../objects/Products.php");
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
    $product = new Product($db);

    if($user->validateToken($token)) {

        $token = $_GET["Token"];
 print_r($cart->Checkout($token)); 
    }

    ?>
