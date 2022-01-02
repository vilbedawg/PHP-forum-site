<?php
session_start();
require_once 'classes/database.php';
require_once 'includes/autoload-classes.php';
$user = new Users();
$error = '';
date_default_timezone_set('Europe/Helsinki');



//Tykkäys
if(isset($_POST['likeID'])) {
  $action = $_POST['action'];
  $post_id = $_POST['likeID'];
  
  switch ($action) {
    case 'like':
      $stmt = $user->connect()->prepare('INSERT INTO rating_info (user_id, post_id, rating_action) VALUES (?, ?, ?)
                                        ON DUPLICATE KEY UPDATE rating_action="like"');
      $stmt->execute(array($_SESSION['userid'], $post_id, $action));
      break;

    case 'dislike':
      $stmt = $user->connect()->prepare('INSERT INTO rating_info (user_id, post_id, rating_action) VALUES (?, ?, ?)
                                        ON DUPLICATE KEY UPDATE rating_action="dislike"');
      $stmt->execute(array($_SESSION['userid'], $post_id, $action));
      break;

    case 'unlike':
      $stmt = $user->connect()->prepare('DELETE FROM rating_info WHERE user_id = :user_id AND post_id = :post_id');
      $stmt->bindParam(':user_id', $_SESSION['userid']);
      $stmt->bindParam(':post_id', $post_id);
      $stmt->execute();
      break;

    case 'undislike':
      $stmt = $user->connect()->prepare('DELETE FROM rating_info WHERE user_id = :user_id AND post_id = :post_id');
      $stmt->bindParam(':user_id', $_SESSION['userid']);
      $stmt->bindParam(':post_id', $post_id);
      $stmt->execute();
      break;
    default;
      break;
  }
  echo getRating($post_id);
  exit(0);
}

function getRating($id){
  global $user;
  
  $likes = $user->connect()->prepare("SELECT (SELECT COUNT(*) FROM rating_info WHERE post_id = ? AND rating_action = 'like') -
                                            (SELECT COUNT(*) FROM rating_info WHERE post_id = ? AND rating_action = 'dislike') AS amount");
  $likes->execute(array($id, $id));
  $likeCount = $likes->fetchAll(PDO::FETCH_ASSOC);
  return ($likeCount[0]['amount']);
}

//Käyttäjän poistaminen
if(isset($_GET['id'])) {
  $id = $_GET['id'];
  $stmt = $user->connect()->prepare('DELETE FROM users WHERE user_id = :id;');
  $stmt->execute(array(':id' => $id));
  exit();
} 

//julkaisun poistaminen
if(isset($_GET['deleteid'])) {
  $id = $_GET['deleteid'];
  $stmt = $user->connect()->prepare('DELETE FROM posts WHERE post_id = :id;');
  $stmt->execute(array(':id' => $id));
  exit();
}

if(isset($_POST['imgName'])) {
$postImage = $_POST['imgName'];

  if(file_exists($postImage)){
    unlink($postImage);
  } else {
    echo 'Tiedostoa ei löytynyt';
  }

}


//käyttäjänimen päivitys
if(isset($_POST['name'])) { 
  $checkName = new Signup();
  
  if(!$checkName->checkUser($_POST['name'])) {
      $error = "<div class='error-texti'><p>Käyttäjänimi jo käytössä</p></div>";
  }

  //ainakin yksi non-whitespace kirjain
  else if(!preg_match('/^[-a-zA-Z0-9-()]+(\s+[-a-zA-Z0-9-()]+)*$/', $_POST['name'])) {
      $error = "<div class='error-texti'><p>Väärän muotoinen nimi</p></div>";
  }

  //3-14 merkkiä
  else if(strlen($_POST['name']) <= 2 || (strlen($_POST['name'])) >= 15) {
      $error = "<div class='error-texti'><p>Käyttäjänimen tulee sisältää 3-14 merkkiä</p></div>";
  }

  if($error == ""){
      //jos error = false
      $stmt =  $user->connect()->prepare("UPDATE users SET name = :name WHERE user_id = :user_id");
          $stmt->bindParam(':name', $_POST['name']);
          $stmt->bindParam(':user_id', $_POST['id'], PDO::PARAM_INT);
          if(!$stmt->execute())  {
              $stmt = null;
              $error = "<div class='error-texti'><p>STMT FAILED</p></div>";
              exit();
          } 
      $error = "<div class='success-texti'><p>Tallennettu</p></div>";
  } 

  exit($error);  
}


//sähköpostin päivitys
if(isset($_POST['email'])){
  $email = $_POST['email'];
  $user = new Signup();
  if(!$user->checkEmail($email)) {
      $error = "<div class='error-texti'><p>Sähköposti käytössä</p></div>";
  }

  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error = "<div class='error-texti'><p>Väärän muotoinen sähköposti</p></div>";
  }

  if($error == "") {
      $stmt =  $user->connect()->prepare("UPDATE users SET email = :email WHERE user_id = :user_id");
          $stmt->bindParam(':email', $_POST['email']);
          $stmt->bindParam(':user_id', $_POST['id'], PDO::PARAM_INT);
          if(!$stmt->execute())  {
              $stmt = null;
              $error = "<div class='error-texti'><p>STMT FAILED</p></div>";
              exit();
          }
      $error = "<div class='success-texti'><p>Tallennettu</p></div>";
  }

  exit($error);
}


//salasanan päivitys
if(isset($_POST['password'])) {
  $pwd = $_POST['password'];
  $stmt = $user->connect()->prepare("SELECT password FROM users WHERE user_id = ? LIMIT 1");
  $stmt->execute(array($_POST['id']));
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $oldpwd = $result['password'];
  $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
  
  if(strlen($pwd) < 4 ) {
      $error = "<div class='error-texti'><p>Salasnan tulee olla vähintään 4 merkkiä</p></div>";
      exit($error);
  }

  if(password_verify($pwd, $oldpwd)) {
      $error = "<div class='error-texti'><p>Et voi käyttää vanhaa salasanasi</p></div>";
      exit($error);
  } 

   $stmt =  $user->connect()->prepare("UPDATE users SET password = :password WHERE user_id = :user_id");
          $stmt->bindParam(':password', $hashedPwd);
          $stmt->bindParam(':user_id', $_POST['id'], PDO::PARAM_INT);
          if(!$stmt->execute())  {
              $stmt = null;
              $error = "<div class='error-texti'><p>STMT FAILED</p></div>";
              exit();
          }
      $error = "<div class='success-texti'><p>Salasanasi on vaihdettu</p></div>";
      exit($error);
}




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



//Julkaisujen haku
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
    $stmt = $user->connect()->prepare('DELETE FROM replies WHERE id = ?;');
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
    $stmt = $user->connect()->prepare("SELECT * FROM comment_owner ORDER BY comment_id DESC LIMIT 1");
    
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    exit(createCommentRow($data));
}
  
  

//uusi vastaus
if(isset($_POST['reply'])){

    $stmt =  $user->connect()->prepare('INSERT INTO replies (comment_id, post_id, content, date, user_id, name)
        VALUES (?, ?, ?, ?, ?, ?);');

    $stmt->execute(array($_POST['comment_id'], $_POST['id'], $_POST['reply'], date('Y-m-d H:i:s'), $_SESSION['userid'], $_SESSION['name']));
    $stmt = null;

    $stmt = $user->connect()->prepare("SELECT r.user_id as comment_owner, r.comment_id, r.id, r.post_id, r.content, 
    r.date, u.user_id, u.name, u.image
    FROM replies AS r
    INNER JOIN users AS u 
    ON r.user_id = u.user_id
    ORDER BY r.id
    DESC LIMIT 1");
  
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
  
    $newComment =
        "<div class='discussion-reply'>
              <div class='date'>
                <p class='username'>" . $data['name'] . "</p>
                <p>" . date('d/m/Y G:i A') . "</p>
              </div>
              <img src='". $data['image'] ."' class='reply-img'></img>
              <div class='bodytext'>" . $data['content'] . "</div>
              <button class='reply' id='reply' onclick='reply(this)' data-id='" . $data['comment_id'] . "' style='margin-left: 3px;'>Vastaa</button>
              <button class='delete-comment' user-id='" . $data['user_id'] . "' onclick='isReply = true;' data-id='" . $data['id'] . "'>Poista</button>
              </div>
              ";
             
    echo $newComment;
}


function createCommentRow($data) {
  global $user;
  $mysqldate = strtotime($data['date']);
  $phpdate = date('d/m/Y G:i A', $mysqldate);

  $stmt = $user->connect()->prepare("SELECT r.user_id as comment_owner, r.comment_id, r.id, r.post_id, r.content, 
  r.date, u.user_id, u.name, u.image
  FROM replies AS r
  INNER JOIN users AS u 
  ON r.user_id = u.user_id
  WHERE comment_id = ?
  ORDER BY date ASC;");

  $stmt->execute(array($data['comment_id']));
  $allReplies = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $response = "
              <div class='discussion-wrapper' id='" . $data['comment_id'] . "'>
              <div class='discussion'>
                <div class='date'>
                <a href='profile.php?user=" . $data['user_id'] . "' class='username'>" . $data['name'] . "</a>
                <p>" . $phpdate . "</p>
                </div>
                <img src='". $data['image'] ."' class='comment-img'></img>
                <div class='bodytext'><p>" . $data['content'] . "</p> </div>
                </div>
                <div class='comment-buttons'>
                <button class='reply' onclick='reply(this)' data-id='" . $data['comment_id'] . "'>Vastaa</button>
                <button class='delete-comment' onclick='isReply = false;' user-id='" . $data['user_id'] . "' data-id='" . $data['comment_id'] . "'>Poista</button>
                </div>
                <button class='reply-show' data-id='" . count($allReplies) . "' style='white-space: nowrap; margin-top: 5px; display: none;'>Näytä ". count($allReplies) ." Kommentti</button>
                <div class='reply-section' style='display: none;'>
                "; 
               
  foreach($allReplies as $dataR) {
    $mysqldate = strtotime($dataR['date']);
    $phpdate = date('d/m/Y G:i A', $mysqldate);
    $response .=  "<div class='discussion-reply'>
                    <div class='date'>
                    <a href='profile.php?user=" . $dataR['user_id'] . "' class='username'>" . $dataR['name'] . "</a>
                      <p>" . $phpdate . "</p>
                    </div>
                    <img src='". $dataR['image'] ."' class='reply-img'></img>
                    <div class='bodytext'>" . $dataR['content'] . "</div>
                    <div class='comment-buttons'>
                    <button class='reply' id='reply' onclick='reply(this)' data-id='" . $dataR['comment_id'] . "' style='margin-left: 3px;'>Vastaa</button>
                    <button class='delete-comment' user-id='" . $dataR['user_id'] . "' onclick='isReply = true;' data-id='" . $dataR['id'] . "'>Poista</button>
                    </div>
                    </div>
                    ";
  }

  $response .= "
            </div>
            </div>
          </div>
      ";

  echo $response;
}



//Haetaan kommentit
if (isset($_POST['post_id'])) {
  $response ='';
  $output = '';
  $stmt = $user->connect()->prepare("SELECT * FROM comment_owner WHERE post_id = ? ORDER BY date DESC");
  
  if (!$stmt->execute(array($_POST['post_id']))) {
    $stmt = null;
    $output = "<div class='error-texti'><p>STMT FAILED</p></div>";
    exit();
  }
  $allComments = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
  foreach($allComments as $row) {
    $response .= createCommentRow($row);
  }

  exit($response);
  
}




