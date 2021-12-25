<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
require_once 'controllers/comment-contr.php';
require_once "controllers/posts-contr.php";
require_once "includes/header.php";



// kaikki postaukset 
$roomNum = $_GET['room'];

// Kaikki kommentit
$objPost = new PostedContent();
$allPosts = $objPost->getAllComments($roomNum);


//Postauksen koodi
if (isset($_POST['post'])) {
    $content = $_POST['content'];
    $post = new commentContr($content, $roomNum);
    $post->PostComment();
    header("Location: ?room=$roomNum&error=none");
}


$getCurrentRoom = new PostedContent();
$currentRoom = $getCurrentRoom->GetPostByCurrentRoomID($roomNum);

?>




<body>
<script>
    $(document).ready(function() {

        $(".category-item").click(function(){
                $("#category").val($(this).html());
                $('#categorylist').hide();
                $('.category-item').removeClass('background_selected');
                $(this).addClass('background_selected');
            });


            $(document).on('click', '.list-group-item', function(){
                $("#category").val($(this).html());
                $('#categorylist').hide();            
                $( ".category-item:contains('"+ $(this).html() +"')").addClass('background_selected');  
            });
        
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
                       $('#categorylist').show();
                       $('#categorylist').html(data);
                   },
                   error:function(data)
                   {
                        $('#categorylist').fadeIn();
                        $('#categorylist').html('Jokin meni vikaan');
                   }
                });
            } else {
                $('#categorylist').hide();
            }

            $(".category-item").each(function () {
                var item = $(this).text();
                if ($("#category").val().indexOf(item) > -1)
                {
                    $(this).removeClass('background_selected');
                    $(this).addClass('background_selected');
                } else {
                    $(this).removeClass('background_selected');
                }
            });
            
        });
    });
</script>
<?php
if (isset($_GET['edit'])) {
?>

<!--EDIT Modal section-->
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
            if (isset($_POST['update'])) {
                $title = $_POST['subject'];
                $topic = $_POST['topic'];
                $category = $_POST['category'];

                $updatePost = new PostsContr($title, $topic, $category);
                $updatePost->updateTopic($roomNum);
                header("Location: view.php?room=$roomNum");
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
                            echo '<input type="text" name="subject" id="subject" value="'. $currentRoom[0]['title'] .'"></input>';
                        } ?>
                        </div>
                        <div class="form-group-upper" style="margin-bottom: 0;">
                        <label>Valitse kategoria</label>
                        <input type="text" name="category" id="category" value="<?php echo $currentRoom[0]['category']; ?>"> 
                    </div>
                    <div id="categorylist"></div>
                    </div>
                    <div class="form-group">
                        <label>Aihe</label>
                        <?php if(isset($_GET['topic'])) {
                         $formContent = $_GET['topic'];
                        echo '<textarea class="tinymce" name="topic" id="topic" rows="7">'. $formContent .'</textarea>';
                        } else {
                            echo '<textarea class="tinymce" name="topic" id="topic" rows="7">'. $currentRoom[0]['topic'] .'</textarea>';
                        } ?>
                        
                        <div class="post-topic-button">
                            <input type="submit" name="update" value="Päivitä">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Modal section loppuu-->
<?php
}
?>
   
    <div class="navbar-other">
        <div class="navbar-menu">
            <div class="current-user-parent">
                <a href="home.php"><h1>Rawr <i class="fa fa-rocket" aria-hidden="true" style="transform: rotate(45deg);"></i></h1></a>
            </div>
            <div class="buttons">
                <?php if(isset($_SESSION['userid'])){
                    echo '<a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>';
                } else {
                    echo '<a href="login.php"><button class="logout">Kirjaudu sisään</button></a>';
                }?>
                
            </div>
        </div>
        <div class="search-toolbar">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn"><i class="fa fa-home" aria-hidden="true"></i> Koti</button>
            <div id="myDropdown" class="dropdown-content">
                <a href="home.php">Kotisivu</a>
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
    <div class="all-content">


        <div class="all-comments">
            <div class="edit-toolbar">
            <a href="home.php"><button class="profile-back" style="margin-bottom: 0; margin-left: 10px;">Kotisivulle</button></a>
                <?php

                if (isset($_GET['edit'])) {
                    echo '<a href="view.php?room=' . $roomNum . '" class="close-view" style="margin-right: 20px;""><i class="fas fa-times"></i></a><a href="view.php?room=' . $roomNum . '" class="edit-toolbar-close">Peruuta</a>';
                } else {
                    echo '<a href="home.php" class="close-view"><i class="fas fa-times"></i></a><a href="home.php" class="edit-toolbar-close">Sulje</a>';
                }
                ?>

            </div>
            <div class="room-header">
                <div class='date-and-post'>
                    <div class='date'>
                        
                    <a href="profile.php?user=<?php echo $currentRoom[0]['user_id'] ?> " class="username"><?php echo $currentRoom[0]['name'] ?> </a>
                        
                       
                        <p><?php $mysqldate = strtotime($currentRoom[0]['date']);
                            $phpdate = date('Y/m/d G:i A', $mysqldate);
                            echo $phpdate; ?>
                        </p>
                    </div>
                    <h1 class='room-header-h1'><?php echo $currentRoom[0]['title']; ?></h1>
                    <p class='room-header-p'> <?php echo $currentRoom[0]['topic']; ?> </p>
                </div>
                <div class='post-toolbar'>
                    <i class='far fa-comment-alt'></i>
                    <?php $commentAmount = count($allPosts);
                    echo "<p>" . $commentAmount . " kommenttia</p>";
                    if(isset($_SESSION['userid']) && $_SESSION['userid'] == $currentRoom[0]['user_id']) {
                        echo "<a href='view.php?room=" . $roomNum . "&edit' class='post-toolbar-editpost'>Muokkaa</a>";
                        echo "<button class='post-toolbar-editpost' id='delete-post' data-id='". $roomNum ."'>Poista julkaisu</button>";
                    }
                    ?>
                </div>
            </div>



            <div class="discussion-section">

                <div class="comment-form">
                    <form class="form-post" method="POST">
                        <?php
                        if (!isset($_GET['error'])) {
                            echo "";
                        } else {
                            $signupCheck = $_GET['error'];

                            if ($signupCheck == "emptyinput") {
                                echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                            }
                            if ($signupCheck == "none") {
                                echo "<div class='success-texti'><p>Kommenttisi on julkaistu</p></div>";
                            }
                        }
                        ?>
                         <?php if (isset($_SESSION['userid'])) {
                        echo '
                        <div class="form-group">
                            <a id="comment"></a>
                            <textarea class="tinymce" name="content" id="topic" placeholder="Kerro ajatuksistasi..." rows="7" style="z-index: 99999;"></textarea>
                        </div>
                        <div class="post-comment">
                            <input type="submit" name="post" value="Kommentoi" id="post">
                        </div> ';
                        } else {
                            echo '<p>kirjaudu sisään jotta voit kommentoida</p>';
                        }
                        ?>
                    </form>
                </div>
                <span class="post-hr" id="#commentsection">
                    <hr>
                </span>
                <?php
                if (count($allPosts) == 0) {
                    echo "<div class='empty-room'><p>Täällä on tyhjää</p></div>";
                } else {
                    foreach ($allPosts as $key => $userPost) {
                        $mysqldate = strtotime($userPost['date']);
                        $phpdate = date('Y/m/d G:i A', $mysqldate);
                        echo "<div class='discussion-wrapper'>
                 <div class='discussion'>
                  <div class='date'>
                   <p class='username'>" . $userPost['name'] . "</p>
                   <p>" . $phpdate . "</p>
                  </div>
                  <div class='bodytext'><p>" . $userPost['content'] . "</p> </div>
                  </div>
                  <div class='discussion-reply'>
                   <div class='date'>
                    <p class='username'>Vilho Luoma</p>
                    <p>1.1.2022</p>
                    </div>
                     <div class='bodytext'> <p> Testi </p> </div>
                  </div>
                </div>";
                    }
                }

                ?>
            </div>
            <a href="" class="scrollup">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#4895ef" viewBox="0 0 24 24">
                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z" />
                </svg>
            </a>
        </div>
    </div>


    <script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\init-tinymce.js"></script>
    <script src="js/app.js"></script>
    <script src="js/dropdown.js"></script>  
    
    
    <script>
    $(document).ready(function() {
        //delete post
        $("#delete-post").click(function(){
            var id = $(this).data('id');
            if(confirm('Haluatko varmasti poistaa julkaisun?'))
            {
                $.ajax({
                url: 'action.php',
                type: 'GET',
                data: {deleteid: id},
                dataType: "html",
                error: function() {
                    alert("Jokin meni vikaan");
                },
                success: function(data) {
                    alert("Julkaisu " + id + "poistettiin.");
                    window.location = "home.php"; 
                }
            });
            }
        });
    });
</script>

    <script>
        $(document).ready(function() {
            $("p").has("img").css({
                "textAlign": "center",
                "margin-bottom": "10px"
            });
            setTimeout(function() {
            $('.success-texti').fadeOut(500, function() {
                $(this).remove();
            });
        }, 2000);
        });
    </script>
</body>