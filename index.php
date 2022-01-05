<?php

//C'est le fichier d'entrée de mon application. Il appelle Main, qui est mon routeur.
use App\Autoload;
use App\Main\Main;


//Je définis une constante, ROOT, qui désigne le dossier racine du projet, qui est le dossier parent de public, d'om l'utilisation de dirname pour définir root

define('ROOT', dirname(__FILE__)); //définit le root là où est index.php

/****Autoloader*****/

// On charge le fichier Autoload
require_once ROOT . '\Autoload.php';
//on a fait une fonction static, c'est pour ça que l'on n'a pas besoin d'instancier la classe autoload pour utiliser register
Autoload::register();

/*****Main******/
//On instancie Main qui va être chargé du lancement de l'application (router)
$app = new Main();
//On démarre l'application

$app->start();

/*****MODAL****/ ?>
<?php include($_SERVER['DOCUMENT_ROOT'] . '/views/includes/js.php') ?>
</body>
</html>