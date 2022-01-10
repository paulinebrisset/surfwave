<?php

namespace App\Controllers;

use App\Models\ModelTarifs;
use App\Models\ModelCatprod;
use App\Models\ModelDuree;

class GestionController extends Controller
{
    public function index()
    {
        $tableau_vues_donnees[] = ['gestion/index', []];
        $this->render($tableau_vues_donnees, 'default');
    }

    public function modifier()
    {
        /*
        M : affiche une page listant toutes les annonces de la base de données (version tableau)
        I : rien
        Bonus : toutes les variables que je voudrais créer ici seront accessibles depuis le include de juste en dessous
        include_once ROOT.'/views/items/index.php';
    */
        $instanceTarifs = new ModelTarifs;

        //J'utilise une méthode de ModelTarifs pour aller récupérer tous les tarifs
        //Cette méthode préparera la requête et la fera excécuter via des méthode de Model et de Database
        $prix = $instanceTarifs->getTarificationData(true);

        /**** TEST DU UPDATE*/
        $donneeModifiee = $this->testerUpdate($prix); //$this = objet gestion controller
        if ($donneeModifiee == true) {
            header('Location: /gestion');
        } else {
            /*******FIN DU TEST */
            /*
        Là c'est une méthode de Controller. On lui file  
        1 - le nom du fichier qui va ouvrir les résultats
        et 2- la varibale qui contient la requête qui contient les données que l'on veut afficher
        render se chargera de générer la vue
        */

            /*Je vais chercher séparérement le libellés des catégories de produits, sinon l'affichage plante 
        dans le cas où l'un des tarifs à afficher sur la première ligne est delete
        */
            $instanceModelCatProd = new ModelCatprod;
            $option['libTarifs'] = $instanceModelCatProd->get_lib_values();

            $tableau_vues_donnees[] = ['gestion/modifier', ['prix' => $prix]];
            $this->render($tableau_vues_donnees, 'default', $option);
        }
    }
    /*
    regarder si un tarif a été modifié
    Je lui envoie tous les prix de la database, il regarde si il y a un $_post correspondant
    Si au moins un tarif est modifié : on enregistre son $post dans un tableau clé=>valeur
    et à la fin, on envoie le tableau au Model Tarif 
    */
    private function testerUpdate($prix)
    {
        $prixAChanger = [];
        $controle = false;
        //Il ne passe pas dans le foreach si $prix est vide
        //TODO a changer pour en faire plusueyrs d'un coup
        foreach ($prix as $tarif) {
            $cle = ($tarif['codeDuree'] . $tarif['categoProd']);
            if (isset($_POST[$cle]) && ($_POST[$cle] != '')) {
                $prixAChanger[$cle] = ($_POST[$cle]);
            }
        }
        $instanceModelTarif = new ModelTarifs;
        $controle = $instanceModelTarif->updateTarif($prixAChanger); //controle vaut null si le tableau est vide et true si il y a eu une requête
        return $controle; //false si aucune donnee n'a été changée, true si on a fait un update
    }

    public function supprimer()
    {
        //verifier si il y a déjà eu un essai de suppression de prix
        if (isset($_POST['duree']) && isset($_POST['categoprod'])) {
            $instanceModelTarif = new ModelTarifs;
            $instanceModelTarif->delete2FK([$_POST['categoprod'], $_POST['duree']]);
            header('Location: /gestion');
            exit;
        }
        //Lancement de la page 
        $instanceModelCatProd = new ModelCatprod;
        $categoprod = $instanceModelCatProd->findAll();
        $instanceDuree = new ModelDuree;
        $duree = $instanceDuree->findAll();

        $tableau_vues_donnees[] = ['gestion/supprimer', ['categoprod' => $categoprod]];
        $tableau_vues_donnees[] = ['gestion/supprimer', ['duree' => $duree]];

        $this->render($tableau_vues_donnees);
    }
    public function nouveau()
    {

        //Lancement de la page 
        $instanceModelTarif = new ModelTarifs;
        $tarifsManquants = $instanceModelTarif->trouverLesTarifsManquants();
        $creation = false;
        //Je vérifie si l'un des tarifs manquants a été mis à jour
        foreach ($tarifsManquants as $tarifManquant) {
            $concat = $tarifManquant['codeDuree'] . $tarifManquant['categoProd'];
            if (isset($_POST[$concat]) && $_POST[$concat] != '') {
                $instanceModelTarif = new ModelTarifs;
                /**Je crée un tableau id=>valeur */
                $nouveauxTarifs[$concat] = $_POST[$concat];
                $creation = true;
            }
        }
        if ($creation == true) {
            $instanceModelTarif->creerTarif($nouveauxTarifs);
            header('Location: /gestion');
            exit;
        }

        $tableau_vues_donnees[] = ['gestion/nouveau', ['tarifsManquants' => $tarifsManquants]];
        $this->render($tableau_vues_donnees);
    }
    /****Affiche d'article à modifier */
    public function editer(int $id_item = 1)
    {
        // On instancie le modèle
        $instanceModel = new ModelItems;

        // On récupère les données
        $item = $instanceModel->find($id_item);

        $this->render('gestionArticles/editer', compact('item'));
        /* Dernière ligne qu'on aurait aussi bien pu écrire
            $this->render('items/index',['item'=>$item]);
        */
    }
    /****Création d'un nouveal article */
    // public function creer()
    // {
    //     $this->render('gestionArticles/creer');
    // }
    public function actualiserArticle(int $id, string $titre, string $description, $publie, $prix, int $categorie, $image = 'default.png')
    {

        // On instancie le modèle items
        $instanceItem = new ModelItems;

        $mesDonnees = [
            'titre' => $titre,
            'description' => $description,
            'prix' => $prix,
            'publie' => $publie,
            'id_categorie' => $categorie,
            'image' => $image
        ];

        $instanceItem->update($id, $mesDonnees);

        header('Location: /gestionArticles');
    }

    public function creerArticle(string $titre, string $description, $prix, $publie, $categorie, $image = "default.png", $date = null)
    {
        // On instancie le modèle items
        $instanceItem = new ModelItems;
        date_default_timezone_set('UTC');
        $date = date("Y-m-d");


        $mesDonnees = [
            'date' => $date,
            'titre' => $titre,
            'description' => $description,
            'prix' => $prix,
            'publie' => $publie,
            'id_categorie' => $categorie,
            'image' => $image
        ];

        $instanceItem->creer($mesDonnees);
    }
}
