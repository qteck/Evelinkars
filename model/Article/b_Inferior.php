<?php
namespace Model;

$article = new Article($db);

$id = (!is_numeric($_GET['id'])?'1':$_GET['id']);

if(isset($_POST['comment']))
{
    $comment['comment_content'] = $_POST['comment_content'];
    $comment['place']  = $_POST['place'];
    
    if(empty($comment['comment_content'] ) OR empty($comment['place']))
    {
        $notices[] = 'All fields are supossed to be filed in.';
        
        $article->fillTheCommentsFieldsBySession($comment);
    } 
      else
    {
        $state = $article->insertComment(array(':content' => $comment['comment_content'] ,
                                               ':place' => $comment['place'] ,
                                               ':article_id' => $id,
                                               ':author' => $_SESSION['fb']['id']));
    
        if($state)
        {
            $notices[] = 'Your comment has been posted.'; 
        }
        else
        {
            $notices[] = 'Your comment has not been posted';
            
            $article->fillTheCommentsFieldsBySession();
        }
    }
}

    
try
{
    $content = $article->getArticle(array(':id' => $id));
} 
  catch (\Exception $e)
{
    header('Location: /index.php?page=puppySlap.php&info='. $e->getMessage());
    exit;
}

$limitOfComments = 3;
        
$numOfComments = $article->getNumOfComments(array(':id' => $content['articles_id']));
        
$numOfCommentsPages = ceil($numOfComments/$limitOfComments);

$currentPageOfComments = !isset($_GET['comments-page'])?0:$_GET['comments-page'];
$currentPageOfComments = (!is_numeric($currentPageOfComments) OR $currentPageOfComments < 0)? 0:$currentPageOfComments; // checked value lower than zero or not integer      
$currentPageOfComments = ($currentPageOfComments >= $numOfCommentsPages)? $numOfCommentsPages-1: $currentPageOfComments; // checked if the value is higher than existed pages
        
$comments = $article->getComments(array(':id' => $content['articles_id'],
                                        ':offset' => ($currentPageOfComments*$limitOfComments),
                                        ':limit' => $limitOfComments)); 



// create some global depo
function makeNiceTitleInUrl($title)
{
    $url = str_replace(array(' '), array('-'), mb_strtolower($title));
            
    return urlencode($url);
}