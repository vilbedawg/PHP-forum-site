<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
$user = new Users();





//Hakukentän täyttö
if(isset($_POST['query'])) {
    $inpText = $_POST['query'];
    $output = '';
    $stmt = $user->connect()->prepare("SELECT * FROM categories WHERE name LIKE :name");
    $stmt->execute(['name' => '%' . $inpText . '%']);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        foreach ($result as $row) {
          echo  '<p class="list-group-item list-group-item-action border-1">' . $row['name'] . '</p>';
        }
      } else {
        echo '<p class="list-group-item border-1">No Record</p>';
      }
}
?>