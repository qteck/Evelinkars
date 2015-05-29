<?php
namespace Model;

class UserEditPreviewArticle extends General
{
    public $texy;
    
    function __construct($texy) {

        $this->texy = $texy;
        
        $this->texy->encoding = 'UTF-8';
        $this->texy->typographyModule->locale = 'en';
        $this->texy->mergeLines = FALSE;
        $this->texy->allowedTags = \Texy::NONE;

    }
    
    function processTexy($string)
    {
        return $this->texy->process($string);
    }
    
    function processArticle($string)
    {
        $this->texy->headingModule->top = 2;
        
        return $this->hashTagIntoUrl($this->processTexy($string));
    }
}