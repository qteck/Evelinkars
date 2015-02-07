<?php
    $fbLogin = new FacebookLogIn();
    $fbLoglink = $fbLogin->provideLogInLink();
    
?>

<p>User's autorization</p>
<?php if(!empty($fbLoglink)) { ?>
<a href="<?php echo $fbLoglink?>">
    <img src="images/fb_button_login.png" style="" alt="log in with facebook">
</a>

<?php } else { ?>
<a href="index.php?page=login.php">
    Log Out
</a>
<?php } ?>
