<?php 

use App\Auth;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

<?php if (null !== ($user = Auth::getUser())): ?>
    <div>Hello <?php echo $user->name; ?></div>
    <hr>
    <div><a href="/login/logout">Logout</a></div>
<?php else: ?>
    <div><a href="/signup/index">Sign Up</a> or <a href="/login/index">Log In</a></div>
<?php endif; ?>

<hr>

<h1>Welcome</h1>

</body>
</html>
