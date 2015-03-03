<?php 

$limitOfArticles = 2;
        
$numOfArticles = $homepage->getNumOfArticles();
        
$numOfArticlesPages = ceil($numOfArticles/$limitOfArticles);

$currentPageOfArticles = !isset($_GET['articles-page'])? 0:$_GET['articles-page'];
$currentPageOfArticles = (!is_numeric($currentPageOfArticles) OR $currentPageOfArticles < 0)? 0:$currentPageOfArticles; // checked value lower than zero or not integer      
$currentPageOfArticles = ($currentPageOfArticles >= $numOfArticlesPages)? $numOfArticlesPages-1: $currentPageOfArticles; // checked if the value is higher than existed pages
        
$articles = $homepage->getAllArticles(array(':offset' => ($currentPageOfArticles*$limitOfArticles),
                                            ':limit' => $limitOfArticles)); 

?>

<?php foreach($articles as $content) { ?>
    <h2>
        <a href="index.php?page=article&id=<?php echo $content['articles_id']; ?>&title=<?php echo $homepage->makeNiceTitleInUrl($content['title']); ?>">
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
                <a href="index.php?page=article&id=<?php echo $content['articles_id']; ?>&title=<?php echo $homepage->makeNiceTitleInUrl($content['title']); ?>#comments-bookmark">Comments</a>
                (<?php 
                    echo $homepage->getComments(array(':id' => $content['articles_id'])); 
                ?>)
            </span>
        </div>
    </div>
  
<?php } ?>

<div style="text-align: right;margin: 8px 0 20px 0">

    <?php if(($numOfArticlesPages > 1) AND ($currentPageOfArticles > 0)) { ?>
        <div style="float:left;text-align: left;font-size: 0.8rem;">
            <a href="/index.php?articles-page=<?php echo $currentPageOfArticles-1; ?>">
                newer articles
            </a>
        </div>
    <?php } ?>
    
    <?php if($numOfArticlesPages > $currentPageOfArticles+1) { ?>
            
        <div style="font-size: 0.8rem;">
            <a href="/index.php?articles-page=<?php echo $currentPageOfArticles+1; ?>">
                older articles
            </a>
        </div>
    <?php } ?>
    
    <?php if($numOfArticlesPages > 0) { ?>
        <div style="clear:both;text-align: center;font-size: 0.8rem;">
            <?php echo ($currentPageOfArticles+1) . ' / ' . $numOfArticlesPages; ?>
        </div>
    <?php } ?>    
</div>