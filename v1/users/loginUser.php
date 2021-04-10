<?php

include("../../config/database.php");
include("../../objects/Users.php");


$username = $_GET["Username"];
$password = $_GET["Password"];


$user = new User($db);
$return = new stdClass();
$return->token = $user->login($username, $password);
print_r(json_encode($return));




