<?php

namespace App\Controllers;

use App\Models\ModelUtilisateurs;

class LoginController extends Controller
{


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
        //le mail ou le mdp ne correspond pas
        $_SESSION['erreurMdp'] = true;
        header('Location: /');
        exit;
    }

    public function isTheUserAnAdmin()
    {
        if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['droit'] == true) {
            return true;
        } else {
            return false;
        }
    }
    public function deconnexion()
    {
        // remove all session variables
        session_unset();

        // destroy the session
        session_destroy();
        header('Location: /');
    }
    /*********** GESTION DE LA NAVBAR *********/

    // public function verifierErreurMdp()
    // {
    //     if (isset($_SESSION['erreurMdp']) && $_SESSION['erreurMdp'] == true) {
    //         echo ("<script>$('#modalConnexion').modal()</script>");
    //     }
    // }
}
