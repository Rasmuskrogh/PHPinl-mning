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

if($user->validateToken($token) && !empty($_GET["ID"])) {
    $product->getProduct($_GET["ID"]);
print_r(json_encode($product));

} else {
    $error = new stdClass();
    $error->message ="You have been logged out. Please login again";
    $error->code = "0005";
    print_r(json_encode($error));
    die();
}

/* if(!empty($_GET["id"])) {
$product->getProduct($_GET["id"]);
} else {
    echo "No id specified";
}*/
?>
 