<?php
namespace Model;

class PuppySlap
{
    public $db;
    
    function __construct($db) {
        $this->db = $db;
    }
    // log issues in db
}