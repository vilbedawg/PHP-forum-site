<?php
session_start();
// Kotisivu
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
require_once "includes/header.php";

$objUser = new Users;
$users = $objUser->GetAllUsers();

$objUser->setloginStatus(1);
$onliners = $objUser->GetAllOnliners();


?>

<body>

    <!--Modal section / julkaisu form-->
    <div class="bg-modal">
        <div class="modal-content">
            <!-- pienemmälle näytölle tarkoitettu dropdown menu -->
            <button type="button" class="dropbtn-modal" onclick="modalMenu()" style="margin: 0px ">Kategoriat</button>
            <div id="modalDropdown" class="modal-dropdown-content">
                <div class="category-item">Yleinen</div>
                <div class="category-item">Politiikka</div>
                <div class="category-item">Valokuvaus</div>
                <div class="category-item">Videot</div>
                <div class="category-item">Tarinat</div>
                <div class="category-item">Taide</div>
                <div class="category-item">Pelit</div>
                <div class="category-item">Elokuvat</div>
                <div class="category-item">Musiikki</div>
                <div class="category-item">Urheilu</div>
                <div class="category-item">Harrastukset</div>
                <div class="category-item" style="color: red;">NSFW</div>
            </div>
            <div class="modal-close"><i class="fas fa-times"></i>
            </div>
            <div class="modal-side-bar">
                <div class="profile-status">
                    <h1>Kategoriat</h1>
                </div>
                <div class="modal-categories">
                    <div class="category-item">Yleinen</div>
                    <div class="category-item">Politiikka</div>
                    <div class="category-item">Valokuvaus</div>
                    <div class="category-item">Videot</div>
                    <div class="category-item">Tarinat</div>
                    <div class="category-item">Taide</div>
                    <div class="category-item">Pelit</div>
                    <div class="category-item">Elokuvat</div>
                    <div class="category-item">Musiikki</div>
                    <div class="category-item">Urheilu</div>
                    <div class="category-item">Harrastukset</div>
                    <div class="category-item" style="color: red;">NSFW</div>
                </div>
            </div>

            <?php
            if (isset($_POST['post'])) {
                require_once "controllers/posts-contr.php";
                $title = $_POST['subject'];
                $topic = $_POST['topic'];
                $category = $_POST['category'];
                // uusi postContr luokka
                $post = new PostsContr($title, $topic, $category);
                $i = $post->PostTopic();
                // asetetaan olion user_id ja kutsutaan viimeisin julkaisu funktiota, 
                //jotta voidaan uudelleenohjata käyttäjä onnistuneen julkaisun jälkeen
                $objUser->setUserID($_SESSION['userid']);
                $mostRecent = $objUser->GetMostRecent();
                header('Location: view.php?room= ' . $mostRecent['MAX(post_id)'] . ' ');
            }

            ?>
            <div class="create-form">
                <form class="form-post" method="POST">
                    <div class="error-text">
                        <?php
                        if (!isset($_GET['error'])) {
                            echo "";
                        } else {
                            $signupCheck = $_GET['error'];
                            if ($signupCheck == "emptyinput") {
                                echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                            }
                            if ($signupCheck == "invalidTitle") {
                                echo "<div class='error-texti'><p>Otsikko sisältää ei sallittuja kirjaimia</p></div>";
                            }
                            if ($signupCheck == "invalidLength") {
                                echo "<div class='error-texti'><p>Otsikon täytyy olla 3-50 merkkiä</p></div>";
                            }
                            if ($signupCheck == "invalidCategory") {
                                echo "<div class='error-texti'><p>Valitse jokin kategoria listalta</p></div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group-box">
                        <div class="form-group-upper">
                            <label>Otsikko</label>
                            <?php if (isset($_GET['title'])) {
                                $formName = $_GET['title'];
                                echo '<input type="text" name="subject" id="subject" value="' . $formName . '">';
                            } else {
                                echo '<input type="text" name="subject" id="subject"></input>';
                            } ?>
                        </div>
                        <div class="form-group-upper" style="margin-bottom: 0;">
                            <label>Valitse kategoria</label>
                            <input type="text" name="category" id="category">
                        </div>
                        <div id="categorylist"></div>
                    </div>
                    <div class="form-group">
                        <label>Aihe</label>
                        <?php if (isset($_GET['topic'])) {
                            $formContent = $_GET['topic'];
                            echo '<textarea class="tinymce" name="topic" id="topic" rows="7">' . $formContent . '</textarea>';
                        } else {
                            echo '<textarea class="tinymce" name="topic" id="topic" rows="7"></textarea>';
                        } ?>

                        <div class="post-topic-button">
                            <input type="submit" name="post" value="Julkaise" id="post">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal section loppuu-->


    <div class="search-toolbar">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">
                <div class="drop-icons"><i class="fa fa-home" aria-hidden="true" style="margin-right: 5px;"></i>Koti</div> <i class="fas fa-angle-down"></i>
            </button>
            <div id="myDropdown" class="dropdown-content">
                <a href="home.php?show=Etusivu">Etusivu</a>
                <?php if (isset($_SESSION['userid'])) {
                    echo '<a href="profile.php?user=' . $_SESSION['userid'] . '">Profiili</a>';
                    echo '<a href="manage.php?user=' . $_SESSION['userid'] . '">Muokkaa profiilia</a>';
                    echo '<button class="create dropdown" style="width: 100%; border-radius: 0;">Luo uusi</button>';
                } ?>

            </div>
        </div>
        <div class="search">
        <i class="fa fa-search" aria-hidden="true" style="position: absolute; z-index: 1; right: 20px;"></i>
            <input type="text" id="post-search" placeholder="Etsi julkaisu...">
            <div class="post-category-list"></div>
        </div>
        <div class="buttons">
            <?php if (isset($_SESSION['userid'])) {
                echo '<a href="logout.php"><button class="logout"><i class="fas fa-sign-out-alt"></i></button></a>';
            } else {
                echo '<a href="login.php"><button class="logout"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>';
            }
            ?>
        </div>

    </div>
    <div class="home-filler">
    </div>

    <div class="navbar-menu">
        <?php if (isset($_GET['show'])) {
            echo '<h1 class="current-user-parent">' . $_GET['show'] . '</h1>';
        } else {
            echo '<h1 class="current-user-parent">Koti</h1>';
        } ?>
    </div>
    <div class="navbar-menu-hidden">
        <?php if (isset($_GET['show'])) {
            echo '<p class="current-user-parent">' . $_GET['show'] . '</p>';
        } else {
            echo '<p class="current-user-parent">Koti</p>';
        } ?>
    </div>





    <div class="home">
        <div class="discussion-page">
            <div class="sort-table">
                <a href="home.php?show=<?php echo $_GET['show']; ?>&sort=New" id="new"><i class="fas fa-long-arrow-alt-up"></i> Uusin</a>
                <a href="home.php?show=<?php echo $_GET['show']; ?>&sort=Old" id="old"><i class="fas fa-long-arrow-alt-down"></i> Vanhin</a>
                <a href="home.php?show=<?php echo $_GET['show']; ?>&sort=Popular" id="popular">Suosituin</a>
            </div>
            <?php
        
            // GET parametrin avulla voidaan fillteröidä julkaisuja.
            $postObj = new PostedContent;
            if (isset($_GET['sort'], $_GET['show']) && $_GET['show'] !== 'Etusivu') {
                if ($_GET['sort'] == 'New') {
                    $posts = $postObj->getAllPostsByCategory($_GET['show']);
                } else if ($_GET['sort'] == 'Old') {
                    $posts = $postObj->getCategoryPostsOldest($_GET['show']);
                } else if ($_GET['sort'] == 'Popular') {
                    $posts = $postObj->getMostLikedPostByCategory($_GET['show']);
                }
            } else if (isset($_GET['sort'],  $_GET['show']) && $_GET['show'] == 'Etusivu') {

                if ($_GET['sort'] == 'New') {
                    $posts = $postObj->getAllPostsByNewest();
                } else if ($_GET['sort'] == 'Old') {
                    $posts = $postObj->getAllPostsByOldest();
                } else if ($_GET['sort'] == 'Popular') {
                    $posts = $postObj->getMostLikedPosts();
                }
            } else {
                $posts = $postObj->getAllPostsByNewest();
            }


            foreach ($posts as $post) {
                //aika merkkijonoksi ja oikean muotoiseksi
                $mysqldate = strtotime($post['date']);
                $phpdate = date('d/m/Y G:i A', $mysqldate);

                // Haetaan kaikki kommentit ja tykkäykset $post_id muuttujan avulla
                $comments = $postObj->getAllComments($post['post_id']);
                $likes = $postObj->getLikesPost($post['post_id']);

                // null jos käyttäjä ei ole kirjautunut sisään
                $likeStatus = null;
                $status = null;
                if (isset($_SESSION['userid'])) {
                    $likeStatus = $postObj->userLikedPost($_SESSION['userid'], $post['post_id']);
                    $status = $postObj->likeStatusPost($likeStatus, $likes);
                }

                echo "<div class='room-container' data-id='" . $post['post_id'] . "'>
                    <div class='like-buttons' data-id='" . $post['post_id'] . "'>
                    " . $status . "
                    </div>
                        <div class='room'>
                                <div class='date-and-post' style='padding: 0px 12px;'>
                                    <div class='date-users'>
                                        <p class='username-users' data-id='" . $post['user_id'] . "'>" . $post['name'] . "</p>
                                        <p>" . $phpdate . "</p>
                                    </div>
                                    <h1 class='user-post'>" . $post['title'] . "</h1>
                                    </div> 
                                    <div class='bodytext-users'><p>" . $post['topic'] . "</p></div>
                                    <div class='post-footer'>
                                    <div class='hashtag'>
                                    " . $post['category'] . " </div>
                                    <div class='post-toolbar-users'>
                                    <i class='far fa-comment-alt'></i>
                                     <p> " . $comments['comment_amount'] . " kommenttia </p>
                                    </div>
                                    </div>
                                    </div>
                            </div>";
            }
            ?>
        </div>

        <div class="side-menu">
            <div class="profile-users">
                <div class="profile-status">
                    <h1>Käyttäjätiedot</h1>
                </div>
                <div class="about">
                    <div class="member-amount">
                        <p class="amount"><?php echo count($users); ?></p>
                        <p>Jäsentä</p>
                    </div>
                    <div class="members-online">
                        <p class="amount"><?php echo count($onliners); ?></p>
                        <p>paikalla</p>
                    </div>
                </div>


                <?php if (isset($_SESSION['userid'])) {
                    echo '<div class="users-link"><button class="create" style="width: 90%; border-radius: 20px;">Luo uusi</button></div>
                      <a href="profile.php?user=' . $_SESSION['userid'] . '"><div class="users-link"><button class="logout" style="width: 90%; border-radius: 20px; margin-left: 0;">Käyttäjätiedot</button></div><a>
                      <p style="width: 90%; position: absolute; bottom: 5px; left: 5px;">Kirjautunut sisään käyttäjällä <b>' . $_SESSION['name'] . '</b></p>';
                } else {
                    echo '<a href="login.php"><div class="users-link"><button class="logout" style="width: 90%; border-radius: 20px; margin-left: 0;">Kirjaudu sisään</button></div><a>';
                } ?>

            </div>
            <div class="side-bar">
                <div class="profile-status">
                    <h1>Kategoriat</h1>
                </div>
                <div class="categories">
                    <a href="home.php?show=Etusivu&sort=New" class="category-item" style="font-weight: 500;">Kaikki</a>
                    <a href="home.php?show=Yleinen&sort=New" class="category-item">Yleinen</a>
                    <a href="home.php?show=Politiikka&sort=New" class="category-item">Politiikka</a>
                    <a href="home.php?show=Valokuvaus&sort=New" class="category-item">Valokuvaus</a>
                    <a href="home.php?show=Videot&sort=New" class="category-item">Videot</a>
                    <a href="home.php?show=Tarinat&sort=New" class="category-item">Tarinat</a>
                    <a href="home.php?show=Taide&sort=New" class="category-item">Taide</a>
                    <a href="home.php?show=Pelit&sort=New" class="category-item">Pelit</a>
                    <a href="home.php?show=Elokuvat&sort=New" class="category-item">Elokuvat</a>
                    <a href="home.php?show=Musiikki&sort=New" class="category-item">Musiikki</a>
                    <a href="home.php?show=Urheilu&sort=New" class="category-item">Urheilu</a>
                    <a href="home.php?show=Harrastukset&sort=New" class="category-item">Harrastukset</a>
                    <a href="home.php?show=NSFW&sort=New" class="category-item" style="color: red;">NSFW</a>
                </div>
            </div>
        </div>
    </div>
    <a href="" class="scrollup">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#333" viewBox="0 0 24 24">
            <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z" />
        </svg>
    </a>

    <!-- pienemmälle näytölle tarkoitettu -->
    <div class="footer-bar">
        <?php if (isset($_SESSION['userid'])) {
            echo '<span><a href="profile.php?user=' . $_SESSION['userid'] . '"><button class="logout" style="margin: 0; border: 1px solid #ccc; background-color: transparent;
                box-shadow: none; padding: 10px 15px; color: black;">Käyttäjätiedot</button></a></span>';
        } ?>
        <span class="fixed-create"><button class="create" style=" border-radius: 50%; padding: 10px 15px;">+</button></span>
        <span><button class="dropbtn-footer" onclick="footerMenu()" style="margin: 0px ">Kategoriat</button>
            <div id="FooterDropdown" class="footer-dropdown-content">
                <a href="home.php?sort=New&show=Etusivu" class="category-item" style="font-weight: 500;">Kaikki</a>
                <a href="home.php?sort=New&show=Yleinen" class="category-item">Yleinen</a>
                <a href="home.php?sort=New&show=Politiikka" class="category-item">Politiikka</a>
                <a href="home.php?sort=New&show=Valokuvaus" class="category-item">Valokuvaus</a>
                <a href="home.php?sort=New&show=Videot" class="category-item">Videot</a>
                <a href="home.php?sort=New&show=Tarinat" class="category-item">Tarinat</a>
                <a href="home.php?sort=New&show=Taide" class="category-item">Taide</a>
                <a href="home.php?sort=New&show=Pelit" class="category-item">Pelit</a>
                <a href="home.php?sort=New&show=Elokuvat" class="category-item">Elokuvat</a>
                <a href="home.php?sort=New&show=Musiikki" class="category-item">Musiikki</a>
                <a href="home.php?sort=New&show=Urheilu" class="category-item">Urheilu</a>
                <a href="home.php?sort=New&show=Harrastukset" class="category-item">Harrastukset</a>
                <a href="home.php?sort=New&show=NSFW" class="category-item">NSFW</a>
            </div>
        </span>
    </div>
    <script src="js/app.js"></script>
    <script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\init-tinymce.js"></script>
    <script>

        // javascriptiä
        //----------------------------//
        $(document).ready(function() {
            $("p").has("img").css({
                "textAlign": "center",
                "background": "black",
                "margin": "0",
                "color": "transparent",
            });
            $("p").has("iframe").css({
                "textAlign": "center",
                "background": "black",
                "margin": "auto",
                "padding-bottom": "25px"
            });

            //----------------------------//
            //room container linkit
            $(document).on('click', '.username-users', function(e) {
                e.stopPropagation();
                var id = $(this).data('id');
                window.location = "profile.php?user=" + id;
            });
            $(document).on('click', ".room-container", function(e) {
                e.stopPropagation();
                e.preventDefault;
                var id = $(this).data('id');
                window.location = "view.php?room=" + id;
            });

            //----------------------------//
            var hash = window.location.hash;
            if (hash == "#newpost") {
                $('.bg-modal').css('display', 'flex');
            }

            if (window.location.href.indexOf("New") > -1) {
                $('#new').css({
                    'background-color': '#dddd',
                    'border-radius': '10px'
                });
            } else if (window.location.href.indexOf("Old") > -1) {
                $('#old').css({
                    'background-color': '#dddd',
                    'border-radius': '10px'
                });
            } else if (window.location.href.indexOf("Popular") > -1) {
                $('#popular').css({
                    'background-color': '#dddd',
                    'border-radius': '10px'
                });
            }

        });
    </script>

</body>

</html>