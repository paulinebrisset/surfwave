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
        /****
        * M : affiche une page listant toutes les annonces de la base de données (version tableau)
        * I : rien
    */
        $instanceTarifs = new ModelTarifs;

        //J'utilise une méthode de ModelTarifs pour aller récupérer tous les tarifs
        //Cette méthode préparera la requête et la fera excécuter via des méthode de Model et de Database
        $prix = $instanceTarifs->getTarificationData(true);
        /**** TEST DU UPDATE
         * On si des tarifs ont été changés avec une autre méthode de cette classe****/
        $donneeModifiee = $this->testerUpdate($prix); //$this = objet gestion controller
        if ($donneeModifiee == true) { 
            header('Location: /gestion');
        } else {
            /*******FIN DU TEST */
            /*
        Là c'est une méthode de Controller, on lui file dans un tableau
        1 - le nom du fichier qui va ouvrir les résultats
        et 2- la varibale qui contient la requête qui contient les données que l'on veut afficher
        render se chargera de générer la vue
        */

        /*Je vais chercher séparérement le libellés des catégories de produits, sinon l'affichage plante 
        dans le cas où l'un des tarifs à afficher sur la première ligne est delete
        */
            $instanceModelCatProd = new ModelCatprod;
            $libTarifs = $instanceModelCatProd->get_lib_values();

            $tableau_vues_donnees[] = ['gestion/modifier', ['libTarifs' => $libTarifs]];
            $tableau_vues_donnees[] = ['gestion/modifier', ['prix' => $prix]];
            $this->render($tableau_vues_donnees, 'default');
        }
    }
    /***
    regarder si un tarif a été modifié
    Je lui envoie tous les prix de la database, il regarde si il y a un $_post correspondant
    Si au moins un tarif est modifié : on enregistre son $post dans un tableau clé=>valeur
    et à la fin, on envoie le tableau au Model Tarif pour qu'il transmette
    */
    private function testerUpdate($prix)
    {
        $prixAChanger = [];
        $controle = false;
        //Il ne passe pas dans le foreach si $prix est vide
        foreach ($prix as $tarif) {
            $cle = ($tarif['codeDuree'] . $tarif['categoProd']);
            if (isset($_POST[$cle]) && ($_POST[$cle] != '')) {
                $prixAChanger[$cle] = $_POST[$cle];
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
        //Lancement de la page si il n'y a pas eu de suppression 
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

        $instanceModelTarif = new ModelTarifs;
        $tarifsManquants = $instanceModelTarif->trouverLesTarifsManquants();
        $creation = false;
        //Je vérifie, pour chaque tarif manquant, si un $_POST correspondant a été reçu
        foreach ($tarifsManquants as $tarifManquant) {
            $concat = $tarifManquant['codeDuree'] . $tarifManquant['categoProd'];
            if (isset($_POST[$concat]) && $_POST[$concat] != '') {
                $instanceModelTarif = new ModelTarifs;
                $nouveauxTarifs[$concat] = $_POST[$concat];
                $creation = true;
            }
        }
        //renvoi vers l'interface principale de gestion si au moins une donnée à insérer a été trouvée
        if ($creation == true) {
            $instanceModelTarif->creerTarif($nouveauxTarifs);
            header('Location: /gestion');
            exit;
        }
        //Cas où aucun tarif n'a été créé
        $tableau_vues_donnees[] = ['gestion/nouveau', ['tarifsManquants' => $tarifsManquants]];
        $this->render($tableau_vues_donnees);
    }
}
