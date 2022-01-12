<?php
//automaattinen luokkien liittäminen ja lataaminen 
spl_autoload_register('AutoLoader');
function AutoLoader($className) {
    $path = "classes/";
    $ext = "-classes.php";
    $fullPath = $path . strtolower($className) . $ext;

    if(!file_exists($fullPath)) {
        die($fullPath);
    }

    include_once $fullPath;
}

?>