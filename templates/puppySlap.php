<h1>Something's wrong</h1>

<p>
    <?php 
        foreach ($notices as $notice) {
            echo htmlspecialchars($notice);
        } 
    ?>
</p>

<p>
    <span>You're being automatically redirected on homepage in few seconds.</span>
</p>