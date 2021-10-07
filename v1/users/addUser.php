<?php

include("../../config/database.php");
include("../../objects/Users.php");


$user = new User($db);
$user-> createUser("Rasmus","Krogh-Andersen","rasmus.kroghandersen@gmail.com","lampscyco","mersedes");