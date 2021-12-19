<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header("location: login.php");
    exit();
}
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
include_once "includes/header.php";

$objUser = new Users;
$users = $objUser->GetAllUsers();

$objUser->setloginStatus(1);
$onliners = $objUser->GetAllOnliners();

$postObj = new PostedContent;
$posts = $postObj->GetAllPostsByID($_GET['user']);

$objUser->setUserID($_SESSION['userid']);
$userlist = $objUser->GetAllUsersButMe();


?>

<body>
    <div class="navbar-other">
        <div class="navbar-menu">
            <div class="current-user-parent">
                <h1>Rawr <i class="fa fa-rocket" aria-hidden="true" style="transform: rotate(45deg);"></i></h1>
            </div>
            <div class="buttons">
                <a href="logout.php"><button class="logout">Kirjaudu ulos</button></a>
            </div>
        </div>
    </div>
    <div class="home-other">
        <?php
        if(isset($_GET['/noexist'])) {
        echo "<div class='noexist-box'>
            <h1>Käyttäjä ei ole olemassa :(</h1>
            <a href='users.php'><button class='logout'>Takaisin kotisivulle</button></a>
            </div>";
        }else {
            
        if (isset($_GET['user'])) {
            $objUser->setUserID($_GET['user']);
            $userOnView = $objUser->GetViewedUser();
            echo ' <div class="user-managment">
            <img src="' . $userOnView[0]['image'] . '"></img>
            <div class="user-details">
            <h1> ' . $userOnView[0]['name'] . ' </h1>
            </div>
            </div>        
            ';


            if ($_GET['user'] == $_SESSION['userid']) {
                echo
                '
             <a href="edit.php?user=' . $_SESSION['userid'] . '" class="edit-btn">
             <button class="edit" type="submit" name="user" value="' . $_SESSION['userid'] . '">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-5 17l1.006-4.036 3.106 3.105-4.112.931zm5.16-1.879l-3.202-3.202 5.841-5.919 3.201 3.2-5.84 5.921z"/></svg>
             </button>
             </a>
             ';
            }

            echo
            '
            <div class="profile">
                    <div class="profile-status">
                        <h1>Käyttäjätiedot</h1>
                    </div>
                    <div class="about">
                        <div class="member-amount">
                            <p class="amount">' . count($users) . '</p>
                            <p>Jäsentä</p>
                        </div>
                        <div class="members-online">
                            <p class="amount">' . count($onliners) . '</p>
                            <p>paikalla</p>
                        </div>
                    </div>
                    <hr>
                    <a href="users.php"><button class="create">Home</button></a>
                    <hr>
                    <p>' . $_SESSION["name"] . '</p>
                    </div>
                    </div>  
                    </div>

                    <div class="home-users">                        
                    <div class="discussion-page-users">';
            foreach ($posts as $post) {
                $mysqldate = strtotime($post['date']);
                $phpdate = date('Y/m/d G:i A', $mysqldate);
                $comments = $postObj->getAllComments($post['post_id']);
                $roomAmount = count($comments);
                echo
                '
                    <a href="view.php?room=' . $post['post_id'] . '" style="color: black; display: block;">
                            <div class="room-container"></a>
                                ';
                if (($post['user_id']) === $_SESSION['userid']) {
                    echo '<div class="delete-post">
                                    <form method="POST">
                                    <button class="delete-post-btn" name="del"><i class="fa fa-times" aria-hidden="true"></i></div></button>
                                    </form>
                                    
                                    <div class="delete-post">
                                    <a href="view.php?room=' . $post['post_id'] . '&edit"><button class="edit-post-btn" name="del"><i class="fas fa-edit"></i></div></button></a>
                                    ';
                                    }
                                    echo
                                    ' 
                                <a href="view.php?room=' . $post['post_id'] . '" style="color: black; display: block;">
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
                                     <p> ' . $roomAmount . ' kommenttia </p>
                                    </div>
                                    </div>
                                    </div>
                                </div></a>
                                ';
            }
        }
    } 
        ?>
        <?php if ($_SESSION['userid'] == 0) {
            echo "";
        } else {
        ?>

            <section class="user-list-body">
                <div class="user-list-arrows">
                    <div class="show-list">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z" />
                        </svg>
                    </div>
                    <div class="hide-list">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z" />
                        </svg>
                    </div>
                </div>
                <div class="every-user">
                    <h2 class="user-list-h2">Käyttäjälista</h2>
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
                                        <?php 
                                        if (isset($_POST['delete'])) {
                                            // $user['user_id'];
                                            // $delete = new Users();
                                            // $delete->setUserID($user['user_id']); 
                                            // $delete->DeleteUser();
                                        } 
                                        ?>
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
            $(".delete").click(function(){
                var id = $(this).parents("tr").attr("id");
                if(confirm('Are you sure to remove this record ?'))
                {
                    $.ajax({
                    url: 'delete.php',
                    type: 'GET',
                    data: {id:id},
                        success:function(data){
                        alert(data);
                        },
                    error: function() {
                        alert('Something is wrong');
                    },
                    success: function(data) {
                            $("#"+id).remove();
                            alert(data);  
                    }
                    });
                }
            });


        </script>



<a href="" class="scrollup">
    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" fill="#4895ef" viewBox="0 0 24 24">
        <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 7.58l5.995 5.988-1.416 1.414-4.579-4.574-4.59 4.574-1.416-1.414 6.006-5.988z" />
    </svg>
</a>
<script src="js/app.js"></script>
<script type="text/javascript" src="tinymce\jquery.tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\tinymce.min.js"></script>
<script type="text/javascript" src="tinymce\init-tinymce.js"></script>
<script>
    $(document).ready(function() {
        $("p").has("img").css({
            "textAlign": "center",
        });
    });
</script>
<script type="text/javascript">
    function ConfirmDelete() {
        if (confirm("Delete Account?"))
            location.href = 'linktoaccountdeletion';
    }
</script>
</body>

</html>