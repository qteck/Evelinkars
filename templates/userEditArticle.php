<?php

?>

<h1>Edit article</h1>

<p>
    <?php 
        if (isset($notices)) { 
            foreach($notices as $notice){ echo $notice; } 
        } 
    ?>
</p>

<form action="index.php?page=userEditArticle&id=<?php echo $_SESSION['editArticleContent']['id']; ?>&edit=1" method="post">
    Title: <input type="text" name="title" value="<?php echo $_SESSION['editArticleContent']['title']; ?>" style="width: 100%;"><br><br>
    Article Content: 
    <textarea name="content" style="width: 100%;height: 300px;"><?php echo $_SESSION['editArticleContent']['content']; ?></textarea><br>
    Place: <input type="text" name="place" value="<?php echo $_SESSION['editArticleContent']['place']; ?>" style="width: 100%;"><br><br>
    <input type="submit" name="previewArticle" value="Preview">
    <input type="submit" name="postArticle" value="Save changes!">
</form>