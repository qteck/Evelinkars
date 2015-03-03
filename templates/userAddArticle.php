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
    Title: <input type="text" name="title" value="<?php echo !isset($_SESSION['addArticleContent']['title'])?'': $_SESSION['addArticleContent']['title']; ?>" style="width: 100%;"><br><br>
    Article Content: 
    <textarea name="content" style="width: 100%;height: 300px;"><?php echo !isset($_SESSION['addArticleContent']['content'])?'': $_SESSION['addArticleContent']['content']; ?></textarea><br><br>
    Place of writing: 
    <input type="text" name="place" value="<?php echo !isset($_SESSION['addArticleContent']['place'])?'': $_SESSION['addArticleContent']['place']; ?>" style="width: 100%;"><br><br>
    <input type="submit" name="previewArticle" value="Preview">
    <input type="submit" name="postArticle" value="Post it!">
</form>