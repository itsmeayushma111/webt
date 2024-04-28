<div>
<img src="myProfile.png" alt="userprofile" style="width: 50px; height: 50px; padding-left: 70px;">
<?php
if (isset($_SESSION['username'])){
    echo "<div style='padding-left: 70px;'>";
    echo "<div style='font-weight: bold; color:#405d9b'>" . $_SESSION['username'] . "</div>";
    echo "<form action='logout.php' method='post'>";
    echo "<input type='submit' value='Logout'>";
    echo "</form>";
    echo "</div>";
    
}
?>
</div>