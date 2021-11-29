<?php
include_once "header.php";
session_start();
?>
<body>
    <div class="wrapper">
        <section class="users">
           <header>
               <div class="content">
                <div class="details">
            <?php
                if(isset($_SESSION["userid"]))
                {
            ?>
                <span><?php echo $_SESSION["name"] ?></span>
                <p><?php echo $_SESSION["login"] ?></p>
            <?php
                }
                else{
                header("location: login.php");
                exit();  
                }
            ?>
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

            

         </div>
        </section>
        </div>

        <script src="./src/js/users.js"></script>
    </body>
    </html>