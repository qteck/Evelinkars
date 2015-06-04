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
    
    function hashTagSelect($tag)
    {
        preg_match_all('{\#([a-zA-Z0-9]+)}', $tag, $matches);
        
        return $matches[1];
    }
    
    function hashTagInsert($tags, $id) 
    {        
        $lastInsertId = $id; //to get id of edited article instead of last id 
        
        foreach ($tags as $val)
        {
            $sql3 = 'SELECT id FROM tags WHERE tag = :tag';
               
            $existingTagId = $this->db->queryFetch($sql3, array(':tag' => $val));              
                
            if(!$existingTagId)
            {
                $sql = 'INSERT INTO tags (tag, added) VALUES (:tag, NOW())';
                $this->db->boolQuery($sql, array(':tag' => $val));
               
            }
            
            $tagId = (!empty($existingTagId)? array_shift($existingTagId) : $this->db->lastId());
            
            $sql2 = 'INSERT INTO tags_refs (article_id, tag_id) VALUES (:lastInsertId, :tagId)';
            $this->db->boolQuery($sql2, array(':lastInsertId' => $lastInsertId,
                                              ':tagId' => $tagId));
            
            unset($existingTagId);
        }
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
        
        
        //check up this sweet superglobal boobs
        $_SESSION['editArticleContent']['title'] = $_POST['title'];
        $_SESSION['editArticleContent']['content'] = $_POST['content'];
        $_SESSION['editArticleContent']['place'] = $_POST['place'];
        
        header("Location: ". $where);
    }
}