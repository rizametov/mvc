<?php 

require dirname(__DIR__) . '/header.php';

?>

<h1>Request password reset</h1>
<hr>

<form action="/password/request-reset" method="post">

    <div>
        <label for="inputEmail">Email</label>
        <input id="inputEmail" name="email" placeholder="Email" type="email" autofocus required />
        <hr>
        <button type="submit">Send</button>
    </div>

</form>

<?php require dirname(__DIR__) . '/footer.php'; ?>