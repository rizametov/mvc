<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<body>
    <h1>Sing up</h1>
    <form action="" method="POST">

        <label for="inputName">Name</label>
        <input id="inputName" name="name" placeholder="Name" type="text" autofocus />
        <hr>

        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email" type="email" autofocus />
        <hr>

        <label for="inputPassword">Password</label>
        <input id="inputPassword" name="password" placeholder="Password" type="password" autofocus />
        <hr>

        <label for="inputPasswordConfirmation">Repeat password</label>
        <input id="inputPasswordConfirmation" name="passwordConfirmation" 
            placeholder="Repeat Password" type="password" autofocus />
        <hr>
        
        <button type="submit">Sign Up</button>

    </form>
</body>
</html>