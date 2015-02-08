<?php
    $fbLoglink = $facebookLogIn->provideLogInLink();
    
    
    
    Tracy\Debugger::dump($_SESSION['fb']);
    
    $get = (isset($_GET['logoff'])?1:'');
?>

<p>User's autorization</p>

<?php if($get == 1) { ?>
<p>You\'ll be redirected in about 5 secs.</p>
<?php } ?>

<?php if(!empty($fbLoglink)) { ?>
<a href="<?php echo $fbLoglink?>">
    <img src="images/fb_button_login.png" style="" alt="log in with facebook">
</a>

<?php } else { ?>
<a href="index.php?page=login.php&logoff=1">
    Log Out
</a>
<?php } ?>
