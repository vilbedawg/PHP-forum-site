<?php

session_start();
include "classes/database.php";
include "classes/logout-classes.php";
$userObj = new Logout();
if($_SESSION['login_status'] == 3){
    echo 'banned';
}
$userObj->updateLogoutStatus();
session_unset();
session_destroy();
header("location: login.php");
?>
