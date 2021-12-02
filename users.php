<?php
session_start();
require("classes/database.php");
require("classes/users-classes.php");
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
                <div class="current-user">
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
                    if($user['login_status'] == 1) {
                        echo "<div class='content'>
                        <div class = 'details'>
                        <span input type='hidden' name='userid' id='userid' value" .$key. ">" .$user['name']. "</span>
                        <div class='status-dot'><i class='fas fa-circle'></i></div>
                        </div></div><hr/>";
                    } else {
                        echo "<div class='content'>
                        <div class = 'details'>
                        <span>" .$user['name']. "</span>
                        <div class='status-dot offline'><i class='fas fa-circle'></i></div>
                        </div></div><hr/>";
                    }
                    
                }
                echo "<a href='chatroom.php'>chatroom</a>";
            ?>
            

         </div>
        </section>
        </div>


    </body>
    <script src='//cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.4/socket.io.min.js'></script>
    <script>
        var socket = io.connect('https://site.test:436');
        console.log(socket);

        socket.on('connect', function () {
            console.log('connected');

            socket.on('broadcast', function (data) {
                //console.log(data);
                //socket.emit("broadcast", data);
                alert(data.text);
            });

            socket.on('disconnect', function () {
                console.log('disconnected');
            });
        }); 
    </script>
    </html>