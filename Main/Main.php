<?php
/*
        Cette classe représente le routeur principal
        Elle va aller chercher et lire les URL et renvoyer vers le Controlleur concerné
        La fonction start() est appelée à chaque lancement de la page index.php
    */

namespace App\Main;

use App\Controllers;
use App\Controllers\Controller;
use App\Controllers\LoginController;
use App\Controllers\MainController;

class Main
{

    /*********************Router simple qui ne gère pas l'erreur*********************/
    /*
    Exemple du fonctionnement prévu pour les url
    Adresse réelle 
        http://mes-articles.test/index.php?p=articles/details/parametre
    Adresse perçue dans le navigateur grâce au htaccess
        http://mes-articles.test/articles/details/parametre 
        avec annonce : le controller
        avec detail : méthode dans le controller, 
        et parametre : paramètre éventuel passé à la méthode précédemment lue
*/
    private function gererLaConnexion()
    {
        /* par défaut, on considère que la personne n'a pas rentré de mdp incorrect*/
        if (!isset($_SESSION['erreurMdp'])) {
            $_SESSION['erreurMdp'] = false;
        }
        /***Est-ce que utilisateur logué et admin? */
        //TODO : controle de saisie

        if (isset($_POST['logemail']) &&(isset($_POST['logmdp']))) {
            $instanceLoginController = new LoginController;
            $instanceLoginController->verifierUtilisateur($_POST['logemail'], $_POST['logmdp']);
        }
        //on affiche déconnexion si la personne est loguée, connection si la personne ne l'est pas
        if (isset($_POST['deconnexion'])) {
            $instanceLoginController = new LoginController;
            $instanceLoginController->deconnexion();
            //TODO : redirection vers la page principale
        }
    }

    public function start()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->gererLaConnexion();

        /*******NETTOYAGE D'URL ET ON EVITE LE DUPLICATE CONTENT ***********/

        //On va retirer le "trailing slash" éventuel de l'Url
        // On récupère l'adresse url
        $uri = $_SERVER['REQUEST_URI'];
        /*
            On vérifie si elle n'est pas vide et si elle se termine par un slash (uri[-1]===/)
            -> Si c'est le cas, on enlève le / parce qu'il ne sert à rien :
            on aura la même page avec ou sans le slash, ça fait ce que l'on appelle du duplicate content
            et ensuite, je ne veux pas avoir une positition de $params qui stocke un slash 
        */

        if (!empty($uri) && $uri != '/' && $uri[-1] === '/') { //il y a quand même un slash systématique à la fin paraît-il, au moins sur la page d'accueil
            // Dans ce cas on enlève le /

            $uri = substr($uri, 0, -1);

            // On envoie un code de redirection permanente pour ne pas avoir la page en double
            http_response_code(301);

            // On redirige vers l'URL sans /
            header('Location: ' . $uri);
            exit;
        }

        /*******GESTION DES PARAMETRES**********/

        /* 
        On sépare les paramètres dans un tableau 
        (-> p=controller/methode/parametres) + on les met dans le tableau $params
        explode -> contraire de implode
        */
        $params = [];

        if (isset($_GET['p'])) {
            $params = explode('/', $_GET['p']);
        }

        // On vérifie si on a au moins un paramètre (donc si il y en a un dans $params[0])
        if ($params[0] != "") {

            /*
            PARAM 1    
                Le 1er param va correspondre au nom du controller, mais il va falloir refabriquer l'adresse du ficihier (avec le namespace)
                On sauvegarde le 1er paramètre dans $controller en mettant sa 1ère lettre en majuscule
                + ajout du namespace des controleurs, et "Controller" à la fin de "l'adresse"
                Ex : pour monsite/bidule en url ; on veut qu'il aille chercher App\Controller\BiduleController
            */
            /*******CONTROLE SECU *******/
            /*
            $instanceController = new Controller;
            $liste = $instanceController->get_liste_controllers();
            $comparaison = false;

            
            foreach ($liste as $nomController){
                 if (strcmp($nomController, ($params[0]))==0);
                 $comparaison=true;
                echo("Je passe dans le tableau");
             }

            // if ( $comparaison==true){
                */

            //Si le controller appelé doit être GestionController, je vérifie que l'utilisateur
            //est logué et admin avant de continuer

            if (strcasecmp($params[0], 'gestion') == 0) { //strcasecmp pour ignorer la casse
                $instanceLoginController = new LoginController;
                if ($instanceLoginController->isTheUserAnAdmin() == false) {
                    $this->renvoyerVers404();//methode de Main
                }
            }
            /******FIN DES CONTROLES PRINCIPAUX ******/

            $controller = '\\App\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller'; //array_shift enlève la première valeur d'un tableau
            // On instancie le contrôleur
            $controller = new $controller();

            /* 
                PARAM 2
                    On sauvegarde le 2ème paramètre dans $action 
                    si on a un param, c'est une méthode qu'on utilise -> soit elle existe, soit 404
                    si pas de param, on utilise la méthode index
                */
            $action = isset($params[0]) ? array_shift($params) : 'index';

            if (method_exists($controller, $action)) {
                /* 
                        Si il reste des paramètres : 
                        on appelle la méthode en envoyant les paramètres 
                        sinon on l'appelle "à vide"
                    */

                /*    
                        ancienne version :  (isset($params[0])) ? $controller->$action($params) : $controller->$action();
                        cela permettait de passer des paramètres complémentaires sous forme de un tableau
                        maintenant -> on veut un entier directement. call_user_func_array permet de faire la conversion
                    */
                (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
            } else {
                $this->renvoyerVers404();
            }
        } else {
            /*
                Si  pas de paramètre, afficher la page d'accueil
                On instancie le contrôleur par défaut (page d'accueil)
                */
            $controller = new Controllers\MainController();

            // On appelle la méthode index
            $controller->index();
        }
    }

    public function renvoyerVers404()
    {
        /*
        si la classe n'existe pas, ou 
        si il y a un param de méthode mais que cette méthode n'existe pas, 
        on envoie le code réponse 404
    */
        http_response_code(404);
        $instanceMainController = new MainController;
        $tableau_vues_donnees[] = ['includes/404', []];
        $instanceMainController->render($tableau_vues_donnees, 'default');
        exit;
    }
}
