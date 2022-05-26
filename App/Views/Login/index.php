    <a href="/signup/index">Signup</a>

    <hr>
    <h1>Log in</h1>

    <form method="post" action="/login/validate">

        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email" type="email" autofocus 
            value="<?= $email ?? ''; ?>" required />
        <hr>

        <label for="inputPassword">Password</label>
        <input id="inputPassword" name="password" placeholder="Password" 
            type="password" equired />
        <hr>

        <input type="checkbox" name="rememberMe" 
            <?= true === ($rememberMe ?? false) ? 'checked="checked"' : '' ?>
            /> Remember me
        <hr>
        <div><a href="/password/fogot">Fogot password?</a></div>
        <hr>
        
        <button type="submit">Log in</button>

    </form>