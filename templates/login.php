<?php
    $fbLoglink = $facebookLogIn->provideLogInLink();

    $get = (isset($_GET['logoff'])?1:'');
?>

<h1>User's autorization</h1>

<?php if($get == 1) { ?>
    <p>
        You'll be redirected about 5 secs.
    </p>
<?php } ?>

<?php if(!empty($fbLoglink)) { ?>

<div style="text-align: center;">
    <a href="<?php echo $fbLoglink?>">
        <img src="images/fb_button_login.png" style="width: 100%;max-width: 340px;height: auto;" alt="log in with facebook">
    </a>
</div>
<?php } ?>
