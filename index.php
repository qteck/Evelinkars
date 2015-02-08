<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/model/pageManager.php';

use Tracy\Debugger;

session_start();

Debugger::enable(Debugger::DEVELOPMENT);


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

        body{width: 720px;margin: auto;font-family: "Times New Roman", Times, serif;font-size: 16px;}
        #article{}
        span{font-size: 12px;}
    </style>    
    <body>
        <script type="text/javascript">
        // Get rid of the Facebook residue hash in the URI
        // Must be done in JS cuz hash only exists client-side
        // IE and Chrome version of the hack
        if (String(window.location.hash).substring(0,1) == "#") {
                window.location.hash = "";
                window.location.href=window.location.href.slice(0, -1);
                }
        // Firefox version of the hack
        if (String(location.hash).substring(0,1) == "#") {
                location.hash = "";
                location.href=location.href.substring(0,location.href.length-3);
                }
        </script>
        
        <div style="text-align: center;margin: 40px 0;height: 100px;">
            <div style="float: left;width: 20%;">
                <a href="index.php"><img src="images/evelinka.jpg" style="width: 100px;height: 100px;" alt="logo"></a>
            </div>
            
            <div style="width: 60%;float: left;">
                <p>
                How I met the most beautiful girl in the world <br>
                and <br>
                she got me! <br>
                </p>
            
                <p style="">
                    <?php if (!$_SESSION['fb']['token']) { ?>
                        <a href="index.php?page=login.php">Facebook login</a>
                    <?php } else { ?>
                        You're logged in as <?php echo $_SESSION['fb']['name']; ?>,
                        <a href="index.php?page=login.php&logoff=1">log off</a>
                    <?php }?>
                    
                </p>
            </div>
            <div style="">
                <p>
                <?php if ($_SESSION['fb']['token']) { ?>
                <a href="index.php"><img src="<?php echo $_SESSION['fb']['url']?>" style="width: 100px;height: 100px;" alt="logo"></a>
                <?php } ?>
                </p>
            </div>
        </div>
        
        <div id="article">
            <?php
                include $pages->checkDirectories('templates/');
            ?>
        </div>
    </body>
</html>
