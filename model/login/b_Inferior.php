<?php

$facebookLogIn = new FacebookLogIn($db);


if(isset($_SESSION['fb']['token']))
{  
    header('Location: /index.php');
    exit;
}