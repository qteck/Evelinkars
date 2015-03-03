<?php
namespace Model;

class PageManager 
{
    public $page;
    public $files;
    
    function __construct($page) 
    {
        $this->page = $page;
    }
    
    function checkDirectories($dir, $mode = null)
    {
        if(is_dir($dir))
        {
            foreach (glob($dir . '*', GLOB_ONLYDIR) as $value) {
                $e = array_reverse(explode('/', $value));
                                
                $this->files[] = $e[0];
            }
        }  

        if($this->files && in_array($this->page, $this->files)) 
        {               
            $pageFoo = (($mode == 1)? $this->page . '/c_Init':$this->page);
            
            $path = $dir . $pageFoo . '.php';
                        
        } 
          else 
        {
            $homepage = (($mode == 1)? 'default/c_Init': 'default');
            
            $path = $dir . $homepage . '.php';
        }
        
        return $path;
    }
}
