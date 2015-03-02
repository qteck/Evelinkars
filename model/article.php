<?php
namespace Model;

class Article
{
    public $db;
    
    function __construct($db) {
        $this->db = $db;
    }
    
    function getArticle($arrays)
    {
        $sql = 'SELECT *, articles.id AS articles_id FROM articles LEFT JOIN users ON articles.author = users.fb_id WHERE articles.id = :id ORDER BY articles.id DESC';
        $stmt = $this->db->queryFetch($sql, $arrays);
        
        if(!$stmt) 
        {
            throw new \Exception ('This article doesn\'t exist.', '404');
        }
        
        return $stmt;
        
    }
    
    function getNumOfComments($arrays)
    {
        $sql = 'SELECT * FROM comments WHERE article_id = :id';
        $stmt = $this->db->numOfRows($sql, $arrays);
        
        return $stmt;
    }

    
    function getComments($arrays)
    {
        $sql = 'SELECT *, comments.id AS commentsId FROM comments LEFT JOIN users ON users.fb_id = comments.author WHERE comments.article_id = :id ORDER BY comments.id DESC LIMIT :offset, :limit';
        $stmt = $this->db->query($sql, $arrays);
        
        return $stmt;
    }
    
    function insertComment($arrays)
    { 
        $sql = 'INSERT INTO comments (content, author, place, added, article_id) VALUES (:content, :author, :place, NOW(), :article_id)';
        $stmt = $this->db->boolQuery($sql, $arrays);

        return $stmt;
    } 
    
    function fillTheCommentsFieldsBySession() 
    {
        
    }
    
}

$article = new Article($db);

$id = (!is_numeric($_GET['id'])?'1':$_GET['id']);

if(isset($_POST['comment']))
{
    $comment = $_POST['comment_content'];
    $place = $_POST['place'];
    
    if(empty($comment) OR empty($place))
    {
        $notices[] = 'All fields are supossed to be filed in.';
        
        $article->fillTheCommentsFieldsBySession();
    } 
      else
    {
        $state = $article->insertComment(array(':content' => $comment,
                                               ':place' => $place,
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
      echo $e->getMessage();
      exit;
    //header('Location: index.php?page=&info='. $e->getMessage()); // and 5 second later redirect to index.
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
