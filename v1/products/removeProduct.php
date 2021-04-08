<?php

include("../../config/database.php");
include("../../objects/Products.php");

    $product = new Product($db);

    if(!empty($_GET["id"])) {
        echo json_encode($product->removeProduct($_GET["id"]));
    } else {
        "id not specified";
    }


?>