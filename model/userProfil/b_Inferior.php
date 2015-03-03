<?php

$userProfil = new \Model\UserProfil($db);

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