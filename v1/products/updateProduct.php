<?php

include("../../config/database.php");
include("../../objects/Products.php");
include("../../objects/Users.php");


$id = "";
$name = "";
$description = "";
$type = "";

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

if(isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    echo "id note specified";
}

if(isset($_GET["name"])) {
    $name = $_GET["name"];
}

if(isset($_GET["description"])) {
    $description = $_GET["description"];
}

if(isset($_GET["type"])) {
    $type = $_GET["type"];
}

$product = new Product($db);
$user = new User($db);
$adminOrNot = $user->validateRole($token);

if($user->validateToken($token)) {
    if($adminOrNot["Role"] === 'admin'){
        if(!empty($_GET["id"])) {
            echo json_encode($product->updateProduct($id, $name, $description, $type));
        } else {
            "id not specified";
        }
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