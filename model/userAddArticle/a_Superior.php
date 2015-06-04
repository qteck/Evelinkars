<?php
namespace Model;

class AddArticle
{
    public $db;
    
    public $stmt;
    
    function __construct($db) {
        $this->db = $db;
    }
    
    function hashTagSelect($tag)
    {
        preg_match_all('{\#([a-zA-Z0-9]+)}', $tag, $matches);
        
        return $matches[1];
    }
    
    function hashTagInsert($tags) 
    {        
        $lastInsertId = $this->db->lastId();
            
        foreach ($tags as $val)
        {
            $sql = 'INSERT INTO tags (tag, added) VALUES (:tag, NOW()) ON DUPLICATE KEY UPDATE occurrence = occurrence + 1';
            $stmt = $this->db->boolQuery($sql, array(':tag' => $val));
            
            if(!$stmt)
            {
               $sql3 = 'SELECT id FROM tags WHERE tag = :tag';
               
               $existingTagId = $this->db->queryFetch($sql3, array(':tag' => $val));
            }
            
            $tagId = (isset($existingTagId)? $existingTagId : $this->db->lastId());
            
            $sql2 = 'INSERT INTO tags_refs (article_id, tag_id) VALUES (:lastInsertId, :tagId)';
            $this->db->boolQuery($sql2, array(':lastInsertId' => $lastInsertId,
                                              ':tagId' => $tagId));
            
            unset($existingTagId);
        }
    }    
    
    ///check the stmt return
    function insertArticle($arrays)
    {
        $sql = 'INSERT INTO articles (title, content, author, place, added) '
                . 'VALUES (:title, :content, :author, :place, NOW()) ';
        
        $this->stmt = $this->db->boolQuery($sql, $arrays);
    }
    
    
    function insertSuccess()
    {
        return  $this->stmt;
    }
       
    public function previewArticle($where)
    {
        //better insert them trhough parameters 
        // dont forget sanitize this sweet superglobals
        $_SESSION['addArticleContent']['title'] = $_POST['title'];
        $_SESSION['addArticleContent']['content'] = $_POST['content'];
        $_SESSION['addArticleContent']['place'] = $_POST['place']; 
        
        header("Location: ". $where); 
    }
    
}