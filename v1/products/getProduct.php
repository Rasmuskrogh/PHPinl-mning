<?php

include("../../config/database.php");
include("../../objects/Products.php");

$product = new Product($db);

if(!empty($_GET["id"])) {
$product->getProduct($_GET["id"]);
} else {
    echo "No id specified";
}
?>
