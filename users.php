<?php
session_start();
require("classes/database.php");
require("classes/GetUsers.php");
$objUser = new Users;
$users = $objUser->GetAllUsers();





if(!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit(); 
}
include_once "header.php";
?>
<body>
    <div class="wrapper">
        <section class="users">
           <header>
               <div class="content">
                <div class="details">
                <span><?php echo $_SESSION["name"] ?></span>
                <p><?php if($_SESSION["login"] == 1){
                    echo "Online";
                    } else {
                    echo "Offline";
                    } ?></p>
               </div>
            </div>
            <a href="logout.php" class="logout">Kirjaudu ulos</a>
           </header>
           <div class="search" id="search">
               <span class="text">Etsi käyttäjä</span>
               <input type="text" placeholder="Anna nimi..." >
               <button><i class="fas fa-search"></i></button>
        </div>
         <div class="users-list">
            <?php
                foreach ($users as $key => $user) {
                    echo  "Jatketaan tästä huomenna";
                    // if($user['login_status'] == 1) {
                    //     $color = "background-color: green";
                    //     echo "<tr><td>". " " .$user['name']. "<td>";
                    //     echo "<td><span class='status' style=".$color."><i class='fas fa-circle'></i></span></td>";
                    // } else {
                    //     $color = "color: red";
                    //     echo "<td> <br>". " " .$user['name'] . " Last logged in " . $user['last_login']."</td></tr>";
                    // }
                }
            ?>
            <a href="chatroom.php">chatroom</a>

         </div>
        </section>
        </div>


    </body>
    </html>