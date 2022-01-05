<?php
namespace App\Controllers;
use App\Models\ModelTarifs;
use App\Models\ModelCatprod;
use App\Models\ModelDuree;

class GestionController extends Controller{

  
public function index(){
    /*
        M : affiche une page listant toutes les annonces de la base de données (version tableau)
        I : rien
        Bonus : toutes les variables que je voudrais créer ici seront accessibles depuis le include de juste en dessous
        include_once ROOT.'/views/items/index.php';
    */

        //instancier la classe ModelItems
        $articlesModel = new ModelTarifs;
        //On va chercher toutes les annonces publiées grâce à une méthode du Modèle
        $articles=$articlesModel->findAll();
        /*
        Là c'est une méthode de Controller. On lui file  
        1 - le nom du fichier qui va ouvrir les résultats
        et 2- la varibale qui contient la requête qui contient les données que l'on veut afficher
        render se chargera de générer la vue
        */

        $this->render('gestionArticles/index',['articles'=>$articles]);
    }

/****Affiche d'article à modifier */
    public function editer(int $id_item = 1){
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
    public function creer(){
        $this->render('gestionArticles/creer');
    }
    public function actualiserArticle(int $id, string $titre, string $description, $publie, $prix, int $categorie, $image='default.png'){
       
        // On instancie le modèle items
        $instanceItem = new ModelItems;

        $mesDonnees = [
            'titre'=> $titre,
            'description'=> $description,
            'prix'=> $prix,
            'publie'=> $publie,
            'id_categorie'=>$categorie,
            'image'=>$image
            ];

        $instanceItem->update($id,$mesDonnees);
    
        header('Location: /gestionArticles');
    }

    public function creerArticle(string $titre, string $description, $prix, $publie, $categorie, $image="default.png", $date=null){
        // On instancie le modèle items
        $instanceItem = new ModelItems;
        date_default_timezone_set('UTC');
        $date=date("Y-m-d");


        $mesDonnees = [
        'date'=>$date,
        'titre'=> $titre,
        'description'=> $description,
        'prix'=> $prix,
        'publie'=> $publie,
        'id_categorie'=>$categorie,
        'image'=>$image
        ];

        $instanceItem->creer($mesDonnees);
    }

    }
  ?>