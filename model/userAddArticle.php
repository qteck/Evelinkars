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
        $sql = 'INSERT INTO articles (title, content, author, place, added) VALUES (:title, :content, :author, :place, NOW())';
        $stmt = $this->db->boolQuery($sql, $arrays);
        
        return ($stmt?true:false);
    }
    

}

$addArticle = new AddArticle($db);

if(!isset($_SESSION['fb']['token']))
{  
    header('Location: /index.php');
    exit;
}

if(isset($_POST['postArticle'])) {
    
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author = $_SESSION['fb']['id'];
    $place = $_POST['place'];
    
    if(empty($title) OR empty($content) OR empty($place)) {
        $notices[] = 'All fields are supposed to be filled in.'; 
    } 
    else {
        $addArticle->insertArticle(array(':title' => $title,
                                         ':content' => $content,
                                         ':author' => $author,
                                         ':place' => $place));
        
        $notices[] = 'Article has been post';
    }
}