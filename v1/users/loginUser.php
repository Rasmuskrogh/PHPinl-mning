<?php

include("../../config/database.php");
include("../../objects/Users.php");


$username = $_GET["username"];
$password = $_GET["password"];

$token = "";
if(isset($_GET["token"])) {
    $token = $GET["token"];
} else {
    echo "No token specified";
}

$user = new User($db);
$return = new stdClass();
$return->token = $user->login($username, $password);
print_r(json_encode($return));

?> 