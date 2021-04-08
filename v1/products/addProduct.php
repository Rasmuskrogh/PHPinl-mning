<?php

include("../../config/database.php");
include("../../objects/Products.php");


$product = new Product($db);
$product-> createProduct("dsads","adsads","addsa");
?>