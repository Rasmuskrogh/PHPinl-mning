<?php

include("../../config/database.php");
include("../../objects/Products.php");
include("../../objects/Users.php");
    
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

    $product = new Product($db);
    $user = new User($db);
    $adminOrNot = $user->validateRole($token);

    if($user->validateToken($token)) {
        if($adminOrNot["Role"] === 'admin'){
            $product->createProduct("dsadss","adsads","addsa");
            print_r(json_encode($product));
        } else {
            echo "Not an admin";
        }
    
    } else {
        $error = new stdClass();
        $error->message ="You have been logged out. Please login again";
        $error->code = "0005";
        print_r(json_encode($error));
        die();
    }


?>