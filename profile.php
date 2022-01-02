<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
include_once "includes/header.php";

$objUser = new Users;
$users = $objUser->GetAllUsers();

$objUser->setloginStatus(1);
$onliners = $objUser->GetAllOnliners();

$postObj = new PostedContent;
$posts = $postObj->GetAllPostsByID($_GET['user']);

$objUser->setUserID($_GET['user']);
$userOnView = $objUser->GetViewedUser();
$userlist = $objUser->GetAllUsersButMe();
?>

<body>
    <!--Modal section-->
    <div class="bg-modal">
        <div class="modal-content">
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
                include_once "controllers/posts-contr.php";
                $title = $_POST['subject'];
                $topic = $_POST['topic'];
                $category = $_POST['category'];
                
                $post = new PostsContr($title, $topic, $category);
                $i = $post->PostTopic();
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
                        if ($signupCheck == "invalidCategory") {
                            echo "<div class='error-texti'><p>Valitse jokin kategoria listalta</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="form-group-box">
                    <div class="form-group-upper">
                        <label>Otsikko</label>
                    <?php if(isset($_GET['title'])) {
                         $formName = $_GET['title'];
                        
                        echo '<input type="text" name="subject" id="subject" value="'.$formName.'">';
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
    <div class="search-toolbar">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn"><div class="drop-icons"><i class="fa fa-home" aria-hidden="true" style="margin-right: 5px;"></i> Koti</div> <i class="fas fa-angle-down"></i></button>
            <div id="myDropdown" class="dropdown-content">
                <a href="home.php?show=Etusivu">Etusivu</a>
                <?php if(isset($_SESSION['userid'])) { 
                    echo '<a href="profile.php?user='. $_SESSION['userid'] .'">Profiili</a>';
                    echo '<a href="manage.php?user='. $_SESSION['userid'] .'">Muokkaa profiilia</a>';
                    echo '<button class="create dropdown" style="width: 100%; border-radius: 0;">Luo uusi</button>';
                     } ?>
                
            </div>
            </div>
            <div class="search">
                <input type="text" id="post-search" placeholder="Etsi julkaisu...">
                <div class="post-category-list"></div>
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
    <div class="home-other">
        <?php
        if(isset($_GET['/noexist'])) {
        echo "<div class='noexist-box'>
            <h1>Käyttäjä ei ole olemassa :(</h1>
            <a href='home.php?show=Etusivu'><button class='logout'>Takaisin kotisivulle</button></a>
            </div>";
        }
            echo
            '
            <div class="home-users">
            <div class="profile">
            <div class="profile-status">
                <h1>Käyttäjätiedot</h1>
            </div>
            <div class="profile-managment">
            <span style="display: flex; align-self: flex-start;">
            <img src="' . $userOnView[0]['image'] . '"></img>
            <p style="font-size: 20px; align-self: center; padding-left: 5px;"><b>' . $userOnView[0]['name'] . '</b></p>
            </span>
              <div class="profile-details">
              <p> ' . $userOnView[0]['email'] . ' </p>
              <p style="font-size: 14px;"> Käyttäjä luotu ' .  date('m/d/Y', strtotime($userOnView[0]['created'])) . ' </p>
              </div>
              </div> 
              <hr>
              ';

            if (isset($_SESSION['userid']) && $_SESSION['userid'] == $userOnView[0]['user_id']) {
                echo '<a href="manage.php?user=' . $_SESSION['userid'] . '" class="edit-btn">
                <button class="edit" type="submit" name="user" value="' . $_SESSION['userid'] . '">
                    Muokkaa profiilia
                </button>
                </a>';
            }
        echo ' 
              <button class="profile-create">Luo uusi</button>
            </div>
            <div class="discussion-page-users">
            <a href="home.php?show=Etusivu" style="width: 100px;"><button class="profile-back" style="width: 100%;">Etusivulle</button></a>
            ';

            if (count($posts) == 0 ) {
                echo '<div class="room" style="justify-content: center;" ><h1>Ei julkaisuja</h1></div>';
            }
            foreach ($posts as $post) {
                $mysqldate = strtotime($post['date']);
                $phpdate = date('d/m/Y G:i A', $mysqldate);
                $comments = $postObj->getAllComments($post['post_id']);
                echo
                '<div class="room-container" data-id="'. $post['post_id'] .'">';             
                if (isset($_SESSION['userid']) && ($post['user_id'] === $_SESSION['userid'])) {
                    echo '<div class="delete-post" data-id="'. $post['post_id'] .'">           
                    <button class="delete-post-btn" id="delete-post"><i class="fa fa-times" aria-hidden="true"></i></div></button>
                    <div class="edit-post" data-id="'. $post['post_id'] .'">
                    <button class="edit-post-btn"><i class="fas fa-edit"></i></div></button>
                    ';
                    }
                    echo
                    ' 
                    <div class="room">
                    <div class="date-and-post">
                        <div class="date-users">
                        <p class="username-users">' . $post['name'] . '</p>
                        <p>' . $phpdate . '</p>
                        </div>
                        <h1 class="user-post">' . $post['title'] . '</h1>
                        </div> 
                        <div class="bodytext-users"><p>' . $post['topic'] . '</p></div>
                        <div class="post-footer">
                        <div class="hashtag">
                        ' . $post['category'] . ' </div>
                    <div class="post-toolbar-users">
                    <i class="far fa-comment-alt"></i>
                        <p> ' . $comments['comment_amount'] . ' kommenttia </p>
                    </div>
                    </div>
                    </div>
                </div>
                ';
            }
     
        ?>
        <?php if (isset($_SESSION['userid']) && $_SESSION['userid'] == 0) {
            echo "";
        } else {
        ?>

            <section class="user-list-body">
                <div class="user-list-arrows">
                    <div class="show-list">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z" />
                        </svg>
                    </div>
                    <div class="hide-list">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z" />
                    </svg>
                    </div>
                </div>
                <div class="every-user">
                    <div class="table-wrapper">
                        <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Käyttäjänimi</th>
                                    <th>Sähköposti</th>
                                    <th>Luotu</th>
                                    <th>Status</th>
                                    <th>Asetukset</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($userlist as $user) {
                                    echo  "<tr id='". $user['user_id'] ."'>
                                            <td><a href='profile.php?user=" . $user['user_id'] . "' class='user-table-id'>" . $user['user_id'] . "</a></td>
                                            <td>" . $user['name'] . "</td>
                                            <td>" . $user['email'] . "</td>
                                            <td>" . $user['created'] . "</td>
                                            <td>";
                                    if (($user['login_status']) == 1) {
                                        echo " <i class='fa fa-circle' aria-hidden='true' style='color: green'></i> ";
                                    } else {
                                        echo " <i class='fa fa-circle' aria-hidden='true' style='color: gray'></i> ";
                                    } ?>
                                    </td>
                                    <td>
                                    <button class="delete">Poista käyttäjä</button>
                                    </td>
                                    </tr>
                                <?php } ?>
                            <tbody>
                        </table>
                    </div>
                </div>
    </div>
<?php
        }
?>
</section>

<script type="text/javascript">
    $(document).ready(function() {
        $(".delete").click(function(){
            var id = $(this).parents("tr").attr("id");
            if(confirm(' Haluatko varmasti poistaa käyttäjän ?'))
            {
                $.ajax({
                url: 'search.php',
                type: 'GET',
                data: {id: id},
                error: function() {
                    alert('Jokin meni vikaan');
                },
                success: function(data) {
                        $("#"+id).remove();
                        alert("Käyttäjä numero " + id + " poistettiin.");  
                        $('.table-wrapper').stop().slideDown("normal", function(){
                        $('.table-wrapper').css('display', 'flex');
                        $(".show-list").hide();
                        $(".hide-list").show();
                    });
                }
            });
            }
        });
        $(".delete-post").on('click', function(e){
            e.preventDefault;
            e.stopPropagation();
            var id = $(this).data('id');
            var room = $(this).parent();
            if(confirm('Haluatko varmasti poistaa julkaisun?'))
            {
                thisPost = $(this).parents('.room-container').find('.bodytext-users');
                $(thisPost).find("img").each(function () {
                    var imgName = $(this).attr('src');
                    $.ajax({
                        url: 'search.php',
                        type: 'POST',
                        data: {
                            imgName: imgName
                        },
                        dataType: "html",
                        success: function(data) {}
                    });
                });
                $.ajax({
                url: 'search.php',
                type: 'GET',
                data: {deleteid: id},
                dataType: "html",
                error: function() {
                    alert("Jokin meni vikaan");
                },
                success: function(data) {
                    room.remove();
                }
            });
            }
        });
    });
</script>

<a href="" class="scrollup">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#333" viewBox="0 0 24 24">
        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z" />
    </svg>
</a>
<script src="js/app.js"></script>
<script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\init-tinymce.js"></script>
 
<script>
//----------------------------//
//room container linkit
$(document).ready(function(){
    $(".edit-post").on('click', function(e){
        e.preventDefault;
        e.stopPropagation();
        var id = $(this).data('id');
        window.location = "view.php?room="+id+"&edit";
    });
    $(".room-container").on('click', function(e){
            e.preventDefault;
            var id = $(this).data('id');
            window.location = "view.php?room="+id;
    });
    $("p").has("img").css({"textAlign" : "center",
    "background" : "black",
    "margin-left" : "0",
    "color" : "transparent",
    });
    $("p").has("iframe").css({"textAlign" : "center",
        "background" : "black",
        "margin-left" : "0",
    });
});
</script>
</body>
<?php
?>
</html>