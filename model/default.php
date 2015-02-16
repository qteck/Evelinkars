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
        $sql = 'SELECT * FROM articles ORDER BY id DESC';
        
        $q = $this->db->query($sql);
        
        return $q;
    }
}

$homepage = new HomePage($db);

// create some global depo
function makeNiceTitleInUrl($title)
{
    $url = str_replace(array(' '), array('-'), mb_strtolower($title));
            
    return urlencode($url);
}