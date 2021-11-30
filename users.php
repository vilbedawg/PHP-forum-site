<?php
session_start();
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
                    echo"Offline";
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

            <a href="chatroom.php">chatroom</a>

         </div>
        </section>
        </div>

        <script src="./src/js/users.js"></script>
    </body>
    </html>