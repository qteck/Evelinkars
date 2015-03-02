<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/control/default.php';
require_once __DIR__ . '/model/pageManager.php';

use Tracy\Debugger;

session_start();

Debugger::enable(Debugger::DEVELOPMENT);

$db    = new DB;
$pages = new Model\PageManager();

include $pages->checkDirectories('model/');

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Wild Evelinka and our love :-*</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="vendor/components/jquery/jquery.js"></script>
    </head>
    <style>
        html body{margin: 0;padding: 0; background-color: #F9F9F9;font-family: "Merriweather Sans","HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;font-size: 1.125rem;color: #222;}
        #container{width: 720px;margin: 4px auto 40px auto;}
        #article{margin-top: 20px;padding: 0 40px; background-color: #f7f7f7;border: 1px solid #cbccdd;border-radius: 12px}
        span{font-size: 0.8rem;}
        h1{font-size: 2.125rem;}
        
        a{text-decoration: none;color: #4992D3}
        
        a:hover{color: #7a99e6}
        h1,h2 a {text-decoration: none; color: #222;}
        
        #top-block{
        z-index: 1; margin: 0;padding:0;position: fixed;top:0;width: 100%; background-color: #222;font-size: 0.8rem;color: #e2e2e2; 
        }

        .transparent {
	zoom: 1;
	filter: alpha(opacity=80);
	opacity: 0.8;
}
        .comment-sisy {font-size: 0.8rem;}
    </style>    
    <body>
           
        <script type="text/javascript">
        // Get rid of the Facebook residue hash in the URI
        // Must be done in JS cuz hash only exists client-side
        // IE and Chrome version of the hack
        if (String(window.location.hash).substring(0,4) == "#_=_") {
                window.location.hash = "";
                window.location.href=window.location.href.slice(0, -1);
                }
        // Firefox version of the hack
        if (String(location.hash).substring(0,4) == "#_=_") {
                location.hash = "";
                location.href=location.href.substring(0,location.href.length-3);
                }
        </script>
        
        <div id='top-block'>
            
            <div style="width: 720px;margin: auto;padding: 12px 0;">
            <div style="float: left">
            <a style="color: white;font-weight: bold" href="/index.php">
              WILD EVELINKA 
            </a> ~
                    <?php if (!isset($_SESSION['fb']['token'])) { ?>
                        <a href="index.php?page=login.php">
                            Facebook login
                        </a>
                    <?php } else { ?>
                        You're logged in as 
                        <a href="index.php?page=userProfil.php"><?php echo $_SESSION['fb']['name']; ?></a> * 
                        <a href="index.php?page=userAddArticle.php">Add article</a> *
                        <a href="index.php?page=login.php&logoff=1">Log off</a>
                    <?php }?>
            </div>
            
            <div style="text-align: right;">
                <span style="">~ IN LOVE ~</span>
            </div>
            </div>
        </div>
        
        <div style="width: 100%;padding-top: 40px;background: transparent url('images/5.jpg'); border-bottom: 1px solid #c1916c"> 
        <div style="width: 720px;margin: 0 auto;text-align: center;padding: 40px 0;height: 100px;">
            <div style="float: left;width: 20%;">
                <a href="index.php"><img src="images/evelinka.jpg" style="width: 100px;height: 100px;" alt="logo"></a>
            </div>
            
            <div class="transparent" style="width: 60%;float: left;font-weight: bold;margin-top: 12px;">
                <span style="background-color: white;padding: 6px 12px;font-size: 1.125rem;">
                    How I met the most beautiful girl in the world
                </span><br>
                <span style="background-color: white;padding: 6px 12px;font-size: 1.125rem;">
                    and 
                </span><br>
                <span style="background-color: white;padding: 6px 12px;font-size: 1.125rem;">
                    she got me!
                </span>
            </div>
            <div style="">
                <?php if (isset($_SESSION['fb']['token'])) { ?>
                    <a href="index.php"><img src="<?php echo $_SESSION['fb']['url']?>" style="width: 100px;height: 100px;" alt="logo"></a>
                <?php } ?>
            </div>
        </div>
      </div>
        
      <div id="container">              
        <div id="article">
            <?php
                include $pages->checkDirectories('templates/');
            ?>
        </div>
      </div>
    </body>
</html>
