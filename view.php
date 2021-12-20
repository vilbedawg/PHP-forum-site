<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
require_once 'controllers/comment-contr.php';

include_once "includes/header.php";



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


if (isset($_GET['edit'])) {

?>

    <div class="bg-modal">
        <div class="modal-content">
            <div class="modal-close"><i class="fas fa-times"></i>
            </div>

            <?php
            if (isset($_POST['edit'])) {
                include_once "controllers/posts-contr.php";
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
                        }
                        ?>
                    </div>
                    <div class="form-group-upper">
                        <label>Otsikko</label>
                        <input type="text" name="subject" id="subject" value=" <?php echo $currentRoom[0]['title'] ?>"></input>
                    </div>
                    <div class="form-group-middle">
                        <label>Kategoria</label>
                        <div class="radio-buttons">
                            <div class="radio1">
                                <input type="radio" name="category" id="select1" value="Python"></input>
                                <label>Python</label>
                            </div>
                            <div class="radio2">
                                <input type="radio" name="category" id="select2" value="PHP"></input>
                                <label>PHP</label>
                            </div>
                            <div class="radio3">
                                <input type="radio" name="category" id="select3" value="C#"></input>
                                <label>C#</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Aihe</label>
                        <textarea class="tinymce" name="topic" id="topic" rows="7"><?php echo $currentRoom[0]['topic'] ?></textarea>
                        <div class="post-topic-button">
                            <input type="submit" name="edit" value="Julkaise" id="post">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
}
?>


<body>
    <div class="navbar-other">
        <div class="navbar-menu">
            <div class="current-user-parent">
                <h1>Rawr <i class="fa fa-rocket" aria-hidden="true" style="transform: rotate(45deg);"></i></h1>
            </div>
            <div class="buttons">
                <?php if (isset($_POST['edit'])) {
                    echo '<button class="create">Luo uusi</button>';
                } ?>
                <a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>
                <a href="users.php"><button class="create">Home</button></a>
            </div>
        </div>
    </div>
    <div class="all-content">


        <div class="all-comments">
            <div class="edit-toolbar">
                <?php

                if (isset($_GET['edit'])) {
                    echo '<a href="view.php?room=' . $roomNum . '" class="close-view" style="margin-right: 20px;""><i class="fas fa-times"></i></a><a href="view.php?room=' . $roomNum . '" class="edit-toolbar-close">Peruuta</a>';
                } else {
                    echo '<a href="users.php" class="close-view"><i class="fas fa-times"></i></a><a href="users.php" class="edit-toolbar-close">Sulje</a>';
                }
                ?>

            </div>
            <div class="room-header">
                <div class='date-and-users'>
                    <div class='date'>
                        <a href="profile.php?user=<?php echo $currentRoom[0]['user_id']; ?>" class='username'><?php echo $currentRoom[0]['name']; ?></a>
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
                    $isOwner = $_SESSION['userid'] == $currentRoom[0]['user_id'];
                    if ($isOwner) {
                        echo "<a href='view.php?room=" . $roomNum . "&edit' class='post-toolbar-editpost'>Muokkaa</a>";
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
                        <div class="form-group">
                            <a id="comment"></a>
                            <textarea class="tinymce" name="content" id="topic" placeholder="Kerro ajatuksistasi..." rows="7" style="z-index: 99999;"></textarea>
                        </div>
                        <div class="post-comment">
                            <input type="submit" name="post" value="Kommentoi" id="post">
                        </div>
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

    <script type="text/javascript">
        $("#kommentoi").click(function(e) {
            e.preventDefault();
            var id = $(this).parents("tr").attr("id");
            if (confirm('Are you sure to remove this record ?')) {
                $.ajax({
                    url: 'action.php',
                    type: 'GET',
                    data: {
                    id: id
                    },
                    success: function(data) {},
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {
                        $("#" + id).remove();
                        alert("Käyttäjä numero " + id + " poistettiin.");
                        $('.table-wrapper').stop().slideDown("normal", function() {
                            $('.table-wrapper').css('display', 'flex');
                            $(".show-list").hide();
                            $(".hide-list").show();
                        });
                    }
                });
            }
        });
    </script>

    <?php if (isset($_SESSION["userid"])) { ?>
        <div class="register-modal">
            <div class="reg-modal-content">
                <div class="modal-close"><i class="fas fa-times"></i></div>
                <div class="hero">
                    <div class="wrapper-login">
                        <section class="form signup">
                            <header>Kirjaudu</header>
                            <form action="" method="post">
                                <div class="error-txt">
                                    <?php
                                    if (!isset($_GET['error'])) {
                                        echo "";
                                    } else {
                                        $signupCheck = $_GET['error'];

                                        if ($signupCheck == "emptyinput") {
                                            echo "<div class='error-texti'><p>Täytä kaikki kohdat</p></div>";
                                        } elseif ($signupCheck == "wrongpwd") {
                                            echo "<div class='error-texti'><p>Väärä salasana</p></div>";
                                        } elseif ($signupCheck == "usernotfound") {
                                            echo "<div class='error-texti'><p>Käyttäjää ei löydy</p></div>";
                                        } elseif ($signupCheck == "banned") {
                                            echo "<div class='error-texti'><p>Banned</p></div>";
                                        }
                                    }

                                    ?>
                                </div>
                                <div class="field input">
                                    <label>Käyttäjänimi</label>
                                    <?php
                                    if (isset($_GET['name'])) {
                                        $formName = $_GET['name'];

                                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi" value="' . $formName . '">';
                                    } else {
                                        echo '<input type="text" name="name" id="name" placeholder="Käyttäjänimi">';
                                    }
                                    ?>
                                </div>
                                <div class="field input">
                                    <label>Salasana</label>
                                    <input type="password" name="password" id="Password" placeholder="Salasana">
                                    <i class="fas fa-eye"></i>
                                </div>
                                <div class="field button">
                                    <input type="submit" name="submit" value="Kirjaudu" id="submit">
                                </div>
                            </form>
                            <div class="link">Rekisteröitynyt?<a href="index.php"> Rekisteröidy</a></div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    <?php   } ?>




    <script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\tinymce.min.js"></script>
    <script type="text/javascript" src="tinymce\init-tinymce.js"></script>
    <script src="js/app.js"></script>
    <script>
        $(document).ready(function() {
            $("p").has("img").css({
                "textAlign": "center",
                "margin-bottom": "10px"
            });
        });
    </script>
    <script>
        setTimeout(function() {
            $('.success-texti').fadeOut(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>
</body>