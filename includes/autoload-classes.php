<?php
//automaattinen luokkien liittäminen ja lataaminen 
spl_autoload_register('AutoLoader');
function AutoLoader($className) {
    $path = "classes/";
    $ext = "-classes.php";
    $fullPath = $path . $className . $ext;

    if(!file_exists($fullPath)) {
        return false;
    }

    include_once $fullPath;
}

?>