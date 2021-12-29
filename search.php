<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
$user = new Users();
date_default_timezone_set('Europe/Helsinki');

//Hakukentän täyttö
if (isset($_POST['query'])) {
  $inpText = $_POST['query'];
  $output = '';
  $stmt = $user->connect()->prepare("SELECT * FROM categories WHERE name LIKE :name");
  $stmt->execute(['name' => '%' . $inpText . '%']);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($result) {
    foreach ($result as $row) {
      echo  '<p class="list-group-item">' . $row['name'] . '</p>';
    }
  } else {
    echo '<p class="list-group-item">...</p>';
  }
}

if (isset($_POST['postquery'])) {
  $inpText = $_POST['postquery'];
  $output = '';
  $stmt = $user->connect()->prepare("SELECT * FROM posts WHERE title LIKE :title ORDER BY date DESC");
  $stmt->execute(['title' => '%' . $inpText . '%']);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($result) {
    foreach ($result as $row) {
      $mysqldate = strtotime($row['date']);
     $phpdate = date('d/m/Y G:i A', $mysqldate);
      echo  '<div class="post-row" id="'. $row['post_id'] .'">
            <p class="post-row-1">' . $row['title'] . '</p>
            <p class="post-row-3"><span>' . $row['name'] . '</span> <span>' .  $phpdate . '</span></p>
            </div>';
    }
  } else {
    echo '<p class="post-row-1">...</p>';
  }
}




//kommentin poistaminen
if(isset($_POST['delete_comment'])) {
  if(($_POST['isReply']) == 'true') {
    $stmt = $user->connect()->prepare('DELETE FROM replies WHERE comment_id = ?;');
    $stmt->execute(array($_POST['delete_comment']));
    exit();
  } else {
    $stmt = $user->connect()->prepare('DELETE FROM comments WHERE comment_id = ?;');
    $stmt->execute(array($_POST['delete_comment']));
    exit();
  }
  }



//Kommentin lisääminen
if (isset($_POST['comment'])) {

  $output = '';

  //Uusi kommentti
  $stmt =  $user->connect()->prepare('INSERT INTO comments (post_id, user_id, name, date, content)
  VALUES (?, ?, ?, ?, ?);');

  if (!$stmt->execute(array($_POST['id'], $_SESSION['userid'], $_SESSION['name'], date('Y-m-d H:i:s'), $_POST['comment']))) {
    $stmt = null;
    $output = "<div class='error-texti'><p>STMT FAILED</p></div>";
    exit();
  } 
  else {
    $output = "<div class='success-texti'><p>Kommenttisi on tallennettu</p></div>";
  }

      echo $output;
      exit();
}
  
  

//uusi vastaus
if(isset($_POST['reply'])){

    $stmt =  $user->connect()->prepare('INSERT INTO replies (comment_id, post_id, reply, created, user_id, name)
        VALUES (?, ?, ?, ?, ?, ?);');
    if (!$stmt->execute(array($_POST['comment_id'], $_POST['id'], $_POST['reply'], date('Y-m-d H:i:s'), $_SESSION['userid'], $_SESSION['name']))) {
      $stmt = null;
      $output = "<div class='error-texti'><p>STMT FAILED</p></div>";
      exit();
    }
    $output = "<div class='success-texti'><p>Kommenttisi on tallennettu</p></div>";

    function newComment()
    {
      $newCommen =
        "<div class='discussion-reply'>
              <div class='date'>
                <p class='username'>" . $_SESSION['name'] . "</p>
                <p>" . date('Y/m/d G:i A') . "</p>
              </div>
              <img src='". $_SESSION['image'] ."' class='reply-img'></img>
              <div class='bodytext'>" . $_POST['reply'] . "</div>
              </div>
              ";
             

      return $newCommen;
    }

  

  $arr = array('output' => $output, 'newComment' => newComment());
  echo json_encode($arr);
}





//Haetaan kommentit
if (isset($_POST['post_id'])) {
  $stmt = $user->connect()->prepare("SELECT * FROM comment_owner WHERE post_id = ? ORDER BY date DESC");
  
  if (!$stmt->execute(array($_POST['post_id']))) {
    $stmt = null;
    $output = "<div class='error-texti'><p>STMT FAILED</p></div>";
    exit();
  }
  $allComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
  

  foreach ($allComments as $userPost) {

    $mysqldate = strtotime($userPost['date']);
    $phpdate = date('d/m/Y G:i A', $mysqldate);
    echo "<div class='discussion-wrapper' id='" . $userPost['comment_id'] . "'>
                <div class='discussion'>
                  <div class='date'>
                  <a href='profile.php?user=" . $userPost['comment_id'] . "' class='username'>" . $userPost['name'] . "</a>
                  <p>" . $phpdate . "</p>
                  </div>
                  <img src='". $userPost['image'] ."' class='comment-img'></img>
                  <div class='bodytext'><p>" . $userPost['content'] . "</p> </div>
                  </div>
                  <div class='comment-buttons'>
                  <button class='reply' data-id='" . $userPost['comment_id'] . "'>Vastaa</button>
                  <button class='reply-show' data-id='" . $userPost['comment_id'] . "' style='width: 130px;'>Näytä kommentit </button>
                  "; if($_SESSION['userid'] == $userPost['user_id']) {
                    echo "<button class='delete-comment' onclick='isReply = false;' data-id='" . $userPost['comment_id'] . "'>Poista</button>";
                  }
                    echo 
                    "</div>
                    <form class='form-reply " . $userPost['comment_id'] . "' method='POST' id='reply' style='display: none; width: 80%; padding-top: 10px; padding-left: 10px;'>
                    <input type='hidden' id='post_id' value='" . $_POST['post_id'] . "'>
                    <input type='hidden' id='comment_id' value='" . $userPost['comment_id'] . "'>
                    <textarea class='tinymce' name='content' id='reply-topic' placeholder='Kerro ajatuksistasi...' rows='7' style='z-index: 99999;'></textarea>
                    <div class='post-comment' style='align-self: flex-end;'>
                        <input type='submit' name='post' value='Vastaa' id='reply' onclick='reply=true;'>
                    </div>
                    </form>
                    <div class='reply-section'>
                    </div>
                </div> 
                </div>";
  }
  
}


if(isset($_POST['parent'])) {
  $stmt = $user->connect()->prepare("SELECT r.user_id as comment_owner, r.comment_id, r.post_id, r.reply, 
                                      r.created, r.rating, u.user_id, u.name, u.image
                                      FROM replies AS r
                                      INNER JOIN users AS u 
                                      ON r.user_id = u.user_id
                                      WHERE comment_id = ?
                                      ORDER BY created ASC;");
  
  if (!$stmt->execute(array($_POST['parent']))) {
    $stmt = null;
    $output = "<div class='error-texti'><p>STMT FAILED</p></div>";
    exit();
  }
  $allReplies = $stmt->fetchAll(PDO::FETCH_ASSOC);
  if ($allReplies == null) {
    echo "<div class='discussion-reply'> 
          <p>Ei vastauksia</p>
          </div>";
  } else {

    foreach ($allReplies as $userReply) {
      $mysqldate = strtotime($userReply['created']);
      $phpdate = date('d/m/Y G:i A', $mysqldate);
      echo "<div class='discussion-reply'>
            <div class='date'>
              <p class='username'>" . $userReply['name'] . "</p>
              <p>" . $phpdate . "</p>
            </div>
            <img src='". $userReply['image'] ."' class='reply-img'></img>
            <div class='bodytext'>" . $userReply['reply'] . "</div>
            <button class='reply-to-reply' data-id='" . $userReply['comment_id'] . "'>Vastaa</button>";
             if($_SESSION['userid'] == $userReply['user_id']) {
              echo "<button class='delete-comment' onclick='isReply = true;' data-id='" . $userReply['comment_id'] . "'>Poista</button>";
            }
            echo 
            "</div>
            </div>
            ";
    }
  }

}
