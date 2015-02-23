<?php
$content = $article->getArticle(array(':id' => $id));

$comments = $article->getComments(array(':id' => $id));

//sanitiye url in form tag / title
?>

<h1><?php echo $content['title']; ?></h1>

    <?php echo $content['content']; ?>

    <div style="border-bottom: 1px solid grey;padding-bottom: 8px;">    
        <div style="float:left;">
            <span>(<?php echo $content['place']; ?>, <?php echo date('j.n.Y', strtotime($content['added'])); ?>), 
            <?php echo $content['author']; ?>.
            </span>          
        </div>
        <div style="text-align: right;">
            <span>
                <?php if (!isset($_SESSION['fb']['token'])) { ?>
                    <a href="index.php?page=login.php" id="comment1">
                        Sign in and write a comment!
                    </a>
                <?php } else { ?>
                    <a href="" onclick="return false" id="comment1">
                        Write a comment!
                    </a>
                <?php } ?>
            </span>
        </div>
    </div>

<?php if (isset($_SESSION['fb']['token'])) { ?>            
<form action="index.php?page=article.php&id=<?php echo $id; ?>&name=<?php echo $content['title']; ?>" method="post" style="padding: 20px">
        <img src="<?php echo $_SESSION['fb']['url']; ?>" style="float: right;width: 100px;height: 100px;" alt="logo">
        Hello <?php echo ($_SESSION['fb']['gender'] == 'female'?'Miss':'Mr.') ?> <?php echo $_SESSION['fb']['name']; ?> , don't be shy, share your impressions!<br>
        <textarea name="comment_content" cols="64" rows="7"></textarea></br>
        <input type='text' name="place"><br>
        <input type="submit" name="comment" value="Post">
    </form>

    <script>
        $(document).ready(function() {
            $('#comment_form1').hide();
            $('#comment1').click(function(){
                $('#comment_form1').slideToggle('slow');  
            });
        });
    </script>
<?php } ?>

<h3>Comments (<?php echo count($comments); ?>)</h3>
<p>
    <?php 
        if (isset($notices)) { 
            foreach($notices as $notice){ echo $notice; } 
        } 
    ?>
</p>
<?php foreach ($comments as $comment) { ?>
    <p>
        <img src="<?php echo $comment['img']; ?>" style="float: left;width: 100px;height: 107px;margin-right: 10px;" alt="logo">
        <?php echo $comment['content']; ?>
    </p>
    <span>
        (<?php echo $comment['place']; ?>, <?php echo $comment['added']; ?> by miss <a href=""><?php echo $comment['author']; ?></a>)
    </span>
<?php } ?>