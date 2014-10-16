<?php
    session_start();
    if(isset($_SESSION['is_logged'])){
        if($_SESSION['is_logged'] === true){
            header('Location: index_logged.php?showPrivate=1');
            exit;
        }
    }
?>

<!DOCTYPE html>

<html>

<head>
    <title>Home</title>
    <meta charset="utf-8"/>
    <link href='http://fonts.googleapis.com/css?family=Hammersmith+One' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="styles/index1.css"/>
</head>

<body>
    <header class="header">
        <h2><span id="title-yellow">Pick</span><span id="title-blue">rist</span></h2>
    </header>
    <main>
        <section class="authentication">
            <form action="login.php" method="post" class="form">
                <div><label for="login">Name: </label> <input type="text" id="login" name="login"/></div>
                <div><label for="pass">Password: </label> <input type="password" id="pass" name="pass"/></div>
                <input type="submit" value="Login"/>
                <input type="hidden" name="log_post" value="1"/>
            </form>
            <form action="register.php" method="post" class="form">
                <div>
                    <label for="username">Username:</label><input type="text" id="username" name="username">
                </div>
                <div>
                    <label for="passReg">Password:</label><input type="password" id="passReg" name="pass">
                </div>
                <div>
                    <label for="user-mail">E-Mail:</label><input type="email" id="user-mail" name="user-mail">
                </div>
                <?php if(isset($_SESSION['msg'])): ?>
                    <div><p><?php echo $_SESSION['msg']; session_destroy(); ?></p></div>
                <?php endif; ?>
                <input type="submit" value="Register"/>
            </form>
        </section>
    </main>
    <footer>
        <section class="popular_pics">
            <?php
            $con=mysqli_connect("localhost","root","","gallery");
            $result = mysqli_query($con,"SELECT pic_id FROM pictures WHERE is_public=1 ORDER BY likes DESC");
            $publicPictures = array();
            while($row = mysqli_fetch_array($result)){
              $publicPictures[] = $row['pic_id'];
            }

            if(count($publicPictures) < 8){
                $topPictures = $publicPictures;
            } else{
                $topPictures = array_slice($publicPictures, 0, 8);
            }
            for($pic = 0; $pic < count($topPictures); $pic++): ?>
                <div class="picture">
                    <img src="get_pic.php?pic_id=<?php echo $topPictures[$pic]; ?>&full_size=0">
                </div>
           <?php endfor;
           ?>
        </section>
    </footer>
    <!--Scripts-->
    <script type="text/javascript">
        window.onload = function(){
            var stop = document.getElementById('stop');
            var play = document.getElementById('play');
            var sound = document.getElementById('sound');
            stop.addEventListener('click', function() {
                sound.pause();}, false);
            play.addEventListener('click', function(){
                sound.play();}, false)
        };
    </script>
</body>

</html>