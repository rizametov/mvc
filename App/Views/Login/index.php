<?php require dirname(__DIR__) . '/header.php'; ?>

    <div><a href="/">Home</a></div>
    <hr>
    <h1>Log in</h1>

    <form method="post" action="/login/validate">

        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email" type="email" autofocus 
            value="<?php echo $email ?? ''; ?>" required />
        <hr>

        <label for="inputPassword">Password</label>
        <input id="inputPassword" name="password" placeholder="Password" 
            type="password" autofocus required />
        <hr>
        
        <button type="submit">Log in</button>

    </form>
    
<?php require dirname(__DIR__) . '/footer.php'; ?>