<?php require dirname(__DIR__) . '/header.php'; ?>

    <a href="/login/index">Login</a>
    <hr>
    
    <?php if (isset($newUser)): ?>
        <p>Errors:</p>
        <ul>
            <?php foreach ($newUser->getErrors() as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h1>Sing up</h1>

    <form method="post" action="/signup/validate">

        <label for="inputName">Name</label>
        <input id="inputName" name="name" placeholder="Name" type="text" autofocus 
            value="<?= isset($newUser) ? $newUser->name : '' ?>"  required />
        <hr>

        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email" type="email" autofocus 
            value="<?= isset($newUser) ? $newUser->email : '' ?>" required />
        <hr>

        <label for="inputPassword">Password</label>
        <input id="inputPassword" name="password" placeholder="Password" type="password" autofocus required />
        <hr>

        <label for="inputPasswordConfirmation">Repeat password</label>
        <input id="inputPasswordConfirmation" name="passwordConfirmation" 
            placeholder="Repeat Password" type="password" autofocus required />
        <hr>
        
        <button type="submit">Sign Up</button>

    </form>

<?php require dirname(__DIR__) . '/footer.php'; ?>