<?php
       

//sanitiye url in form tag / title
?>

<h1>~ <?php echo $content['title']; ?></h1>


<?php echo $article->processArticle($content['content']); ?>

<div style="border-bottom: 1px solid grey;padding-bottom: 8px;">    
    <div style="float:left;">
            
        <span>
            (<?php echo $content['place']; ?>, <?php echo date('j.n.Y', strtotime($content['added'])); ?>),
            <?php echo $content['fb_name']; ?>
        </span>          
    </div>
    <div style="text-align: right;">
        <span>
            <?php if (!isset($_SESSION['fb']['token'])) { ?>
                <a href="index.php?page=login" id="comment1">
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
    <form id="comment_form1" action="index.php?page=article&id=<?php echo $id; ?>&name=<?php echo $article->makeNiceTitleInUrl($content['title']); ?>#comments-bookmark" method="post">
        <img src="<?php echo $_SESSION['fb']['url']; ?>" alt="profile picture">
        <span>Hello <?php echo ($_SESSION['fb']['gender'] == 'female'?'Miss':'Mr.') ?> <?php echo $_SESSION['fb']['name']; ?>, 
        don't be shy, share your impressions!</span><br>
        <textarea name="comment_content"><?php echo (isset($_SESSION['comment']['comment_content'])? $_SESSION['comment']['comment_content']:''); ?></textarea></br>
        <span>Place of writing:</span> <input type='text' name="place"value="<?php echo (isset($_SESSION['comment']['place'])? $_SESSION['comment']['place']:'The Earth'); ?>"><br>
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
        
<h3 id="comments-bookmark">
    Comments 
    (<?php echo $numOfComments; ?>)
</h3>
    
<p>
    <?php 
        if (isset($notices)) { 
            foreach($notices as $notice){ echo $notice; } 
        } 
    ?>
</p>    
    
<?php if ($numOfComments == 0) { ?>
    <p class="comment-sisy">There's been no comment added but I've got an idea. I'll tell you as a man. Don't be sissy and show us what's on your mind.</p>
<?php } ?>
 
<?php foreach ($comments as $comment) { ?>
    <div style="min-height: 107px;padding-bottom: 10px;margin-bottom: 10px;border-bottom: 1px solid #c0cae2">
        <p>
            <img src="<?php echo $comment['fb_url_photo']; ?>" style="float: left;width: 100px;height: 107px;margin-right: 10px;" alt="logo">
            <?php echo $article->processComment($comment['content']); ?>
        </p>
        <span>
            (<?php echo $comment['place']; ?>, 
            <?php echo date('j.n.Y',strtotime($comment['added'])); ?> by 
            <?php echo ($comment['fb_gender'] == 'female'?'Miss':'Mr.') ?> 
            <a href=""><?php echo $comment['fb_name']; ?></a>)
        </span>
    </div>
<?php } ?>
            
<div style="text-align: right;margin: 8px 0 20px 0;">       
    <?php if(($numOfCommentsPages > 1) AND ($currentPageOfComments > 0)) { ?>
        <div style="float:left;text-align: left;font-size: 0.8rem;">
            <a href="/index.php?page=article&id=<?php echo $id; ?>&title=<?php echo $content['title']; ?>&comments-page=<?php echo $currentPageOfComments-1; ?>#comments-bookmark">
                newer comments
            </a>
        </div>
    <?php } ?>
    
    <?php if($numOfCommentsPages > $currentPageOfComments+1) { ?>
            
        <div style="font-size: 0.8rem;">
            <a href="/index.php?page=article&id=<?php echo $id; ?>&title=<?php echo $content['title']; ?>&comments-page=<?php echo $currentPageOfComments+1; ?>#comments-bookmark">
                older comments
            </a>
        </div>
    <?php } ?>
    
    <?php if($numOfCommentsPages > 0) { ?>
        <div style="clear:both;text-align: center;font-size: 0.8rem;">
            <?php echo ($currentPageOfComments+1) . ' / ' . $numOfCommentsPages; ?>
        </div>
    <?php } ?>
</div>
