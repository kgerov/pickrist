    <div class="wrapper">
        <?php
        if(isset($_GET['browsePublic'])){
            if($prev_pic > 0): ?>
                <button class="button" onclick='location.href="browse.php?pic_id=<?php echo $prev_pic; ?>&browsePublic=1"'>Previous</button>
            <?php endif;
            if($next_pic > 0): ?>
                <button class="button" onclick='location.href="browse.php?pic_id=<?php echo $next_pic; ?>&browsePublic=1"'>Next</button>

            <?php endif; ?>
            <div>
                <?php $_SESSION['pic_id'] = $pic_id; ?>
                <form method="post" action="increment_likes.php"><input type="submit" class="button-like" name="likeButton" value="Like" ></form>
                <div class="likes"><?php echo "$likesNum"; ?></div>
                <img src="get_pic.php?pic_id=<?php echo $pic_id; ?>&full_size=1&getPublic">
            </div> <?php
        } else {
            if($prev_pic > 0): ?>
                <button class="button" onclick='location.href="browse.php?pic_id=<?php echo $prev_pic; ?>"'>Previous</button>
            <?php endif;
            if($next_pic > 0): ?>
                <button class="button" onclick='location.href="browse.php?pic_id=<?php echo $next_pic; ?> ?>"'>Next</button>
            <?php endif; ?>
            <div><img src="get_pic.php?pic_id=<?php echo $pic_id; ?>&full_size=1"></div> <?php
        }
    ?>
    </div>