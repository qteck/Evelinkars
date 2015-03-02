<?php

namespace Model;

class HomePage
{
    public $db;
   
    function __construct($db) 
    {
        $this->db = $db;
    }
    
    function getAllArticles()
    {
        $sql = 'SELECT *, articles.id AS articles_id FROM articles LEFT JOIN users ON articles.author = users.fb_id ORDER BY articles.id DESC';
        
        $q = $this->db->query($sql);
               
        return $q;
    }
    
    function getComments($arrays)
    {
        $sql = 'SELECT * FROM comments LEFT JOIN users ON users.fb_id = comments.author WHERE comments.article_id = :id ORDER BY comments.id DESC';
        $stmt = $this->db->query($sql, $arrays);
        
        return $stmt;
    }
}

$homepage = new HomePage($db);

// create some global depo
function makeNiceTitleInUrl($title)
{
    $url = str_replace(array(' '), array('-'), mb_strtolower($title));
            
    return urlencode($url);
}