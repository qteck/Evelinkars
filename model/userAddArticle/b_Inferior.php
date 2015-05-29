<?php 

$addArticle = new \Model\AddArticle($db);

if(!isset($_SESSION['fb']['token']))
{  
    header('Location: /index.php');
    exit;
}


if(isset($_POST['previewArticle']))
{
    $addArticle->previewArticle('index.php?page=userAddPreviewArticle');
    exit;
}

if(isset($_POST['postArticle'])) {
    
    $title = htmlspecialchars(trim($_POST['title']));
    $content = trim($_POST['content']);
    $author = $_SESSION['fb']['id'];
    $place = htmlspecialchars(trim($_POST['place']));
    
    if(empty($title) OR empty($content) OR empty($place)) 
    {
        $notices[] = 'All fields are supposed to be filled in.'; 
        
        // build up $article->fillTheCommentsFieldsBySession(); for this ocassion
    } 
      else 
    {
        $addArticle->insertArticle(array(':title' => $title,
                                                  ':content' => $content,
                                                  ':author' => $author,
                                                   ':place' => $place));
        
        //ulozit clanek dostat - last inserted id 
        //
        
        if($addArticle->insertSuccess())
        {
            $tagsFromContent = $addArticle->hashTagSelect($content);
            $addArticle->hashTagInsert($tagsFromContent);
            
            $notices[] = 'Article has been posted';
            $_SESSION['addArticleContent'] = '';
        } else
        {
            $notices[] = 'Article has not been posted! Some issues have been appeared.';
            
            
        // build up $article->fillTheCommentsFieldsBySession(); for this ocassion
        }
    }
}