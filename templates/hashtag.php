<h1>#<?php echo $tagUrl; ?></h1>

<?php foreach ($tag->result() as $content) { ?>
    <h2>
        <a href="index.php?page=hashtag&tag=<?php echo $content['tag']; ?>&title=<?php echo $tag->makeNiceTitleInUrl($content['title']); ?>">
            <?php echo $content['title']; ?>
        </a>
    </h2>
<?php } ?>
