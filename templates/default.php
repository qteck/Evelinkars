<?php 

    $bb = $homepage->getAllArticles();
    
?>

<?php foreach($bb as $content) { ?>
    <h2>
        <a href="index.php?page=article.php&id=<?php echo $content['id']; ?>&title=<?php echo \Model\makeNiceTitleInUrl($content['title']); ?>">
            <?php echo $content['title']; ?>
        </a>
    </h2>

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
<?php } ?>

<?php if (isset($_SESSION['fb']['token'])) { ?>            
    <form id="comment_form1" style="padding: 20px">
        <img src="<?php echo $_SESSION['fb']['url']; ?>" style="float: right;width: 100px;height: 100px;" alt="logo">
        Hello <?php echo ($_SESSION['fb']['gender'] == 'female'?'Miss':'Mr.') ?> <?php echo $_SESSION['fb']['name']; ?> , don't be shy, share your impressions!<br>
        <textarea cols="64" rows="7"></textarea></br>
        <input type="submit" value="Post">
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

<h3>Comments (16)</h3>
<p><img src="images/evelinka.jpg" style="float: left;width: 100px;height: 107px;margin-right: 10px;" alt="logo">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
<span>(UK, Bournemouth, 03.01.2015 by miss <a href="">Bla Bla</a>)</span>
