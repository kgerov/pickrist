    <div class="wrapper">
        <div class="header">
            <p>Upload your pictures</p>
        </div>
        <form method="post" enctype="multipart/form-data" class="form">
            <?php
            if(isset($success)){
                if($success): ?>
                    <div class="success"><?php echo 'The picture was uploaded successfully!'; ?></div>
                <?php endif;
            }
            if(isset($err)){
                if(count($err) > 0)
                {
                    foreach($err as $v): ?>
                        <div class="error"><?php echo htmlentities($v) ?></div>
                    <?php endforeach;
                }
            }

            ?>
            <div>
                <label for="file">Select file</label>
                <input type="file" id="file" name="user_pic" value="Select">
                <label for="catalogues">Catalogue</label>
                <select id="catalogues" name="folder" class="chosen-select">
                    <?php
                    foreach($folders as $v): ?>
                        <option value=<?php echo $v['catalogue_id'] ?>><?php echo htmlentities($v['name']); ?></option>
                    <?php endforeach;
                    ?>
                </select>
                <label for="description">Description</label>
                <textarea id="description" name="user_desc" cols="30" rows="6"></textarea>
                <label for="public">Public</label>
                <input type="checkbox" id="public" name="is_public" value="1"/>
                <input type="submit" value="Upload">
            </div>
        </form>
    </div>
    <script src="scripts/jquery-1.11.1.min.js"></script>
    <script>
        var maxLength = 15;
        $('#catalogues > option').text(function(i, text) {
            if (text.length > maxLength) {
                return text.substr(0, maxLength) + '...';
            }
        });
    </script>