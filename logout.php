<?php

session_start();
include "classes/database.php";
include "classes/logout-classes.php";
$userObj = new Logout();
$userObj->updateLogoutStatus();
session_unset();
session_destroy();
header("location: index.php");
?>
