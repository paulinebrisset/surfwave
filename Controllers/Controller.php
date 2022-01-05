<?php
namespace App\Controllers;

abstract class Controller {

    /*
        M : Afficher une vue
        O: rien 
        I : string $fichier : chemin vers le fichier qui contiendra la vue que l'on va obtenir
        I :array $data : contient une requête et le nom de la variable qui va récupérer la requête
        tableau vide par défaut, on pourra ne pas avoir de données.
    */

    public function render(string $fichier, array $donnees = [], string $template='default'){
        
        /*
            prend mon tableau et crée une variable pour chacune des clés renseignées
            + récupère les données et les extrait sous forme de variable
        */

         extract($donnees);
        // Crée le chemin et inclut le fichier de vue
        
    /*
        On démarre le buffer de sortie a partir de maintenant, 
        chaque echo sera mis en mémoire, puis tout ce qui est en mémoire 
        doit être mis dans une varible
    */

        ob_start();
    
    /* 
        A partir de maintenant, toute sortie est conservée en mémoire
        cad que les echo
    */

    // Crée le chemin et inclut le fichier de vue

        require_once($_SERVER['DOCUMENT_ROOT'].'/Views/'.$fichier.'.php');
        

    /* 
        On stocke le contenu dans $content
        ob get clean sert à prendre le buffer, et à le stocker dans la variable. Pour qu'il s'imprime, il va falloir faire un echo de $contenu
        tout ce qui est entre ob star et ob get clean, il le stocke à l'intérieur de $contenu
        tout le code html du require va donc être stocké dans $contenu
    */

        $content = ob_get_clean();

            // On fabrique le "template" avec default.php qui a un espace prévu pour la variable $contenu
            require_once($_SERVER['DOCUMENT_ROOT'].'/Views/'.$template.'.php');

            //celui-là ne s'exécute pas si le premier (l39) s'est exécuté
            require_once($_SERVER['DOCUMENT_ROOT'].'/Views/'.$fichier.'.php');
    }
}