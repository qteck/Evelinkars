<?php

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class FacebookLogIn
{
    public $db;
    
    private $id = '293012790816861';
    private $secret = '4ebf273b5eb77e5d7ca7f1e14f0bec67';
    
    protected $permissions = array();
    protected $helper;
    protected $session;
    
    
    function __construct($db)
    {
        $this->db = $db;
        
        $server_filter = filter_input(INPUT_SERVER, 'SERVER_NAME');
        
        FacebookSession::setDefaultApplication($this->id, 
                                               $this->secret);
        
        $this->helper = new Facebook\FacebookRedirectLoginHelper('http://' . $server_filter . '/index.php?page=login.php');
        
        $get = (isset($_GET['logoff'])?1:'');
        
        if($get == '1')
        {           
            $this->logOff();
            header( "refresh:5;url=/index.php" ); 
        }
        
        $this->getSessionAndKeepItAlive();
        
    }
    
    function getSessionAndKeepItAlive()
    {
        try {
            $this->session = $this->helper->getSessionFromRedirect();
        } catch(Exception $e) {
	
        }

        if(isset($_SESSION['fb']['token']))
        {
            $this->session = new FacebookSession($_SESSION['fb']['token']);
	
            try {
               $this->session->Validate($this->id, $this->secret);
            } catch (FacebookAuthorizationException $e) {
                $this->session = '';
            }
        }

        if (isset($this->session)) 
        {
            if(!$_SESSION['fb']['token'])
            {
                $_SESSION['fb']['token'] = $this->session->getToken();
        
                $this->getFacebookExecution(array('url'), 'GET', '/me/picture', array ('redirect' => false,
                                                                                       'height' => '200',
                                                                                       'type' => 'normal',
                                                                                       'width' => '200'));
        
                $this->getFacebookExecution(array('id',
                                                  'first_name',
                                                  'last_name',
                                                  'name',
                                                  'gender',
                                                  'link'), 'GET', '/me');
            
                $this->insertTheUser(array(':fb_id' => $_SESSION['fb']['id'],
                                           ':fb_name' => $_SESSION['fb']['name'],
                                           ':fb_first_name' => $_SESSION['fb']['first_name'],
                                           ':fb_last_name' => $_SESSION['fb']['last_name'],
                                           ':fb_gender' => $_SESSION['fb']['gender'],
                                           ':fb_profile_link' => $_SESSION['fb']['link'],
                                           ':fb_url_photo' => $_SESSION['fb']['url']));
            }
        
        } 
    }
    
    function getFacebookExecution($selectedFbArrays, $method, $request1, $arrayParam = '')
    {
        $request = new FacebookRequest($this->session, $method, $request1, $arrayParam); 
        
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        
        foreach($selectedFbArrays as $val)
        {
            $_SESSION['fb'][$val] = $graphObject->getProperty($val);
        }
        
    }
    
    function insertTheUser($arrays)
    {
        $sql = 'INSERT INTO users (fb_id, fb_name, fb_first_name, fb_last_name, fb_gender, fb_profile_link, fb_url_photo, added) VALUES '
                               . '(:fb_id, :fb_name, :fb_first_name, :fb_last_name, :fb_gender, :fb_profile_link, :fb_url_photo, NOW()) '
                . 'ON DUPLICATE KEY UPDATE '
                . 'fb_name = :fb_name, fb_first_name = :fb_first_name, fb_last_name = :fb_last_name, fb_gender = :fb_gender, fb_profile_link = :fb_profile_link, fb_url_photo = :fb_url_photo';
        
        $stmt = $this->db->boolQuery($sql, $arrays);
        
        return $stmt;
    }
    
    function logOff() 
    {
        $_SESSION['fb'] = '';
    }
        
    function provideLogInLink()
    {      
        if(!isset($this->session))
        {            
            $link = $this->helper->getLoginUrl();
        } else { 
            $link = '';
        }
             
        return $link;          
    }
}


$facebookLogIn = new FacebookLogIn($db);


if(isset($_SESSION['fb']['token']))
{  
    header('Location: /index.php');
    exit;
}
