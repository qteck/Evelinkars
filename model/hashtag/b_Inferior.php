<?php

    $tag = new \Model\Tags($db, new Texy);
     echo  '<br><br><br><br>';
    $tagUrl = $_GET['tag']; //sanitize it. just hash and text or numbers
    \Tracy\Debugger::dump($tagUrl);
    
  
    //tag->result();
    $tag->getContentByTag(array(':tagSelector' => $tagUrl));