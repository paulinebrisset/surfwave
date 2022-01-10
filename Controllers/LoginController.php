<?php

namespace App\Controllers;

use App\Models\ModelUtilisateurs;

class LoginController extends Controller
{

    /***Vérifie si l'utilisateur qui veut se connecter est bien enregistré dans la bdd (table utilisateurs)
     * ne renvoie rien, utilise les deux $_POST du form de connexion
     */
    public function verifierUtilisateur(string $mail, string $mdp)
    {

        $utilisateur = new ModelUtilisateurs;
        $cetUtilisateur = $utilisateur->findBy(['mail' => $mail, 'mdp' => $mdp]);
        foreach ($cetUtilisateur as $utilisateurExiste) {

            if (($utilisateurExiste['mail'] == $mail) && ($utilisateurExiste['mdp'] == $mdp)) {
                $_SESSION['utilisateur'] = $utilisateurExiste;
                $_SESSION['erreurMdp'] = false;
                header('Location: /');
                exit;
            }
        }
        //cas où le mail ou le mdp ne correspond pas
        $_SESSION['erreurMdp'] = true;
        header('Location: /');
        exit;
    }
    /***
     * renvoyer "true" si l'utilisateur est administrateur
     */
    public function isTheUserAnAdmin()
    {
        if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['droit'] == true) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * détruit les variable de session en cas de déconnection de l'utilisateur
     */
    public function deconnexion()
    {
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();

        $instanceMainController = new MainController;
        $instanceMainController->index();
        //TODO probleme d'url qui reste sur /gestion après la relocalisation
        exit;
    }
}
