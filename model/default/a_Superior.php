<?php

namespace Model;

class HomePage extends General
{
    public $db;
    public $texy;
   
    function __construct($db, $texy) 
    {
        $this->db = $db;
        $this->texy = $texy;
        
        $this->texy->encoding = 'UTF-8';
        $this->texy->typographyModule->locale = 'en';
        $this->texy->mergeLines = FALSE;
        $this->texy->allowedTags = \Texy::NONE;
    }
    
    function processTexy($string)
    {
        return $this->texy->process($string);
    }
    
    function processArticle($string)
    {
        $this->texy->headingModule->top = 2;
        
        return $this->processTexy($string);
    }
    
    function getAllArticles($arrays)
    {
        $sql = 'SELECT *, articles.id AS articles_id FROM articles LEFT JOIN users ON articles.author = users.fb_id ORDER BY articles.id DESC LIMIT :offset, :limit';
        
        $q = $this->db->query($sql, $arrays);
               
        return $q;
    }
    
    function getNumOfArticles() 
    {
        $sql = 'SELECT * FROM articles';
        $stmt = $this->db->numOfRows($sql);
        
        return $stmt; 
    }
    
    function getComments($arrays)
    {
        $sql = 'SELECT * FROM comments WHERE article_id = :id';
        $stmt = $this->db->numOfRows($sql, $arrays);
        
        return $stmt;
    }
}
