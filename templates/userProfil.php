<?php 

    $titles = $userProfil->getTitles();

?>

<h1>Petr Stejskal</h1>
<p>
    <?php 
        if (isset($notices)) { 
            foreach($notices as $notice){ echo $notice; } 
        } 
    ?>
</p>

<img src="images/evelinka.jpg" style="float: right;" alt="Petr Stejskal">

<h2>Added articles</h2>
<ul>
    <?php foreach($titles as $content) { ?>
    <li>
        <a href="index.php?page=article.php&id=<?php echo $content['id']; ?>&title=<?php echo \Model\makeNiceTitleInUrl($content['title']); ?>"><?php echo $content['title']; ?></a> - 
        <a href="index.php?page=userEditArticle.php&id=<?php echo $content['id']; ?>&edit=1">edit</a> | 
        <a href="index.php?page=userProfil.php&id=<?php echo $content['id']; ?>&delete=1" onclick="return confirm('Are you sure?')">delete</a>
    </li>
    <?php } ?>
</ul>
<a href="index.php?page=userAddArticle.php">add another article</a>