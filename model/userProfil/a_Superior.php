<?php
namespace Model;

class UserProfil extends General
{
    public function __construct($db) 
    {
        $this->db = $db;
    }
    
    public function getTitles()
    {
        $sql = 'SELECT id, title FROM articles ORDER BY id DESC';
        $stmt = $this->db->query($sql);
        
        return $stmt;
    }
    
    public function getThePhoto($arrays)
    {
        $sql = 'SELECT url FROM users WHERE id = :id';
        $stmt = $this->db->queryFetch($sql, $arrays);
        
        return $stmt;
    }
    
    public function deleteArticle($arrays)
    {
        $sql= 'DELETE FROM articles WHERE id = :id AND author = :author';
        $state = $this->db->boolQuery($sql, $arrays);
        
        return $state;
    }
}