<?php

namespace App\Controllers;

use App\Models\ModelCatprod;
use App\Models\ModelTarifs;
use App\Models\ModelEquipe;

class MainController extends Controller
{

    /***
     * Contient le tableau des sections "statiques" à afficher, dans l'ordre dans lequel elles doivent être affichées
     * Ce tableau est une initialistion, il va être incrémenter au cours de la fonction index
     */
    private $tableau_vues_donnees = array(
        0 => ['main/statique', []],
        3 => ['main/suitestatique', []],
        5 => ['main/statiquefin', []]
    );

/***
 * Getter pour accéder au 
 */
    public function get_tableau_vues_donnees()
    {
        return $this->tableau_vues_donnees;
    }

    public function index()
    {
        /********premiers parametrages **** */
        $tableau_vues_donnees = $this->get_tableau_vues_donnees();

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
        $libTarifs= $instanceModelCatProd->get_lib_values();
        $tableau_vues_donnees[2] = (['tarifs/index', ['libTarifs' => $libTarifs]]);

        /*****PARTIE DYNAMIQUE 2 : EQUIPE */
        $instanceModelEquipe = new ModelEquipe;

        $equipier = $instanceModelEquipe->get_EquipeData();
        $tableau_vues_donnees[4] = ['equipe/index', ['equipier' => $equipier]];

        $this->render($tableau_vues_donnees, 'default');
    }
}
