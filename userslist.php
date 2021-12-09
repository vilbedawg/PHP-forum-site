<div class="wrapper">
            <section class="users">
            <div class="current-user">
                <span><?php echo $_SESSION["name"] ?></span>
                <p><?php if ($_SESSION["login"] == 1) {
                        echo "Online";
                    } else {
                        echo "Offline";
                    } ?></p>
            </div>
                <div class="search" id="search">
                    <span class="text">Etsi käyttäjä</span>
                    <input type="text" placeholder="Anna nimi...">
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="users-list">
                    <?php
                    foreach ($users as $key => $user) {
                        $name = $user['name'];
                        if ($user['login_status'] == 1) {
                            echo "<div class='content'>
                        <div class = 'details'>
                        <span input type='hidden' name='userid' id='userid' value" . $key . ">" . $user['name'] . "</span>
                        <div class='status-dot'><i class='fas fa-circle'></i></div>
                        </div></div><hr/>";
                        } else {
                            echo "<div class='content'>
                        <div class = 'details'>
                        <span>" . $user['name'] . "</span>
                        <div class='status-dot offline'><i class='fas fa-circle'></i></div>
                        </div></div><hr/>";
                        }
                    }
                    ?>
                </div>
            </section>
        </div>