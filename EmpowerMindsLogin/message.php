<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/postBox.css">
  <style>
    body{
      background-color:lavender;
    }
  </style>

</head>
</html>
<?php
session_start();

include("classes/post.php");
include("classes/user.php");
include("displayUsername.php");
include("classes/comment.php");


header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies


// Check if user is logged in
if(!isset($_SESSION['valid'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// retrieve user_id from session
$user_id = $_SESSION['id'];
//check if user_id is set
if(!isset($user_id)){
  // or header("Location: login.php?error=user_id_not_set");
  echo "User Id is not set.";
  exit();
}

//posting starts here
 //if something was posted vanera herna
if($_SERVER['REQUEST_METHOD'] == "POST") {

  $post = new Post($conn);//post.php wala class call gareko
  
  $result = $post->create_post($user_id , $_POST);
  if($result == ""){
    header("Location: message.php");
    die;
  }else{
    echo "<br>The following errors occured:<br><br>";
    echo $result;
  }
  
}

//collect posts
$post = new Post($conn);
$posts = $post->get_posts($user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="message/assets/css/post.css">
    <title>My Stories</title>
</head>
<body>
    <!--posts area-->
    
    <div>
        <form    style="text-align:center; padding:40px "     method="post">
          <textarea name="post" placeholder="Share your personal experiences and queries :)"   style="height:100px; width:80%;  margin-top:34px; border-radius:7px; padding-top:10px; border:none; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          font-size: larger;"></textarea>
          <br>
          <input style="  margin-top:15px; height:35px; width:70px; font-size:15px; border: none;  background-color:#f4f1f1;  border-radius:20px;   "    id="post_button" type="submit" value="Post">
          <br>
        </form>
    


    </div>

   </div>




    <!--posts-->
     
    <div id="post_bar"  >
      <?php
     if($posts){
   foreach ($posts as $ROW){
     $user = new User($conn);
     $ROW_USER = $user->get_user($ROW['user_id']);
     include("post.php");
           echo "<div class='post-content'>";
           echo "<form action='submit_comment.php' method='post'   >";
           echo "<input type='hidden' name='post_id' id='post-id' value='" . $ROW['post_id'] . "' >";
           echo "<textarea name='comment_text'    placeholder='Write a comment' style='width:92%'></textarea>";
           echo "<input type='submit' value='Comment'>";
           echo "</form>";
           echo "<a  href='view_comments.php?post_id=" . $ROW['post_id'] . "&post=" . urlencode($ROW['post']) .   "    '>View Comments</a>";
           echo "<span style='color: #999;'>" . $ROW['date'] . "</span>";
           echo "</div>";
           
   }
  }
   ?>
      </div>
      <script>
        <?php
            if(isset($_SESSION['previous_url'])) {
                echo "window.history.replaceState(null, null, '{$_SESSION['previous_url']}');";
                unset($_SESSION['previous_url']);
            }
        ?>
    </script>
</body>
</html>
