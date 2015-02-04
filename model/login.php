<?php

require_once __DIR__ . "/../vendor/facebook/php-sdk-v4/autoload.php";

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
        
 

    $this->helper = new Facebook\FacebookRedirectLoginHelper('http://'.$server_filter.'/index.php?page=login.php');

    $this->getSessionAndToken();
    
    }
    
    function getSessionAndToken()
    {
        try {
            $session = $this->helper->getSessionFromRedirect();
        } catch(FacebookRequestException $ex) {
            echo "some facebook issues";
        } catch(\Exception $ex) {
            echo "problem s validací";
        } 

        if (isset($session)) {
            $_SESSION['token'] = $session->getToken();
            
            
 $request2 = new FacebookRequest(
  $session,
  'GET',
  '/me/picture',
  array (
    'redirect' => false,
    'height' => '200',
    'type' => 'normal',
    'width' => '200',
  )
);
    $response2 = $request2->execute();
    $graphObject2 = $response2->getGraphObject();
    
    var_dump($graphObject2);
    
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
      

    
    


echo "dddd";


/*...
 *     $request = new FacebookRequest($session, 'GET','/me');
    $response = $request->execute();
    $graphObject = $response->getGraphObject();
    
    
    Debugger::dump($graphObject);
    echo "logged in as: ". $graphObject->getProperty('first_name') .
                        " ". $graphObject->getProperty('last_name').
                                ' ('. $graphObject->getProperty('id').')';
    
   
    
    $request2 = new FacebookRequest(
  $session,
  'GET',
  '/me/picture',
  array (
    'redirect' => false,
    'height' => '200',
    'type' => 'normal',
    'width' => '200',
  )
);
    $response2 = $request2->execute();
    $graphObject2 = $response2->getGraphObject();
    
    Debugger::dump($graphObject2);
    
    echo "<img src='". $graphObject2->getProperty('url') ."' alt='profile picture'>";
    
    
    $request3 = new FacebookRequest($session, 'GET','/me/permissions');
    $response3 = $request3->execute();
    $graphObject3 = $response3->getGraphObject();
    
    
    Debugger::dump($graphObject3);
 */