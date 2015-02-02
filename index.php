<?php
require_once __DIR__ . '/vendor/tracy/tracy/src/tracy.php';

use Tracy\Debugger;

session_start();

Debugger::enable(Debugger::DEVELOPMENT);

class PageMannager 
{
    public $page;
    public $files;
    
    public function __construct() 
    {
        $this->page = isset($_GET['page'])? 
                                (filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS)):null;

    }
    
    function checkDirectories($dir)
    {
                    if(is_dir($dir))
                    {
                        foreach (glob($dir . '*') as $value) {
                            $e = array_reverse(explode('/', $value));
                                
                            $this->files[] = $e[0];
                        }
                    }  
                    
                    if($this->files && in_array($this->page, $this->files)) 
                    {               
                        include $dir . $this->page;
                        
                    } else 
                    {
                        include $dir . "default.php";
                    }
    }
    
            function modelIncluder()
            {
                $dir = __DIR__ . '/model/';
                $this->checkDirectories($dir);
            }
            
            function templateIncluder()
            {
                $dir = __DIR__ . '/templates/';
                $this->checkDirectories($dir);
                                   
   

            }
}

            $pages = new PageMannager();
            $pages->modelIncluder();
            
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Wild Evelinka and our love :-*</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="vendor/components/jquery/jquery.js"></script>
    </head>
    <style>

        body{font-size: 15px;font-family: times new roman;width: 720px;margin: auto;}
        #article{}
        span{font-size: 10px;}
    </style>    
    <body>
        
        <div style="text-align: center;margin: 40px 0;">
            <div style="float: left;">
                <a href="index.php"><img src="images/evelinka.jpg" style="width: 100px;height: 100px;" alt="logo"></a>
            </div>
            
            <div style="">
                <p>
                How I met the most beautiful girl in the world <br>
                and <br>
                she got me! <br>
                </p>
            
                <p style=""><a href="index.php?page=login.php">Facebook login</a></p>
            </div>
        </div>
        
        <div id="article">
            <?php
                $pages->templateIncluder();
            ?>
        </div>
    </body>
</html>
