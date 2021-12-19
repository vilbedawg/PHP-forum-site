<?php
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
include_once "includes/header.php";


$user = new Users();

$db = connect();
$stmt = $db->prepare('SELECT * FROM users');
$stmt->execute();
$db = null;



?>