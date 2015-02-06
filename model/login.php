<?php
/*
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class FacebookLogIn
{

    private $id = '293012790816861';
    private $secret = '4ebf273b5eb77e5d7ca7f1e14f0bec67';
    
    protected $permissions = array();
    protected $helper;
    protected $session;
    
    
    function __construct()
    {
        $server_filter = filter_input(INPUT_SERVER, 'SERVER_NAME');
        
        FacebookSession::setDefaultApplication($this->id, 
                                               $this->secret);
        
        $this->helper = new Facebook\FacebookRedirectLoginHelper('http://' . $server_filter . '/index.php?page=login.php');

        $this->getSessionAndKeepItAlive();
    }
    
    function getSessionAndKeepItAlive()
    {
        try {
            $this->session = $this->helper->getSessionFromRedirect();
        } catch(Exception $e) {
	
        }
/*
        if(isset($_SESSION['token']))
        {
            $this->session = new FacebookSession($_SESSION['token']);
	
            try {
               $this->session->Validate($this->id, $this->secret);
            } catch (FacebookAuthorizationException $e) {
                $this->session = '';
            }
        }*/

      /*  if (isset($this->session)) {
            
            \Tracy\Debugger::dump($this->session);
            $_SESSION['token'] = $this->session->getToken();
            echo ".................";
            \Tracy\Debugger::dump($_SESSION['token']);
            $this->getProfilePicture();
            $this->getPersonalInfo();
        } 
    }
    
    function getProfilePicture()
    {
        $request = new FacebookRequest($this->session, 'GET', '/me/picture', array (
            'redirect' => false,
            'height' => '200',
            'type' => 'normal',
            'width' => '200'
        ));
        
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
    
        echo "<img src='". $graphObject->getProperty('url') ."' alt='profile picture'>";        
    }

    function getPersonalInfo() 
    {
        $request = new FacebookRequest($this->session, 'GET', '/me');
        
        $response = $request->execute();
        $graphObject = $response->getGraphObject();
        
        Tracy\Debugger::dump($graphObject);
    }
        
    function provideLogInLink()
    {      echo "brr";
        if(!isset($this->session))
        {
            echo 'huhlal';
            Tracy\Debugger::dump($this->session);
            
            $link = $this->helper->getLoginUrl();
        } else { 
            $link = ''; echo 'okay';
        }
             
        return $link;          
    }
}*/
       echo "model";
   $hovno = "ukaž mi to hovno v templates";/*
    $fbLogin = new FacebookLogIn();
    $hoho = $fbLogin->provideLogInLink();
      
      if(empty($hoho))
      {
    echo "<a href=\"".$hoho."\">log out</a>";
      }else{
        echo "<a href=\"".$hoho."\">log in</a>";  
      }
    
    */


