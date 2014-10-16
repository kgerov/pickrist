<?php

include 'common.php';

if($_SESSION['is_logged']===true){
    if(isset($_POST['fs'])){
        if($_POST['fs']==1){
            $new_name=addslashes(trim($_POST['new_folder_name']));
            if(strlen($new_name)>1){
                $rs = run_q('SELECT COUNT(*) as cnt FROM user_catalogues
                            WHERE user_id='.$_SESSION['user_id'].' AND name="'.$new_name.'"');
                $row = mysql_fetch_assoc($rs);
                if($row['cnt']==0){
                    run_q('INSERT INTO user_catalogues (user_id,name) VALUES ('.$_SESSION['user_id'].',"'.$new_name.'")');
                }else{
                    $error[]='The name already exists';
                }
            } else {
                $error[]='Please enter a name!';
            }
        }

    }


    $folders = fetch_all(run_q('SELECT * FROM user_catalogues WHERE user_id='.$_SESSION['user_id']));
    $cssFile = 'user_folders1.css';
    $pageTitle = 'My Folders';
    include 'templates/header.php';
    include 'templates/user_folders.php';
    include 'templates/footer.php';
} else {
    header('Location: index.php');
    exit;
}