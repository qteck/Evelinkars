<?php
//namespace Control;

class DB
{
    protected $username = 'evelinkars';
    protected $passwd   = 'B0rececek';
    
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
    }
    
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
    
    public function insert($query, $arrays = null)
    {
        $stmt = $this->pdo->prepare($query);
        $state = $stmt->execute($arrays);
        
        return $state;
    }
}

