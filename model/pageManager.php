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
            $path = $dir . $this->page;
                        
        } else {
            $path = $dir . "default.php";
        }
        
        return $path;
    }
}
