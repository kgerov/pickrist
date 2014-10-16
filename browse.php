<?php
    include 'common.php';
    if($_SESSION['is_logged']===true) {
        $pic_id = (int)$_GET['pic_id'];
        $select = '';

        if(isset($_GET['browsePublic'])){
            $select = 'SELECT pic_id, likes FROM pictures WHERE
            catalogue_id=(SELECT catalogue_id FROM pictures WHERE pic_id='.$pic_id.') AND is_public=1 ORDER BY pic_id';
            $res = run_q("SELECT `likes` FROM `pictures` WHERE pic_id=".$pic_id);
            $likesNum = mysql_result($res, 0, 0);
            if(empty($likesNum)){
                $likesNum = 0;
            }
        } else {
            $select = 'SELECT pic_id FROM pictures WHERE
            catalogue_id=(SELECT catalogue_id FROM pictures WHERE pic_id='.$pic_id.') ORDER BY pic_id';
        }
        if($pic_id > 0){
            $rs = run_q($select);
            while($row = mysql_fetch_assoc($rs)){
                $ar_pics[] = $row['pic_id'];
            }
            $id = array_search($pic_id, $ar_pics);
            $prev_pic = 0;
            $next_pic = 0;

            if($id > 0){
                $prev_pic = $ar_pics[($id - 1)];
            }
            if(isset($ar_pics[($id + 1)])){
                if($id < count($ar_pics))
                {
                    $next_pic = $ar_pics[($id + 1)];
                }
            }

        }

        $cssFile = 'browse1.css';
        $pageTitle = 'My album';
        include 'templates/header.php';
        include 'templates/browse.php';
        include 'templates/footer.php';
    }
    else
    {
        $pic_id = (int)$_GET['pic_id'];
        if($pic_id > 0){
            $rs = run_q('SELECT pic_name FROM pictures WHERE pic_id='.$pic_id.' AND is_public=1');
            $row = mysql_fetch_assoc($rs);
            if($row['pic_name']){
                include 'templates/browse.php';
            }
            else{
                header('Location: index.php');
                return;
            }
        }
        else{
            header('Location: index.php');
            return;
        }
    }
