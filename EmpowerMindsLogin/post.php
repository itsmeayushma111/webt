<div id="post">
    <div>
        <img src="myProfile.png" alt="userprofile" style="width: 50px; height: 50px; margin-right: 4px;">
    </div>
    <div>
        <div style="font-weight: bold; color:#405d9b"><?php echo $ROW_USER['username'];?></div>

        <?php echo $ROW['post']?>

        <br/>

    </div>
    <span style="color:#999; float:right;">
      <a href="delete.php?post_id=<?php echo $ROW['post_id']?>" style="padding-right: 20px;">Delete</a>
    </span>
</div>