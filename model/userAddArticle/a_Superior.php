<?php
namespace Model;

class AddArticle
{
    public $db;
    
    function __construct($db) {
        $this->db = $db;
    }
    
    ///check the stmt return
    function insertArticle($arrays)
    {
        $sql = 'INSERT INTO articles (title, content, author, place, added) '
                . 'VALUES (:title, :content, :author, :place, NOW()) ';
        
        $stmt = $this->db->boolQuery($sql, $arrays);
        
        return ($stmt?true:false);
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