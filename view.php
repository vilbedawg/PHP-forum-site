<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
require_once "controllers/posts-contr.php";
require_once "includes/header.php";

if(isset($_SESSION['userid'])) {
    $sessID = $_SESSION['userid'];
} else {
    $sessID = -1;
}

// kaikki postaukset 
$roomNum = $_GET['room'];

// Kaikki kommentit
$objPost = new PostedContent();
$NumOfComments = $objPost->getAllComments($roomNum);
$currentRoom = $objPost->GetPostByCurrentRoomID($roomNum);



?>




<body>
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
                                <?php if (isset($_GET['title'])) {
                                    $formName = $_GET['title'];

                                    echo '<input type="text" name="subject" id="subject" value="' . $formName . '">';
                                } else {
                                    echo '<input type="text" name="subject" id="subject" value="' . $currentRoom[0]['title'] . '"></input>';
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
                            <?php if (isset($_GET['topic'])) {
                                $formContent = $_GET['topic'];
                                echo '<textarea class="tinymce" name="topic" id="topic" rows="7">' . $formContent . '</textarea>';
                            } else {
                                echo '<textarea class="tinymce" name="topic" id="topic" rows="7">' . $currentRoom[0]['topic'] . '</textarea>';
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

    <div class="search-toolbar">
        <div class="dropdown">
            <button onclick="myFunction()" class="dropbtn">
                <div class="drop-icons"><i class="fa fa-home" aria-hidden="true" style="margin-right: 5px;"></i> Koti</div> <i class="fas fa-angle-down"></i>
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
            <input type="text" id="post-search" placeholder="Etsi julkaisu...">
            <div class="post-category-list"></div>
        </div>
        <div class="buttons">
        <?php if(isset($_SESSION['userid'])) {
                    echo '<a href="logout.php"><button class="logout"><i class="fas fa-sign-out-alt"></i></button></a>';
                }else {
                    echo '<a href="login.php"><button class="logout"><i class="fa fa-sign-in" aria-hidden="true"></i></button></a>';
                }
                ?>
        </div>

    </div>
    
    <div class="all-comments">
        <div class="edit-toolbar">
            <a href="home.php?show=Etusivu"><button class="profile-back" style="margin-bottom: 0; margin-left: 10px;">Etusivulle</button></a>
            <?php

            if (isset($_GET['edit'])) {
                echo '<a href="view.php?room=' . $roomNum . '" class="close-view" style="margin-right: 20px;""><i class="fas fa-times"></i></a><a href="view.php?room=' . $roomNum . '" class="edit-toolbar-close">Peruuta</a>';
            } else {
                echo '<a href="home.php?show=Etusivu" class="close-view"><i class="fas fa-times"></i></a><a href="home.php?show=Etusivu" class="edit-toolbar-close">Sulje</a>';
            }
            ?>

        </div>
        <div class="room-header">
            <?php
            $likes = $objPost->getLikesPost($currentRoom[0]['post_id']);
            $likeStatus = null;
            $status = null;
            if(isset($_SESSION['userid'])) {
                $likeStatus = $objPost->userLikedPost($_SESSION['userid'], $currentRoom[0]['post_id']);
                $status = $objPost->likeStatusPost($likeStatus, $likes);
            }
            echo "<div class='like-buttons' data-id='". $currentRoom[0]['post_id'] ."' style='left: 9px;'>
            $status </div>";
        ?>
            <div class='date-and-post' style='margin-left: 0;'>
                <div class='date'>
                    <a href="profile.php?user=<?php echo $currentRoom[0]['user_id'] ?> " class="username"><?php echo $currentRoom[0]['name'] ?> </a>
                    <p><?php $mysqldate = strtotime($currentRoom[0]['date']);
                        $phpdate = date('d/m/Y G:i A', $mysqldate);
                        echo $phpdate; ?>
                    </p>
                </div>
                <h1 class='room-header-h1'><?php echo $currentRoom[0]['title']; ?></h1>
                <div class='room-header-p'><?php echo $currentRoom[0]['topic']; ?> </div>
            </div>
            <div class='post-toolbar'>
                <i class='far fa-comment-alt'></i>
                <?php $commentAmount = $NumOfComments['comment_amount'];
                echo "<p class='comment-amount'>" . $NumOfComments['comment_amount'] . " kommenttia</p>";
                if (isset($_SESSION['userid']) && $_SESSION['userid'] == $currentRoom[0]['user_id']) {
                    echo "<a href='view.php?room=" . $roomNum . "&edit' class='post-toolbar-editpost'>Muokkaa</a>";
                    echo "<button class='post-toolbar-editpost' id='delete-post' data-id='" . $roomNum . "'>Poista julkaisu</button>";
                }

                ?>
        </div>
        </div>

       

        <div class="discussion-section">
            <div class="comment-form">
                <form class="form-post" method="POST" id="comment">
                    <div class="error-txt">
                    </div>
                    <?php if (isset($_SESSION['userid'])) {
                        echo '
                        <div class="form-group">
                            <a id="comment"></a>
                            <input type="hidden" id="post_id" value="' . $roomNum . '">
                            <textarea class="tinymce" name="content" id="topic" placeholder="Kerro ajatuksistasi..." rows="7" style="z-index: 99999;"></textarea>
                        </div>
                        <div class="post-comment">
                        <input type="submit" name="post" value="Kommentoi" id="post">
                        </div> ';
                    } else {
                        echo '<div class="form-group">
                                <a id="comment"></a>
                                <input type="hidden" id="post_id" value="' . $roomNum . '">
                                </div>';
                    }
                    ?>
                </form>
            </div>
            <span class="post-hr" id="#commentsection">
                <hr>
            </span>
            <div class="comment-container">
                <form class='form-reply' method='POST' id='reply' data-id="" style='display: none; padding-top: 10px; padding-left: 10px;'>
                    <textarea class='tinymce' name='content' id='reply-topic' placeholder='Kerro ajatuksistasi...' style='z-index: 99999;'></textarea>
                    <div class='post-comment' style='align-self: flex-end;'>
                        <input type='submit' name='post' value='Vastaa' id='reply' onclick='reply=true;'>
                        <button type="button" class="close-reply" onclick="closeReply(this)">Peruuta</button>
                    </div>
                </form>
            </div>
        </div>
        <a href="" class=" scrollup">
                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#ee6c4d" viewBox="0 0 24 24">
                        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z" />
                    </svg>
                    </a>
            </div>


            <script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
            <script type="text/javascript" src="tinymce\tinymce.min.js"></script>
            <script type="text/javascript" src="tinymce\init-tinymce.js"></script>
            <script src="js/app.js"></script>


            <script>
                $(document).ready(function() {
                    //delete post
                    $("#delete-post").click(function() {
                        var str = $('#post-content');
                        if (confirm('Haluatko varmasti poistaa julkaisun?')) {
                            $('.all-comments').find('img:not(.comment-img)').each(function () {
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
                            var id = $(this).data('id');
                            $.ajax({
                                url: 'search.php',
                                type: 'GET',
                                data: {
                                    deleteid: id
                                },
                                dataType: "html",
                                error: function() {
                                    alert("Jokin meni vikaan");
                                },
                                success: function(data) {
                                    alert("Julkaisu " + id + "poistettiin.");
                                    window.location = "home.php?show=Etusivu";
                                }
                            });
                        }
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    var sessID = <?php echo $sessID ?>;
                    var commentAmount = $('.form-reply').next().data('id');
                    var amount = <?php echo $commentAmount; ?>;
                    var post_id = $('#post_id').val();
                    $.ajax({
                        url: 'search.php',
                        type: 'POST',
                        data: {
                            post_id: post_id
                        },
                        dataType: "text",
                        error: function() {
                            alert("Jokin meni vikaan");
                        },
                        success: function(data) {
                            $('.comment-container').prepend(data);
                            tinymce.remove();
                            initializeTinyMce('textarea');
                            $('.reply-show').each(function() {
                                if($(this).data('id') == 0) {
                                   $(this).hide();
                                } else {
                                    $(this).show();
                                }
                            });
                            $('.delete-comment').each(function () {
                                if($(this).attr('user-id') != sessID) {
                                    $(this).remove();
                                }
                            });
                            $('.bodytext img').css({'height' : 'auto',
                                            'max-width' : '100%',
                                            'max-height' : '300px'
                            });

                            // jos käyttäjä on offline tilassa
                            if(sessID == -1) {
                                $('.comment-buttons').remove();
                            }
                        }  
                    });
                    
                    $(document).on('submit', '#comment', function(e) {
                        e.preventDefault();
                        var comment = $('#topic').val();
                        if (comment.length > 9) {
                            $.ajax({
                                url: "search.php",
                                method: "POST",
                                data: {
                                    comment: comment,
                                    id: post_id,
                                },
                                dataType: "text",
                                success: function(message) {
                                    amount++;
                                    $('.error-txt').stop().show();
                                    $('.error-txt').html('<div class="success-texti"><p>Kommenttisi on tallennettu</p></div>');
                                    $('.error-txt').stop().delay(3000).fadeOut("fast");
                                    $('.comment-amount').html(amount + ' kommenttia');
                                    $('#comment')[0].reset();
                                    $('.comment-container').prepend(message);
                                    tinymce.remove();
                                    initializeTinyMce('textarea');
                                    $('.bodytext img').css({'height' : 'auto',
                                            'max-width' : '100%',
                                            'max-height' : '200px'
                                    });
                                },
                                error: function(message) {
                                    alert('jokin meni pieleen');
                                }
                            });
                        } else {
                            $('.error-txt').stop().show();
                            $('.error-txt').stop().html('<div class="error-texti"><p>Yli 3 merkkiä</p></div>');
                            $('.error-txt').stop().delay(1000).fadeOut("fast");
                        }
                    });

                    $(document).on('submit', '.form-reply', function(e) {
                        e.preventDefault();
                        var comment_id = $('.form-reply').attr('data-id');
                        var reply = $('#reply-topic').val();
                        if (reply.length > 9) {
                            $.ajax({
                                url: "search.php",
                                method: "POST",
                                data: {
                                    reply: reply,
                                    id: post_id,
                                    comment_id: comment_id,
                                },
                                dataType: "text",
                                success: function(message) {
                                    amount++;
                                    newCommentAmount = $('.form-reply').parents('.discussion-wrapper').find('.reply-show').data()['id'] += 1;
                                    btn = $(e.target).parents('.discussion-wrapper').find('.reply-show')
                                    if (newCommentAmount == 1) {
                                        if($(btn).hasClass('ShowComments')){
                                         $(btn).text('Piilota ' + newCommentAmount + ' kommentti');
                                        } else {
                                        $(btn).text('Näytä ' + newCommentAmount + ' kommentti');
                                        }
                                    } else {
                                        if($(btn).hasClass('ShowComments')){
                                            $(btn).text('Piilota ' + newCommentAmount + ' kommenttia');
                                        } else {
                                            $(btn).text('Näytä ' + newCommentAmount + ' kommenttia');
                                        }
                                    }
                                    $('.comment-amount').html(amount + ' kommenttia');
                                    $(e.target)[0].reset();
                                    $('.form-reply').hide();
                                    $('.comment-amount').html(amount + ' kommenttia');
                                    $(e.target).parents('.discussion-wrapper').find('.reply-section').append(message);
                                    $(e.target).prev().children('.reply').text('Vastaa');
                                    $('.form-reply').parents('.discussion-wrapper').find('.reply-show').show();
                                    $('.bodytext img').css({'height' : 'auto',
                                            'max-width' : '100%',
                                            'max-height' : '300px'
                                    });

                                },
                                error: function(message) {
                                    alert('jokin meni pieleen');
                                }
                            });
                        } else {
                            $('.error-txt').stop().show();
                            $('.error-txt').stop().html('<div class="error-texti"><p>Yli 3 merkkiä</p></div>');
                            $('.error-txt').stop().delay(1000).fadeOut("fast");
                        }
                    });


                    $(document).on('click', '.reply-show', function(e) {
                        e.preventDefault();
                        var replySection = $(e.target).closest('.discussion-wrapper').find('.reply-section');
                        $(e.target).toggleClass('showComments');
                        oldText = $(this).data('id');
                        if ($(this).hasClass('showComments')) {
                            if(oldText == 1) {
                                $(this).text('Piilota ' + oldText + ' kommentti');
                            } else {
                                $(this).text('Piilota ' + oldText + ' kommenttia');
                            }
                            replySection.show();
                        } else {
                            if(oldText == 1) {
                                $(this).text('Näytä ' + oldText + ' kommentti');
                            } else {
                                $(this).text('Näytä ' + oldText + ' kommenttia');
                            }
                            replySection.hide();
                        }
                    });
                
                    $(document).on('click', '.delete-comment', (e) => {
                        var id = $(e.target).attr('data-id');
                        //poistetaan kuvat
                        if(isReply) {
                            $(e.target).parents('.discussion-reply').find(".bodytext img").each(function () {
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
                        } else { 
                            $(e.target).parents('.discussion-wrapper').find(".bodytext img").each(function() {
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
                        }
                        $.ajax({
                            url: 'search.php',
                            type: 'POST',
                            data: {
                                delete_comment: id,
                                isReply: isReply
                            },
                            dataType: 'text',
                            error: function() {
                                alert("Jokin meni vikaan");
                            },
                            success: function(data) {
                                if (isReply) {
                                    amount--;
                                    $('.comment-amount').html(amount + ' kommenttia');
                                    newCommentAmount = $(e.target).parents('.discussion-wrapper').find('.reply-show').data()['id'] -= 1;
                                    if(newCommentAmount == 0) {
                                        $(e.target).parents('.discussion-wrapper').find('.reply-show').hide();        
                                    } else if (newCommentAmount == 1) {
                                        $(e.target).parents('.discussion-wrapper').find('.reply-show').text('Piilota ' + newCommentAmount + ' kommentti');
                                    } else {
                                        $(e.target).parents('.discussion-wrapper').find('.reply-show').text('Piilota ' + newCommentAmount + ' kommenttia');
                                    }
                                    $(e.target).parents('.discussion-reply').remove();
                                } else {
                                    $(e.target).closest('.discussion-wrapper').remove();
                                    allReplies = $(e.target).parents('.discussion-wrapper').find('.reply-section');
                                    $(allReplies).children().each(function (e) {
                                        amount--;
                                    });
                                    amount--;
                                    $('.comment-amount').html(amount + ' kommenttia');
                                }
                            }
                        });
                    });

                });

                function reply(caller) {
                    commentID = $(caller).data('id');
                    formField = $(caller).parent();
                    $(".form-reply").insertAfter($(formField));
                    $(".form-reply").attr('data-id',commentID);
                    tinymce.remove();
                    initializeTinyMce('textarea');
                    if($(caller).is('#reply')) {
                        replytoWho = $(caller).parents('.discussion-reply').find('.username').text()
                        $('#reply-topic').val('@'+replytoWho);
                    }
                    $('.form-reply').show();
                }

                function closeReply(caller) {
                    $(caller).parents('.form-reply')[0].reset();
                    $(caller).parents('.form-reply').hide();
                }
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