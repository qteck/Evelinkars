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
        function makeItHashTag ($tag)
        {
            $x = array();
    
            foreach ($tag as $key1 => $val1)
            {
                $e = explode(' ', $val1);

                $x[$key1] = implode('', array_map('ucfirst', explode(' ', $val1)));

            }

            return $x;
    
        }
        
        try 
        {
        
            $db->beginTransaction();
        
            $addArticle->insertArticle(array(':title' => $title,
                                             ':content' => $content,
                                             ':author' => $author,
                                             ':place' => $place));
        
            $title = $title;
            $author = $_SESSION['fb']['name'];
    
            $tagsFromContent = $addArticle->hashTagSelect($content);
            $addArticle->hashTagInsert(array_merge($tagsFromContent, makeItHashTag(array($title, $author))));
            
            $db->commitTransaction();
            
            $notices[] = 'Article has been posted';
            $_SESSION['addArticleContent'] = '';
  
            
        // build up $article->fillTheCommentsFieldsBySession(); for this ocassion
 
        } 
          catch (Exception $ex) 
        {
            $db->rollbackTransaction();
            $notices[] = 'Article has not been posted! Some issues have been appeared.';
        }
    }
}