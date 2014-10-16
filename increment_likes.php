<?php
    include 'common.php';
    if($_SESSION['is_logged']===true){
        $loggedUser = $_SESSION['user_id'];
        $pic_id = $_SESSION['pic_id'];
        $pictureOwner = mysql_fetch_assoc(run_q('SELECT uc.user_id FROM pictures as p, user_catalogues as uc
        WHERE p.pic_id='.$pic_id.' AND p.is_public=1 AND uc.catalogue_id=p.catalogue_id'));
        $pictureOwner = $pictureOwner['user_id'];
        if($pictureOwner != $loggedUser){
            $res = run_q("SELECT `likes` FROM `pictures` WHERE pic_id=".$pic_id);
            $likesNum = mysql_result($res, 0, 0);
            if (isset($_POST['likeButton'])){
                $likesNum++;
                $update = "UPDATE `pictures` SET `likes`=" . $likesNum . " WHERE pic_id=".$pic_id;
                $rs = run_q($update);
            }
            header('Location: browse.php?pic_id='.$pic_id.'&browsePublic=1');
        } else{
            header('Location: index_logged.php?showPublic');
        }

    } else{
        header('Location index.php');
    }
?>