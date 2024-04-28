<!--message.phpma call gareko class-->
<?php
include("connect.php");

include("classes/reply.php");


class Post
{
    private $conn;
    private $error = "";

     // Constructor to initialize the database connection
     public function __construct($conn){
         $this->conn = $conn;
     }

    public function create_post($user_id , $data)
    {
        if(!empty($data['post']))
        {
            $post = mysqli_real_escape_string($this->conn, $data['post']);
            $post_id = $this->create_post_id();

            $query = "INSERT INTO posts (user_id,post_id,post) VALUES ('$user_id','$post_id','$post')";
            $result = mysqli_query($this->conn, $query);
          
        }else
        {
            $this->error .= "Please type something to post!<br>";
        }
        return $this->error;
    }

    public function get_post($post_id)
    {
        if(!is_numeric($post_id)){
            return false;
        }
        $query = "SELECT * FROM posts WHERE post_id = '$post_id'";
        $result = mysqli_query($this->conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    public function get_post_author($user_id){
        $query = "SELECT * FROM users WHERE user_id = '$user_id'";
        $result = mysqli_query($this->conn, $query);
    
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }
    
    public function get_posts($user_id){
        $query = "SELECT * FROM posts WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 10";
        $result = mysqli_query($this->conn, $query);

        if($result){
            return $result;
        }else{
            return false;
        }
    }
    public function get_otherPosts($current_user_id){
        $query = "SELECT * FROM posts WHERE user_id != '$current_user_id' ORDER BY post_id DESC";
        $result = mysqli_query($this->conn, $query);

        $other_posts = array();
        while ($row = mysqli_fetch_assoc($result)){
            $other_posts[] = $row;
        }

        return $other_posts;
    }

    //post_id banaako
    private function create_post_id(){
        $length = rand(4,19);
        $number = "";
        for($i=0; $i<$length; $i++){
            $new_rand = rand(0,9);

            $number = $number . $new_rand;
        }
        return $number;
    }

    //post deletion ko laagi
    public function delete_post_with_comments_and_replies($post_id)
    {
        if(!is_numeric($post_id)){
            return false;
        }

        //replies haru delete garni
        $comment = new Comment($this->conn);
        $comments = $comment->get_comments($post_id);
        if ($comments) {
            $reply = new Reply($this->conn);
            foreach ($comments as $comment) {
                $reply->delete_replies_for_comment($comment['comment_id']);
            }
        }

        //paila postma comment cha vane comment delete garni
        $query = "DELETE FROM comments WHERE post_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        if (!$stmt->execute()) {
            return false;
        }

        //post delete
        $query = "DELETE FROM posts WHERE post_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $post_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
//instantiate Post class with DB connection
$post = new Post($conn);