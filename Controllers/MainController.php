<?php

namespace App\Controllers;

use App\Models\ModelCatprod;
use App\Models\ModelTarifs;
use App\Models\ModelEquipe;

class MainController extends Controller
{

    private $tableau_vues_donnees = array(
        0 => ['main/statique', []],
        2 => ['main/suitestatique', []],
        4 => ['main/statiquefin', []]
    );


    public function get_tableau_vues_donnees()
    {
        return $this->tableau_vues_donnees;
    }

    public function index()
    {
        $tableau_vues_donnees = $this->get_tableau_vues_donnees();
        //on va pécho les tarifs
        /*****PARTIE DYNAMIQUE 1 : LES TARIFS */
        $instanceTarifs = new ModelTarifs;

        //J'utilise une méthode de ModelTarifs pour aller récupérer tous les tarifs
        //Cette méthode préparera la requête et la fera excécuter via des méthode de Model et de Database

        $tarifs = $instanceTarifs->getTarificationData(false);
        /*Je vais chercher séparérement le libellés des catégories de produits, sinon l'affichage plante 
dans le cas où l'un des tarifs à afficher sur la première ligne est delete
*/

        $tableau_vues_donnees[1] = (['tarifs/index', ['tarifs' => $tarifs]]);

        $instanceModelCatProd = new ModelCatprod;
        $option['libTarifs'] = $instanceModelCatProd->get_lib_values();
        /* ensuite je prépare un tableau à envoyer à Controller, il contient toutes les
vues à afficher sur la page d'accueil*/

        /*****PARTIE DYNAMIQUE 2 : EQUIPE */
        $instanceModelEquipe = new ModelEquipe;

        $equipier = $instanceModelEquipe->get_EquipeData();
        $tableau_vues_donnees[3] = ['equipe/index', ['equipier' => $equipier]];


        $this->render($tableau_vues_donnees, 'default', $option);
    }
}
