<?php

$editArticle = new \Model\EditArticle($db);

if(isset($_GET['edit']) AND is_numeric($_GET['id']))
{
    $sessionArticleId = isset($_SESSION['editArticleContent']['id'])?$_SESSION['editArticleContent']['id']:null;
    
    if($sessionArticleId != $_GET['id'])
    {
        $articleContent = $editArticle->getArticleById(array(':id' => $_GET['id'],
                                                         ':author' => $_SESSION['fb']['id']));
        if(empty($articleContent))
        {
            $notices[] = 'This article does not exist!';
        } else 
        {
            $_SESSION['editArticleContent'] = $articleContent;
        }
    }
}

if(isset($_POST['previewArticle']))
{
    $editArticle->previewArticle('index.php?page=userEditPreviewArticle');
}

if(isset($_POST['postArticle']))
{
    $title = htmlspecialchars(trim($_POST['title']));
    $content = trim($_POST['content']);
    $author = $_SESSION['fb']['id'];
    $place = htmlspecialchars(trim($_POST['place']));
    $id = $_SESSION['editArticleContent']['id'];
    
    if(empty($title) OR empty($content) OR empty($place)) {
        $notices[] = 'All fields are supposed to be filled in.'; 
    } else
    {
        $editArticle->updateArticle(array(':title' => $title, 
                                                   ':content' => $content, 
                                                   ':place' => $place, 
                                                   ':id' => $id, 
                                                   ':author' => $author));
        if($editArticle->updateSuccess())
        {
            $notices[] = 'Article has been updated!'; 
            $_SESSION['editArticleContent'] = $editArticle->getArticleById(array(':id' => $_GET['id'],
                                                         ':author' => $_SESSION['fb']['id']));
            
        } else
        {
            $notices[] = 'Article has not been updated! Some issues have been appeared.';
        }
    }
}
        