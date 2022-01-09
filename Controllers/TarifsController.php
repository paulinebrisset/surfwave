<?php

namespace App\Controllers;
use App\Models\ModelCatprod;
use App\Models\ModelTarifs;

class TarifsController extends Controller
{
/* file tout ce dont il y a besoin pour afficher l'index de tarifs*/
    public function index()
    {
        $instanceTarifs = new ModelTarifs;
              
        //J'utilise une méthode de ModelTarifs pour aller récupérer tous les tarifs
        //Cette méthode préparera la requête et la fera excécuter via des méthode de Model et de Database

        $tarifs = $instanceTarifs->getTarificationData(false);
                /*Je vais chercher séparérement le libellés des catégories de produits, sinon l'affichage plante 
        dans le cas où l'un des tarifs à afficher sur la première ligne est delete
        */

       $vueTarifs[]= (['tarifs/index', ['tarifs' => $tarifs]]);
       $this->render($vueTarifs);
    }
    /**
     * M Méthode permettant d'afficher un article à partir de son slug
     * I @param int $id
     * O @return void
     */


    public function lire(int $id = 1)
    {
        // On instancie le modèle
        $instanceModel = new ModelTarifs;

        // On récupère les données
        $item = $instanceModel->find($id);

        $this->render('items/lire', compact('item'));
        /* Dernière ligne qu'on aurait aussi bien pu écrire
            $this->render('items/index',['item'=>$item]);
        */
    }

    public function afficherLaCategorie($id)
    {
        $instanceMI = new ModelTarifs;
        $catArticle = $instanceMI->findColumn('categorie', $id);
        return $catArticle['nom_categorie'];
    }
}
