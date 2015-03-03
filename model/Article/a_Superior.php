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
    
    function fillTheCommentsFieldsBySession($fields) 
    {
        $_SESSION['comment'] = $fields;
    }
    
}