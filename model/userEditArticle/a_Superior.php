<?php

namespace Model;

class EditArticle
{
    public $db; 
    
    public function __construct($db) 
    {
        $this->db = $db;
    }
    
    public function getArticleById($arrays)
    {
        $sql = 'SELECT * FROM articles WHERE id = :id AND author = :author';
        $stmt = $this->db->queryFetch($sql, $arrays);
        
        return $stmt;     
    }
    
    public function updateArticle($arrays)
    {
        $sql = 'UPDATE articles SET title = :title, content = :content, place = :place, added = NOW() WHERE id = :id AND author = :author';
        $state = $this->db->boolQuery($sql, $arrays);
        
        return $state;
    }
    
    public function previewArticle($where)
    {
        $_SESSION['editArticleContent']['title'] = $_POST['title'];
        $_SESSION['editArticleContent']['content'] = $_POST['content'];
        $_SESSION['editArticleContent']['place'] = $_POST['place']; 
        
        header("Location: ". $where);
    }
}