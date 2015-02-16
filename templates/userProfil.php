<?php 

    $titles = $userProfil->getTitles();

?>

<h1>Petr Stejskal</h1>
<img src="images/evelinka.jpg" style="float: right;" alt="Petr Stejskal">

<h2>Added articles</h2>
<ul>
    <?php foreach($titles as $content) { ?>
    <li>
        <a href="index.php?page=article.php&id=<?php echo $content['id']; ?>&title=<?php echo \Model\makeNiceTitleInUrl($content['title']); ?>"><?php echo $content['title']; ?></a> - 
        <a href="<?php echo $content['id']; ?>">edit</a> | 
        <a href="<?php echo $content['id']; ?>" onclick="return confirm('Are you sure?')">delete</a>
    </li>
    <?php } ?>
</ul>
<a href="index.php?page=userAddArticle.php">add another article</a>