<?php
namespace Model;

class Tags extends General
{
    public $db;
    public $texy;
    
    public $stmt;
    
    function __construct($db, $texy) {
        $this->db = $db;
        $this->texy = $texy;
        
        $this->texy->encoding = 'UTF-8';
        $this->texy->typographyModule->locale = 'en';
        $this->texy->mergeLines = FALSE;
        $this->texy->allowedTags = \Texy::NONE;
    }
    
    function getContentByTag($arrays)
    {
        $sql = "SELECT * FROM tags INNER JOIN tags_refs refs ON refs.tag_id = tags.id INNER JOIN articles ON refs.article_id = articles.id WHERE tags.tag = :tagSelector";
        
        $this->stmt = $this->db->query($sql, $arrays);        
    }
    
    function result()
    {
        return $this->stmt;
    }
}