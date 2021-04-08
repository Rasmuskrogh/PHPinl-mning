<?php

include("../../config/database.php");
include("../../objects/Users.php");


$user = new User($db);
$user-> createUser("Ted","Moseby","ted.moseby@bmail.com","Architectdude","123");