<?php 

    $bb = $homepage->getAllArticles();
    $i = 0;
?>

<?php foreach($bb as $content) { $i++; ?>
    <h2>
        <a href="index.php?page=article.php&id=<?php echo $content['articles_id']; ?>&title=<?php echo \Model\makeNiceTitleInUrl($content['title']); ?>">
            <?php echo $content['title']; ?>
        </a>
    </h2>

    <?php echo $content['content']; ?>

    <div style="border-bottom: 1px solid grey;padding-bottom: 8px;">    
        <div style="float:left;">
            <span>(<?php echo $content['place']; ?>, <?php echo date('j.n.Y', strtotime($content['added'])); ?>), 
            <?php echo $content['fb_name']; ?>.
            </span>          
        </div>
        <div style="text-align: right;">
            <span>
                <?php if (!isset($_SESSION['fb']['token'])) { ?>
                    <a href="index.php?page=login.php" id="comment_<?php echo $i; ?>">
                        Sign in and write a comment!
                    </a>
                <?php } else { ?>
                    <a href="" onclick="return false" id="comment_<?php echo $i; ?>">
                        Write a comment!
                    </a>
                <?php } ?>
            </span>
        </div>
    </div>

    <?php if (isset($_SESSION['fb']['token'])) { ?>            
        <form id="comment_form_<?php echo $i; ?>" style="padding: 20px">
            <img src="<?php echo $_SESSION['fb']['url']; ?>" style="float: right;width: 100px;height: 100px;" alt="logo">
            Hello <?php echo ($_SESSION['fb']['gender'] == 'female'?'Miss':'Mr.') ?> <?php echo $_SESSION['fb']['name']; ?> , don't be shy, share your impressions!<br>
            <textarea cols="64" rows="7"></textarea></br>
            Location: <input type='text' value="The Earth" name="place"><br>
            <input type="submit" value="Post">
        </form>

        <script>
            $(document).ready(function() {
                $('#comment_form_<?php echo $i; ?>').hide();
                $('#comment_<?php echo $i; ?>').click(function(){
                    $('#comment_form_<?php echo $i; ?>').slideToggle('slow');  
                });
            });
        </script>
    <?php } ?>

    <?php 
        $comments = $homepage->getComments(array(':id' => $content['articles_id'])); 
        $numOfComments = empty($comments)?'0':count($comments);
    ?>
        
    <h3>
        Comments 
        (<?php echo $numOfComments; ?>)
    </h3>
    <?php if ($numOfComments == 0) { ?>
        <p class="comment-sisy">There's been no comment added but I've got an idea. I'll tell you as a man. Don't be sisy and show us what's on your mind.</p>
    <?php } ?>
 
    <?php foreach ($comments as $comment) { ?>
        <div style="min-height: 107px;padding-bottom: 10px;margin-bottom: 10px;border-bottom: 1px solid #c0cae2">
            <p>
                <img src="<?php echo $comment['fb_url_photo']; ?>" style="float: left;width: 100px;height: 107px;margin-right: 10px;" alt="logo">
                <?php echo $comment['content']; ?>
            </p>
            <span>
                (<?php echo $comment['place']; ?>, <?php echo date('j.n.Y',strtotime($comment['added'])); ?> by <?php echo ($comment['fb_gender'] == 'female'?'Miss':'Mr.') ?> <a href=""><?php echo $comment['fb_name']; ?></a>)
            </span>
        </div>
    <?php } ?>
<?php } ?>