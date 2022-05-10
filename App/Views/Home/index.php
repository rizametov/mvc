<?php require dirname(__DIR__) . '/templates/header.php'; ?>

    <?php echo htmlentities($name) ?>
    <hr>

    <?php foreach ($colors as $color): ?>
        <li><?php echo htmlentities($color); ?></li>
    <?php endforeach; ?>

<?php require dirname(__DIR__) . '/templates/footer.php'; ?>
