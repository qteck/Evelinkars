<?php
//namespace Control;

class DB
{
    protected $username = 'evelinkars';
    protected $passwd   = '';
    
    protected $dbName   = 'evelinkars';
    
    public $pdo;
    
    function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname='.$this->dbName, 
                                $this->username, 
                                    $this->passwd,
                                        array(PDO::ATTR_PERSISTENT => true,
                                              PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $this->pdo->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
    }
    /*
     * PDO FETCH ASSOC replace by fetch object - for working with stdClasses 
     */
    public function query($query, $arrays = null)
    {
        $stmt = $this->pdo->prepare($query);        
        $stmt->execute($arrays);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function queryFetch($query, $arrays = null)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($arrays);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    //check the state return - false - true
    public function boolQuery($query, $arrays = null)
    {
        $stmt = $this->pdo->prepare($query);
        $state = $stmt->execute($arrays);
        
        return $state;
    }
    
    public function numOfRows($query, $arrays = null)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($arrays);
        
        return $stmt->rowCount();  
    }
}

