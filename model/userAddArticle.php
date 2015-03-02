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

$addArticle = new AddArticle($db);

if(!isset($_SESSION['fb']['token']))
{  
    header('Location: /index.php');
    exit;
}


if(isset($_POST['previewArticle']))
{
    $addArticle->previewArticle('index.php?page=userAddPreviewArticle.php');
    exit;
}

if(isset($_POST['postArticle'])) {
    
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = $_SESSION['fb']['id'];
    $place = trim($_POST['place']);
    
    if(empty($title) OR empty($content) OR empty($place)) 
    {
        $notices[] = 'All fields are supposed to be filled in.'; 
        
        // build up $article->fillTheCommentsFieldsBySession(); for this ocassion
    } 
      else 
    {
        $state = $addArticle->insertArticle(array(':title' => $title,
                                                  ':content' => $content,
                                                  ':author' => $author,
                                                   ':place' => $place));
        if($state)
        {
            $notices[] = 'Article has been posted';
        } else
        {
            $notices[] = 'Article has not been posted! Some issues have been appeared.';
            
            
        // build up $article->fillTheCommentsFieldsBySession(); for this ocassion
        }
    }
}