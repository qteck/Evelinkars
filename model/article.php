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
        $sql = 'SELECT * FROM articles WHERE id = :id';
        $stmt = $this->db->queryFetch($sql, $arrays);
        
        return $stmt;
        
    }
    
    function getComments($arrays)
    {
        $sql = 'SELECT * FROM comments WHERE article_id = :id ORDER BY id DESC';
        $stmt = $this->db->query($sql, $arrays);
        
        return $stmt;
    }
    
    function insertComment($arrays)
    { 
        $sql = 'INSERT INTO comments (content, author, place, added, article_id) VALUES (:content, :author, :place, NOW(), :article_id)';
        $stmt = $this->db->boolQuery($sql, $arrays);

        return $stmt;
    } 
}

$article = new Article($db);

$id = (!is_numeric($_GET['id'])?'1':$_GET['id']);

if($_POST['comment'])
{
    $comment = $_POST['comment_content'];
    $place = $_POST['place'];
    
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
        //in case this happens fill the session up and echo them in the form. 
    }
}
