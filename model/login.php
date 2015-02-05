<?php

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class FacebookLogIn
{

    protected $id = '293012790816861';
    protected $secret = '4ebf273b5eb77e5d7ca7f1e14f0bec67';
    protected $permissions = array();
  
    public $helper;
    
    function __construct()
    {
        $server_filter = filter_input(INPUT_SERVER, 'SERVER_NAME');
        
        FacebookSession::setDefaultApplication($this->id, 
                                               $this->secret);
        
        $this->helper = new Facebook\FacebookRedirectLoginHelper('http://' . $server_filter . '/index.php?page=login.php');

        $this->getSessionAndToken();
    }
    
    function getSessionAndToken()
    {
        try{
            $session = $this->helper->getSessionFromRedirect();
        }catch(Exception $e){
	
        }

        if(isset($_SESSION['token'])){
	$session = new FacebookSession($_SESSION['token']);
	
	try{
		$session->Validate($this->id, $this->secret);
	}catch(FacebookAuthorizationException $e){
		$session = '';
	}
}

        if (isset($session)) {
            
            \Tracy\Debugger::dump($session);
            $_SESSION['token'] = $session->getToken();
            echo ".................";
            \Tracy\Debugger::dump($_SESSION['token']);
            
        $request2 = new FacebookRequest($session, 'GET', '/me/picture', array (
            'redirect' => false,
            'height' => '200',
            'type' => 'normal',
            'width' => '200'
        ));
        
        $response2 = $request2->execute();
        $graphObject2 = $response2->getGraphObject();
    
        \Tracy\Debugger::dump($graphObject2);
    
        echo "<img src='". $graphObject2->getProperty('url') ."' alt='profile picture'>";
        
        } else {
            echo "<a href=". $this->helper->getLoginUrl(array('publish_actions')) .">log in with facebook</a>";
        }
    }

        
     function provideLogInLink()
     {      
         if(isset($_SESSION['token']))
             {
               $link = $this->helper->getLoginUrl($this->permissions);
             } else 
                 { 
                    $link = null; 
                 }
             
             return $link;          
     }
    }
       

    $fbLogin = new FacebookLogIn();
      

    
    


