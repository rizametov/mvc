<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<body>
    <a href="/">Home</a>

    <?php if (isset($user)): ?>
        <p>Errors:</p>
        <ul>
            <?php foreach ($user->getErrors() as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <h1>Sing up</h1>

    <form action="/signup/create" method="post">

        <label for="inputName">Name</label>
        <input id="inputName" name="name" placeholder="Name" type="text" autofocus 
            value="<?php echo isset($user) ? $user->name : ''; ?>"  required />
        <hr>

        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email" type="email" autofocus 
            value="<?php echo isset($user) ? $user->email : ''; ?>" required />
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
</body>
</html>