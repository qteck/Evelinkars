<?php
namespace Model;

class General
{

    function makeNiceTitleInUrl($title)
    {
        $url = str_replace(array(' '), array('-'), mb_strtolower($title));
            
        return urlencode($url);
    }
    
    function contentOfTitleTag($title)
    {
        return $title;
    }
    
    function hashTagIntoUrl($tag)
    {
        $tagAsUrl = preg_replace_callback('{\#([a-zA-Z0-9]+)}', function($matches){
            return '<a href="index.php?page=hashtag&tag=' . $matches[1] . '">' . $matches[0] . '</a>';
            
        }, $tag);
        
        return $tagAsUrl;
    }
}
