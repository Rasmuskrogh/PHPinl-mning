<?php

include("../../config/database.php");
include("../../objects/Products.php");

$id = "";
$name = "";
$description = "";
$type = "";


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
echo json_encode($product->updateProduct($id, $name, $description, $type));
?>