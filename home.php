<?php
session_start();

require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';


include_once "includes/header.php";
$objUser = new Users;
$users = $objUser->GetAllUsers();

$objUser->setloginStatus(1);
$onliners = $objUser->GetAllOnliners();



?>
<script>
    $(document).ready(function() {
        $('#category').keyup(function() {
            var query = $(this).val();
            if(query != '')
            {
                $.ajax({
                   url:"search.php",
                   method: "POST",
                   data: {query:query},
                   success:function(data)
                   {
                       $('#categorylist').fadeIn();
                       $('#categorylist').html(data);
                   },
                   error:function(data)
                   {
                        $('#categorylist').fadeIn();
                        $('#categorylist').html('Jokin meni vikaan');
                   }
                });
            }
        });
    });
</script>
<body>


    <!--Modal section-->
    <div class="bg-modal">
        <div class="modal-content">
            <div class="modal-close"><i class="fas fa-times"></i>
            </div>
            <div class="modal-categories">
            <div class="modal-side-bar">
            <div class="profile-status">
                <h1>Kategoriat</h1>
            </div>
            <div class="modal-categories">
                <a href="home.php?show=Yleinen">Yleinen</a>
                <a href="home.php?show=Politiikka">Politiikka</a>
                <a href="home.php?show=Valokuvaus">Valokuvaus</a>
                <a href="home.php?show=Videot">Videot</a>
                <a href="home.php?show=Tarinat">Tarinat</a>
                <a href="home.php?show=Taide">Taide</a>
                <a href="home.php?show=Pelit">Pelit</a>
                <a href="home.php?show=Elokuvat">Elokuvat</a>
                <a href="home.php?show=Musiikki">Musiikki</a>
                <a href="home.php?show=Urheilu">Urheilu</a>
                <a href="home.php?show=Harrastukset">Harrastukset</a>
                <a href="home.php?show=NSFW" style="color: red;">NSFW</a>
            </div>
            </div>
            </div>

            <?php
            if (isset($_POST['post'])) {
                include_once "controllers/posts-contr.php";
                $title = $_POST['subject'];
                $topic = $_POST['topic'];
                $category = $_POST['category'];
                $post = new PostsContr($title, $topic, $category);
                $post->PostTopic();

                $objUser->setUserID($_SESSION['userid']);
                $mostRecent = $objUser->GetMostRecent();
                header('Location: view.php?room= '. $mostRecent[0]['MAX(post_id)'] .' ');
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
                    }
                    ?>
                </div>
                    <div class="form-group-upper">
                        <label>Otsikko</label>
                    <?php if(isset($_GET['title'])) {
                         $formName = $_GET['title'];
                        
                        echo '<input type="text" name="subject" id="subject" value="'.$formName.'">';
                        } else {
                            echo '<input type="text" name="subject" id="subject"></input>';
                        } ?>
                   
                        <label>Valitse kategoria</label>
                        <input type="text" name="category" id="category" placeholder=""> 
                    </div>
                    <div id="categorylist"></div>
                    <div class="form-group">
                        <label>Aihe</label>
                        <?php if(isset($_GET['topic'])) {
                         $formContent = $_GET['topic'];
                        echo '<textarea class="tinymce" name="topic" id="topic" rows="7">'. $formContent .'</textarea>';
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

    <div class="home-filler">
    </div>
    <div class="navbar">
        <div class="navbar-menu">
            <div class="current-user-parent">
            <a href="users.php"><h1>Rawr <i class="fa fa-rocket" aria-hidden="true" style="transform: rotate(45deg);"></i></h1></a>
            </div>
            <div class="buttons">
                <?php if(isset($_SESSION['userid'])) {
                    echo '<a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>';
                }else {
                    echo '<a href="login.php"><button class="logout">Kirjaudu sisään</button></a>';
                }
                ?>
            </div>
        </div>
        <div class="search-toolbar">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn"><i class="fa fa-home" aria-hidden="true"></i> Koti</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="users.php">Kotisivu</a>
                <?php if(isset($_SESSION['userid'])) { 
                    echo '<a href="profile.php?user='. $_SESSION['userid'] .'">Profiili</a>';
                    echo '<a href="edit.php?user='. $_SESSION['userid'] .'">Muokkaa profiilia</a>';
                    echo '<button class="create dropdown" style="width: 100%; border-radius: 0;">Luo uusi</button>';
                     } ?>
                
            </div>
            </div>
            <div class="search">
                <button><i class="fas fa-search"></i></button>
                <input type="text" placeholder="Etsi julkaisu...">
            </div>
            
                 <button class="create">Luo uusi</button>
            
        </div>
    </div>

   

    <div class="home">                        
        <div class="discussion-page">

            <?php
            $postObj = new PostedContent;
            if(isset($_GET['show'])) {
                $posts = $postObj->getAllPostsByCategory($_GET['show']);
            } else {
                $posts = $postObj->getAllPostsByNewest();
            }
            
            foreach ($posts as $post) {
                $mysqldate = strtotime($post['date']);
                $phpdate = date('Y/m/d G:i A', $mysqldate);
                $comments = $postObj->getAllComments($post['post_id']);
                $roomAmount = count($comments);
                echo "<div class='room-container' data-id='". $post['post_id'] ."'>
                        <div class='room'>
                                <div class='date-and-post'>
                                    <div class='date-users'>
                                        <p class='username-users' data-id='". $post['user_id'] ."'>" . $post['name'] . "</p>
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
                                     <p> ". $roomAmount ." kommenttia </p>
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
                <div class="member-amount"><p class="amount"><?php echo count($users); ?></p><p>Jäsentä</p> </div>
                <div class="members-online"><p class="amount"><?php echo count($onliners); ?></p> <p>paikalla</p> </div>
            </div>
            
            
            <?php if(isset($_SESSION['userid'])){
                echo '<div class="users-link"><button class="create" style="width: 90%; border-radius: 20px;">Luo uusi</button></div>
                      <a href="profile.php?user='. $_SESSION['userid'] .'"><div class="users-link"><button class="logout" style="width: 90%; border-radius: 20px; margin-left: 0;">Käyttäjätiedot</button></div><a>
                      <p style="width: 70%; position: absolute; bottom: 5px; left: 5px;">Kirjautunut sisään käyttäjällä <b>'. $_SESSION['name'] .'</b></p>';
            } else {
                echo '<a href="login.php"><div class="users-link"><button class="logout" style="width: 90%; border-radius: 20px; margin-left: 0;">Kirjaudu sisään</button></div><a>';
            }?>
            
        </div>
        <div class="side-bar">
            <div class="profile-status">
                <h1>Kategoriat</h1>
            </div>
            <div class="categories">
                <a href="home.php?show=Yleinen">Yleinen</a>
                <a href="home.php?show=Politiikka">Politiikka</a>
                <a href="home.php?show=Valokuvaus">Valokuvaus</a>
                <a href="home.php?show=Videot">Videot</a>
                <a href="home.php?show=Tarinat">Tarinat</a>
                <a href="home.php?show=Taide">Taide</a>
                <a href="home.php?show=Pelit">Pelit</a>
                <a href="home.php?show=Elokuvat">Elokuvat</a>
                <a href="home.php?show=Musiikki">Musiikki</a>
                <a href="home.php?show=Urheilu">Urheilu</a>
                <a href="home.php?show=Harrastukset">Harrastukset</a>
                <a href="home.php?show=NSFW">NSFW</a>
            </div>
            
        </div>
        </div>
        </div>
        <a href="" class="scrollup">
        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#4895ef" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z"/></svg>
        </a>

        <script src="js/app.js"></script>
        <script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
        <script type="text/javascript" src="tinymce\tinymce.min.js"></script>
        <script type="text/javascript" src="tinymce\init-tinymce.js"></script>
        <script src="js/dropdown.js"></script>  
        <script>
        $(document).ready(function() {
            $("p").has("img").css({"textAlign" : "center",
                                    "background" : "black",
                                    "margin-left" : "0",
                                    "color" : "transparent",
            });
            $("p").has("iframe").css({"textAlign" : "center",
                                    "background" : "black",
                                    "margin-left" : "0",
            });  
            //----------------------------//
            //room container linkit
            $(".username-users").on('click', function(e){
                    e.preventDefault;
                    e.stopPropagation();
                    var id = $(this).data('id');
                    window.location = "profile.php?user="+id;
                });
                $(".room-container").on('click', function(e){
                        e.preventDefault;
                        var id = $(this).data('id');
                        window.location = "view.php?room="+id;
                });         
            });
        </script> 

</body>
</html>