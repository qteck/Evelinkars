<?php


require_once __DIR__ . "/vendor/facebook/php-sdk-v4/autoload.php";

require_once __DIR__ . '/vendor/tracy/tracy/src/tracy.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

use Tracy\Debugger;

session_start();

Debugger::enable(Debugger::DEVELOPMENT);


$id = '293012790816861';
$secret = '4ebf273b5eb77e5d7ca7f1e14f0bec67';

FacebookSession::setDefaultApplication($id, 
                                       $secret);

$server_filter = filter_input(INPUT_SERVER, 'SERVER_NAME');
 
Debugger::dump($server_filter);


$helper = new Facebook\FacebookRedirectLoginHelper('http://'.$server_filter.'/fb_login.php');

try {
    $session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
    echo "some facebook issues";
} catch(\Exception $ex) {
    echo "problem s validací";
}


if (isset($session)) {
    $_SESSION['token'] = $session->getToken();
    
    $request = new FacebookRequest($session, 'GET','/me');
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
    /*
    $request4 = new FacebookRequest($session, 'POST', '/me/feed', array('link' => 'http://www.kerouac.cz/','message' => 'Kvalitní čtení!'));
    $response4 = $request4->execute();
    $graphObject4 = $response4->getGraphObject();
    
    Debugger::dump($graphObject4);
*/
} else {
    
    echo "<a href=". $helper->getLoginUrl(array('publish_actions')) .">log in with facebook</a>";
}
