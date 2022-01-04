<?php

session_start();
require_once "classes/database.php";
require_once "classes/logout-classes.php";
//tuhotaan sessio
$userObj = new Logout();
$userObj->updateLogoutStatus();
session_unset();
session_destroy();
header("location: login.php");
?>
