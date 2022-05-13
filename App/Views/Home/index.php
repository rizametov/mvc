<?php 

use App\Auth;

require dirname(__DIR__) . '/header.php';

?>

<h1>Welcome</h1>

<?php if (null !== ($user = Auth::getUser())): ?>
    <div>Hello <?php echo $user->name; ?></div>
    <hr>
    <div><a href="/login/logout">Logout</a></div>
<?php else: ?>
    <div><a href="/signup/index">Sign Up</a> or <a href="/login/index">Log In</a></div>
<?php endif; ?>

<?php require dirname(__DIR__) . '/footer.php'; ?>
