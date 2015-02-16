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
        $stmt = $this->db->query($sql, $arrays);
        
        return $stmt;
        
    }
}

$article = new Article($db);
