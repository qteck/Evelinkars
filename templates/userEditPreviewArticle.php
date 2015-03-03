<p>You're located in article preview section. for more editing go back to <a href="index.php?page=userEditArticle&id=<?php echo $_SESSION['articleContent']['id']; ?>&edit=1">editting forms</a></p>
<h1><?php echo $_SESSION['editArticleContent']['title']; ?></h1>

    <?php echo $_SESSION['editArticleContent']['content']; ?>

    <div style="border-bottom: 1px solid grey;padding-bottom: 8px;">    
        <div style="float:left;">
            <span>(<?php echo $_SESSION['editArticleContent']['place']; ?>, <?php echo date('j.n.Y', time()); ?>), 
            <?php echo $_SESSION['fb']['name']; ?>.
            </span>          
        </div>
        <div style="text-align: right;">
            <span>
                <a href="index.php?page=userEditArticle&id=<?php echo $_SESSION['editArticleContent']['id']; ?>&edit=1">Go back to editing</a>
            </span>
        </div>
    </div>

