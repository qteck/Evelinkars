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
    
    public function deleteArticle($arrays)
    {
        $sql= 'DELETE FROM articles WHERE id = :id AND author = :author';
        $state = $this->db->boolQuery($sql, $arrays);
        
        return $state;
    }
}

$userProfil = new UserProfil($db);

if(!isset($_SESSION['fb']['token']))
{  
    header('Location: /index.php');
    exit;
}

if(isset($_GET['delete']) AND isset($_GET['id']))
{
    if(is_numeric($_GET['id']))
    {
        $state = $userProfil->deleteArticle(array(':id' => $_GET['id'], ':author' => $_SESSION['fb']['id']));
       
        if($state)
        {
            $notices[] = 'Your article has been deleted.';
        } else
        {
            $notices[] = 'Problem has been occured. Try it again.';
        }
    } else 
    {
        $notices[] = 'Incorrect type of input!';
    }
}

// create some global depo
function makeNiceTitleInUrl($title)
{
    $url = str_replace(array(' '), array('-'), mb_strtolower($title));
            
    return urlencode($url);
}