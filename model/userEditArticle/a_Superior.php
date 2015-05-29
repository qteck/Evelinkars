<?php

namespace Model;

class EditArticle
{
    public $db; 
    public $stmt;
    
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
        $this->stmt = $this->db->boolQuery($sql, $arrays);
    }
    
        public function updateSuccess()
    {
        return $this->stmt;  
    }
    
    public function previewArticle($where)
    {
        $_SESSION['editArticleContent']['title'] = $_POST['title'];
        $_SESSION['editArticleContent']['content'] = $_POST['content'];
        $_SESSION['editArticleContent']['place'] = $_POST['place'];
        
        header("Location: ". $where);
    }
}