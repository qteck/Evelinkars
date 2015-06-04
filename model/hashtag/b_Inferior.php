<?php

    $tag = new \Model\Tags($db, new Texy);

    $tagUrl = htmlspecialchars($_GET['tag']); //sanitize it. just hash and text or numbers

    try
    {
        $tag->getContentByTag(array(':tagSelector' => $tagUrl));
    } 
      catch (\Exception $e) 
    {
        header('Location: /index.php?page=puppySlap&info='. urlencode($e->getMessage()));
        exit;
    }