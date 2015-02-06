<?php
namespace Model;

class PageManager 
{
    public $page;
    public $files;
    
    function __construct() 
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
                        
        } else {
            include $dir . "default.php";
        }
    }
    
    /*
    function modelIncluder()
    {
        $dir = __DIR__ . '/../model/';
        $this->checkDirectories($dir);
    }*/
    
    function modelIncluder()
    {
            include "model/login.php";
            include "templates/login.php";
    }
            
    function templateIncluder()
    {
        $dir = __DIR__ . '/../templates/';
        $this->checkDirectories($dir);
    }
}
