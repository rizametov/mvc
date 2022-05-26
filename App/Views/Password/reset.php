    <?php if (isset($errors)): ?>
        <p>Errors:</p>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h1>Reset password</h1>

    <form method="post" action="/password/reset-password">

        <label for="inputPassword">New password</label>
        <input id="inputPassword" name="password" placeholder="Password" type="password" autofocus required />

        <hr>
        <label for="inputPasswordConfirmation">Repeat new password</label>
        <input id="inputPasswordConfirmation" name="passwordConfirmation" 
            placeholder="Repeat Password" type="password" required />
        <hr>

        <input type="hidden" name="token" value="<?= $token ?>">
        
        <button type="submit">Send</button>

    </form>