    <form method="post" class="form">
        <div>
            <label for="new_folder_name">Name: </label>
            <input type="text" id="new_folder_name" name="new_folder_name" placeholder="Enter folder name"/>
            <?php
            if(isset($error)){
                if(count($error)>0){
                    foreach($error as $v): ?>
                        <div class="error-message"> <?php echo htmlentities($v); ?></div>
                    <?php endforeach;
                }
            }
            ?>
            <input type="submit" value="Add folder"/>
            <input type="hidden" name="fs" value="1"/>
        </div>
    </form>
    <div id="catalogues-wrapper">
        <div class="catalogues-header">
            <p>
                My Catalogues
            </p>
        </div>
        <div class="catalogues">
        <?php
        foreach($folders as $v):
             $cataloguePics = fetch_all(run_q('SELECT p.pic_id FROM pictures as p WHERE p.catalogue_id='.$v['catalogue_id']));
             if(isset($cataloguePics[0]['pic_id'])){
                $firstPic = $cataloguePics[0]['pic_id'];?>
                <div><a href="browse.php?pic_id=<?php echo $firstPic; ?>&browsePrivate"><?php echo htmlentities($v['name']); ?></a></div>
             <?php } else{ ?>
                <div><a href="#""><?php echo htmlentities($v['name']); ?></a></div>
             <?php }
        endforeach;
        ?>
        </div>
    </div>
