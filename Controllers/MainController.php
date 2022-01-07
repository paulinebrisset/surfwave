<?php

namespace App\Controllers;

use App\Models\ModelCatprod;
use App\Models\ModelTarifs;
use App\Models\ModelDuree;

class MainController extends Controller
{

    private $tableau_vues_donnees = array(
        0 => ['main/statique', []],
        2 => ['main/suitestatique', []]
    );


    public function get_tableau_vues_donnees()
    {
        return $this->tableau_vues_donnees;
    }

    public function index()
    {
        $instanceTarifs = new ModelTarifs;
              
        //J'utilise une méthode de ModelTarifs pour aller récupérer tous les tarifs
        //Cette méthode préparera la requête et la fera excécuter via des méthode de Model et de Database

        $tarifs = $instanceTarifs->getTarificationData(false);
                /*Je vais chercher séparérement le libellés des catégories de produits, sinon l'affichage plante 
        dans le cas où l'un des tarifs à afficher sur la première ligne est delete
        */
        $instanceModelCatProd= new ModelCatprod;
        $option =$instanceModelCatProd->get_lib_values();
        /* ensuite je prépare un tableau à envoyer à Controller, il contient toutes les
        vues à afficher sur la page d'accueil*/

        $tableau_vues_donnees = $this->get_tableau_vues_donnees();
        $tableau_vues_donnees[1] = ['tarifs/index', ['tarifs' => $tarifs]];
        $this->render($tableau_vues_donnees, 'default', $option);
    }
}
