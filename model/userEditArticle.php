<?php

namespace Model;

class EditArticle
{
    public $db; 
    
    public function __construct($db) 
    {
        $this->db = $db;
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
        $state = $this->db->boolQuery($sql, $arrays);
        
        return $state;
    }
    
    public function previewArticle($where)
    {
        $_SESSION['articleContent']['title'] = $_POST['title'];
        $_SESSION['articleContent']['content'] = $_POST['content'];
        $_SESSION['articleContent']['place'] = $_POST['place']; 
        
        header("Location: ". $where);
    }
}

$editArticle = new EditArticle($db);

if(isset($_GET['edit']) AND is_numeric($_GET['id']))
{
    if($_SESSION['articleContent']['id'] != $_GET['id'])
    {
        $articleContent = $editArticle->getArticleById(array(':id' => $_GET['id'],
                                                         ':author' => $_SESSION['fb']['id']));
        if(empty($articleContent))
        {
            $notices[] = 'This article does not exist!';
        } else 
        {
            $_SESSION['articleContent'] = $articleContent;
        }
    }
    
        \Tracy\Debugger::dump($articleContent);
}

if(isset($_POST['previewArticle']))
{
    $editArticle->previewArticle('index.php?page=userPreviewArticle.php');
}

if(isset($_POST['postArticle']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = $_SESSION['fb']['id'];
    $place = trim($_POST['place']);
    $id = $_SESSION['articleContent']['id'];
    
    if(empty($title) OR empty($content) OR empty($place)) {
        $notices[] = 'All fields are supposed to be filled in.'; 
    } else
    {
        $state = $editArticle->updateArticle(array(':title' => $title, 
                                                   ':content' => $content, 
                                                   ':place' => $place, 
                                                   ':id' => $id, 
                                                   ':author' => $author));
        if($state)
        {
            $notices[] = 'Article has been updated!';
        } else
        {
            $notices[] = 'Article has not been updated! Some issues have been appeared.';
        }
    }
}

/*
 * vytvořit funkci jenom pro edit kde se budou nahrazovat jenom obsahy session. na preview. 
 * merge it with usertAddArticle. insert on duplicate key
 * ----http://dev.mysql.com/doc/refman/5.0/en/insert-on-duplicate.html
 */