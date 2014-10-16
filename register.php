<?php
include 'common.php';

try{
    $msg = '';
    if(isset($_POST["username"]) && isset($_POST["pass"]) && isset($_POST["user-mail"])) {
        $username =  mysql_real_escape_string(addslashes(trim($_POST['username'])));
        $email = mysql_real_escape_string($_POST["user-mail"]);
        $password =  mysql_real_escape_string(md5($_POST['pass']));
        $date_reg = time();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $msg = "Invalid email format";
            throw new Exception();
        }

        $sql=mysql_query("SELECT * FROM users WHERE login='$username'");
        if(mysql_num_rows($sql)>0){
            $msg = "Name already exists";
            throw new Exception();

        }

        $sql = mysql_query("SELECT * FROM users WHERE email='$email'");
        if(mysql_num_rows($sql)>0){
            $msg = "E-mail already exists";
            throw new Exception();
        }

        $query = "INSERT INTO users (login, pass, email, date_reg) VALUES ('$username', '$password', '$email', '$date_reg')";
        $result = run_q($query);
        if($result){
            $msg = "User Created Successfully.";
            throw new Exception();
        }
    }
} catch (Exception $e){
    $_SESSION['msg'] = $msg;
    header('Location: index.php');
}