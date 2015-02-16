<?php

?>

<h1>Add article</h1>

<p>
    <?php 
        if (isset($notices)) { 
            foreach($notices as $notice){ echo $notice; } 
        } 
    ?>
</p>

<form action="index.php?page=userAddArticle.php" method="post">
    Title: <input type="text" name="title" style="width: 100%;"><br><br>
    Article Content: <textarea name="content" style="width: 100%;height: 300px;"></textarea><br>
    Place: <input type="text" name="place" style="width: 100%;"><br><br>
    <input type="submit" name="previewArticle" value="Preview"> <input type="submit" name="postArticle" value="Post it!">
</form>