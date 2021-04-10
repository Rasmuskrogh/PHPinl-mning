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