<?php
include 'common.php';

if($_SESSION['is_logged']===true){
    if(isset($_FILES['user_pic'])){
        // checks if the file is uploaded
        if($_FILES['user_pic']['tmp_name']){
            // checks if the file is bigger than 2MB (2MB = 20971152bytes)
            if($_FILES['user_pic']['size'] > 2097152){
                $err[] = 'The file is more than 2MB';
            }
            // checks for valid image type - more types can be added to the list
            if($_FILES['user_pic']['type']!='image/gif' &&
                $_FILES['user_pic']['type']!='image/jpeg' &&
                $_FILES['user_pic']['type']!='image/pjerg'){
                $err[] = 'The file is not a picture';
            }
            if(!$_POST['folder']>0){
                $err[] = 'Please choose a category';
            }
            // if there aren't any mistakes continue with the execution of the code
            // count($err)==0 - Original code
            if(!isset($err)){
                // creates a user folder with his id
                if(!is_dir('user_pics'.DIRECTORY_SEPARATOR.$_SESSION['user_id'])){
                    mkdir('user_pics'.DIRECTORY_SEPARATOR.$_SESSION['user_id']);
                }
                $name = time().'_'.$_FILES['user_pic']['name'];
                // moves uploaded file
                if(move_uploaded_file($_FILES['user_pic']['tmp_name'],
                    'user_pics'.DIRECTORY_SEPARATOR.$_SESSION['user_id'].DIRECTORY_SEPARATOR.$name))

                {
                    //Original code $_POST['is_public'] == 1
                    if(isset($_POST['is_public'])){
                        $public = 1;
                    }
                    else{
                        $public = 0;
                    }
                    run_q('INSERT INTO pictures (pic_name, catalogue_id, comment, date_added, is_public) VALUES
                    ("'.$name.'",'.(int)$_POST['folder'].',"'.mysql_real_escape_string(addslashes($_POST['user_desc'])).'",'
                    .time().','.$public.')');
                    create_thumb('user_pics'.DIRECTORY_SEPARATOR.$_SESSION['user_id'].DIRECTORY_SEPARATOR.$name);
                    $success = true;
                } else {
                    $err[] = 'Error while copying file. Please try again.';
                }

            }
        }
    }

    $folders=fetch_all(run_q('SELECT * FROM user_catalogues WHERE user_id='.$_SESSION['user_id']));
    $cssFile = 'upload.css';
    $pageTitle = 'Upload';
    include 'templates/header.php';
    include 'templates/upload.php';
    include 'templates/footer.php';
} else {
    header('Location: index.php');
    exit;
}

function create_thumb($sourse, $thumb_width = 100){
    $fl = dirname($sourse);
    $new_name = 'thumb_'.basename($sourse);
    $img = imagecreatefromjpeg($sourse);
    $width = imagesx($img);
    $height = imagesy($img);
    $new_width = $thumb_width;
    $new_height = floor($height * ($thumb_width / $width));
    $tmp_img = imagecreatetruecolor($new_width, $new_height);
    imagecopyresized($tmp_img, $img, 0,0,0,0, $new_width, $new_height, $width, $height);
    imagejpeg($tmp_img, $fl.DIRECTORY_SEPARATOR.$new_name);
}