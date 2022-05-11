<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
</head>
<body>
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
    
</body>
</html>