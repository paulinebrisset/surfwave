<!DOCTYPE html>
<html lang="fr">
<?php include($_SERVER['DOCUMENT_ROOT'] . '/views/includes/head.php') ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/views/includes/styles.php') ?>

<body>
    <!-- HEADER -->
    <header>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/includes/navbar.php' ?>
    </header>

    <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/statique.html') ?>
    <?= $content ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/statiquesuite.html') ?>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/views/includes/footer.php') ?>

</body>
</html>