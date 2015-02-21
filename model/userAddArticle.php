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
        $sql = 'INSERT INTO articles '
                . '(title, content, author, place, added, unique_key) VALUES '
                . '(:title, :content, :author, :place, NOW(), :unique_key) '
                . 'ON DUPLICATE KEY UPDATE title = :title, content = :content, place = :place';
        
        $stmt = $this->db->boolQuery($sql, $arrays);
        
        return ($stmt?true:false);
    }
    
    public function getArticleById($arrays)
    {
        $sql = 'SELECT * FROM articles WHERE id = :id AND author = :author';
        $stmt = $this->db->queryFetch($sql, $arrays);
        
        return $stmt;     
    }
    
    public function previewArticle($where)
    {
        $_SESSION['articleContent']['title'] = $_POST['title'];
        $_SESSION['articleContent']['content'] = $_POST['content'];
        $_SESSION['articleContent']['place'] = $_POST['place']; 
        
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
    $addArticle->previewArticle('index.php?page=userPreviewArticle.php');
    exit;
}


if(isset($_GET['edit']) AND is_numeric($_GET['id']))
{

    if((!isset($_SESSION['articleContent']['id'])?'':$_SESSION['articleContent']['id']) != $_GET['id'])
    {
        $articleContent = $addArticle->getArticleById(array(':id' => $_GET['id'],
                                                            ':author' => $_SESSION['fb']['id']));
        if(empty($articleContent))
        {
            $notices[] = 'This article does not exist!';
        } 
          else 
        {
            $_SESSION['articleContent'] = $articleContent;
        }
    }
}
  else
{
    if(!isset($_GET['edit'])) $_SESSION['articleContent'] = '';
}


if(isset($_POST['postArticle'])) {
    
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = $_SESSION['fb']['id'];
    $place = trim($_POST['place']);
    
    $unique_key = empty($_SESSION['articleContent']['unique_key'])?time() : $_SESSION['articleContent']['unique_key'];
    
    if(empty($title) OR empty($content) OR empty($place)) 
    {
        $notices[] = 'All fields are supposed to be filled in.'; 
    } 
      else 
    {
        $state = $addArticle->insertArticle(array(':title' => $title,
                                         ':content' => $content,
                                         ':author' => $author,
                                         ':place' => $place,
                                         ':unique_key' => $unique_key));
        if($state)
        {
            $notices[] = 'Article has been posted';
        } else
        {
            $notices[] = 'Article has not been posted! Some issues have been appeared.';
        }
    }
}