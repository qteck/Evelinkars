<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/control/default.php';
require_once __DIR__ . '/model/generalClass.php';
require_once __DIR__ . '/model/pageManager.php';

use Tracy\Debugger;

session_start();

Debugger::enable(Debugger::DEVELOPMENT);

$db    = new DB;

$page = isset($_GET['page'])? (filter_input(INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS)):null;
$pages = new Model\PageManager($page);

//do create spl_autoload_register;
include $pages->checkDirectories('model/',1);


/*make up how to deal with the index dynamics and how to control the menu on left side*/

class RightMenu
{
    public $db;
    
    function __construct($db)
    {
        $this->db = $db;
    }
    
    function getTags()
    {
        $sql = 'SELECT * FROM tags ORDER BY id DESC';
        
        $stmt = $this->db->query($sql);
        
        return $stmt;
    }
}
$menu = new RightMenu($db);
$tags = $menu->getTags();

?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            <?php 
            if(isset($title)) 
            { 
                echo $title . ' - Wilde Evelinka';
            } 
              else 
            {
                echo 'Wild Evelinka and our love';
            } 
            ?>
                
            
        </title>
        <meta charset="UTF-8">
        <meta name="description" content="A description of the page">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
        <script src="vendor/components/jquery/jquery.js"></script>
        
        <!-- don't forget 
            <link href="print.css" rel="stylesheet" type="text/css" media="print"> 
        -->
    </head>
    <style>
        html body{margin: 0;padding: 0; background-color: #F9F9F9;font-family: "Merriweather Sans","HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;font-size: 1.125rem;color: #222;}
        #container{width: 90%;margin: 20px auto 40px auto;min-width: 320px;}
        #article {float:left;width: 70%;padding: 0 6.0% 20px 6.0%; background-color: white;border: 1px solid #cbccdd;border-radius: 12px}
        
        span{font-size: 0.8rem;}
        h1{font-size: 2.125rem;}
        
        a{text-decoration: none;color: #4992D3}
        
        a:hover{color: #7a99e6}
        h1,h2 a {text-decoration: none; color: #222;}
        
        #menu {float: left; width: 17.7%;}
        #menu ul{margin: 20px 0 0 0px;}
        #menu ul, #menu li {list-style-type: none; margin: 0; padding: 0}
        #menu li {padding: 10px 10.1%;border-bottom: 1px solid #cbccdd;font-size: 0.8rem;}
        
        #top-block{
        z-index: 1; margin: 0;padding:0;position: fixed;top:0;width: 100%; background-color: #222;font-size: 0.8rem;color: #e2e2e2; 
        }

        .comment-sisy {font-size: 0.8rem;}
        
        nav #status {text-align: right;}
        
        #header
        {
            width: 100%;padding-top: 40px;background: transparent url('images/5.jpg'); border-bottom: 1px solid #c1916c
        }
        #header #content-header
        {
            width: 72%;margin: 0 auto;text-align: center;padding: 40px 0;    
        }
        #header #content-header #evelinka 
        {
            float: left;width: 20%;
        }
        
        #header #content-header #evelinka img,#logged-user img 
        {
            width: 100px;height: 100px;
        }
        
        #header #content-header #what-happened 
        {
            width: 60%;float: left;font-weight: bold;margin-top: 12px;
        }
        #header #content-header #what-happened span 
        {
            zoom: 1;
            filter: alpha(opacity=80);
            opacity: 0.8;
            background-color: white;
            padding: 6px 12px;
            font-size: 1.125rem;
        }
        
            #top-block-content {width: 72%;margin: auto;padding: 12px 0;}
            #top-block-content #floated-links{float: left}
            #top-block-content #logoLink {color: white;font-weight: bold}

          footer{clear:both;width: 89.4%;padding: 12px 0 0 0; margin: auto;}
          footer #footer-half{width: 69.5%; text-align:center;padding: 12px 6.2% 0 6.2%;}
          
          
          #comment_form1 {padding: 20px;}
            #comment_form1 img {float: right;width: 100px;height: 100px;}
        #comment_form1 textarea {width: 70%;height: 200px;}
        
        @media only screen and (max-width: 768px) {
            #container {
                width:100%;
            }
            #article {
                width: 88%;
                float: none;
                border-radius: initial;
                border: 0;
                border-top: 1px solid #cbccdd;
                border-bottom: 1px solid #cbccdd;
            }
            #menu {float: none;}
            
            #header #content-header #evelinka,#logged-user
            {
                display: none;
            }
            #header #content-header #what-happened {
                float: none;
                width: 100%;
                padding-top: 20px;
   
            }
            #top-block-content #floated-links
            {
                float: none;
            }
            #top-block-content #status
            {
                text-align: left;
                padding-top: 10px;
            }
            #menu {float: none; width: 100%;}

            footer{width: 100%;padding: 12px 0 0 0; margin: 0;}
            footer #footer-half{margin:auto;text-align:center;}
            
            #comment_form1 img {display: none;}
            #comment_form1 textarea {width: 100%;}
        }
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
        
        <nav id='top-block'>
            <div id="top-block-content">
            <div id="floated-links">
                            
            <a href="/index.php" id="logoLink">
              WILD EVELINKA 
            </a> ~
                    <?php if (!isset($_SESSION['fb']['token'])) { ?>
                        <a href="index.php?page=login">
                            Facebook login
                        </a>
                    <?php } else { ?>
                        You're logged in as 
                        <a href="index.php?page=userProfil"><?php echo $_SESSION['fb']['name']; ?></a> * 
                        <a href="index.php?page=userAddArticle">Add article</a> *
                        <a href="index.php?page=login&logoff=1">Log off</a>
                    <?php }?>
            </div>
            
            <div id="status">
                <span style="">~ IN LOVE ~</span>
            </div>
            </div>
        </nav>
        
        <div id="header"> 
        <div id="content-header">
            <div id="evelinka">
                <a href="index.php"><img src="images/evelinka.jpg" alt="evelinka"></a>
            </div>
            
            <div id="what-happened">
                <span>
                    How I met the most beautiful girl in the world
                </span><br>
                
                <span>
                    and 
                </span><br>
                
                <span>
                    she got me!
                </span>
            </div>
            
            <div id="logged-user">
                <a href="index.php"><img src="<?php echo empty($_SESSION['fb']['url'])? 'images/evelinka.jpg':$_SESSION['fb']['url']; ?>" alt="logo"></a>
            </div>
        </div>
      </div>
        
        
      <div id="container">              
        <article id="article" style="">
            <?php
                include $pages->checkDirectories('templates/');
            ?>
        </article>
          
          <aside id="menu">
              <ul>
                  <ul>
                      <li style="font-weight:bold; text-align: right;">Tags</li>
                  </ul>
                  <?php foreach($tags as $tag) { ?>
                  <li><a href="index.php?page=hashtag&tag=<?php echo $tag['tag']; ?>">#<?php echo $tag['tag']; ?></a></li>
                  <?php } ?>
              </ul>
              
        </aside>
          
            
          
<footer id="footer">
            
        <div id="footer-half"><span>Looking at each others eyes and think about the same thing, food.</span></div>
 
</footer>
        

    </body>
</html>
