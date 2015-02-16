<?php
namespace Model;

class UserProfil
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
}

$userProfil = new UserProfil($db);

// create some global depo
function makeNiceTitleInUrl($title)
{
    $url = str_replace(array(' '), array('-'), mb_strtolower($title));
            
    return urlencode($url);
}