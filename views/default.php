<!DOCTYPE html>
<html lang="fr">
<?php include ($_SERVER['DOCUMENT_ROOT'].'/views/includes/head.php') ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/views/includes/styles.php') ?>

<body>

   <!-- HEADER -->

   <header>

      <?php include $_SERVER['DOCUMENT_ROOT'] . '/views/includes/navbar.php' ?>

   </header>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/views/statique.html') ?>

<body>
    <div class="container-fluid">
        <?= $content ?>
    </div>
</body>

</html>