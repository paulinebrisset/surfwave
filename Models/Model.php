<?php

namespace App\Models;

use App\Main\Database;
use PDO;
use App\Models\ModelCatprod;


/*
    Ici je met tout ce qui va me servir à manipuler les données. C'est un modèle général, je vais créer un modèle pour chaque table de la bdd qui contiendra 
    les informations qui lui sont spécifiques.
*/

class Model extends Database
{
    // Table de la base de données. Va nous permettre d'avoir un propriété qu'on va pouvoir écrire depuis les classes qui vont hériter du modèle, pour cela que l'on met protected 
    protected $table;
    protected $first_id;
    protected $second_id;
    protected $columnToGetPrinted;
    // Instance de connexion
    private $db;


    public function get_tableName()
    {
        return $this->table;
    }
    public function get_first_id()
    {
        return $this->first_id;
    }
    public function get_columnToGetPrinted()
    {
        return $this->columnToGetPrinted;
    }

    /*
    M Méthode principale qui va préparer les requêtes dans tous les cas de figure, elle va aussi vérifier si elle doit préparer ou non la requête
    O: PDOStatement|false (ce retour va être récupéré pour faire un fetchAll dessus)
    I: string $sql Requête SQL à exécuter + array $attributes Attributs à ajouter à la requête 
*/
    public function executerRequete(string $sql, array $attributs = null)
    {
        // On récupère l'instance de Database, (instance d'instance de PDO, ça aurait pu être juste instance de PDO)
        $this->db = Database::getInstance();

        // On vérifie si on a des attributs
        if ($attributs !== null) {
            // Si il y a des attributs envoyés, ce qu'il nous faut c'est une requête préparée
            $query = $this->db->prepare($sql);
            //exécution de la requête avec mes paramètres
            $query->execute($attributs);
            //les résultats sont récupérés dans un tableau associatif puisque c'est comme ça que c'est paramétré dans Database
            return $query;
        } else {
            // Requête simple. renvoie un booléen. findAll() passera par là
            return $this->db->query($sql);
        }
    }
    /*****************ON FAIT LE CRUD *******************/
    /*********************PARTIE LECTURE DES DONNEES *********************/

    /* findAll
    M : Sélection de tous les enregistrements d'une table, retourne un tableau 
    O : Tableau des enregistrements trouvés
    I: rien
*/

    public function findAll(string $condition = null)
    {
        $query = $this->executerRequete('SELECT * FROM ' . $this->table . ' ' . $condition); //TODO : à vérifier 
        return $query->fetchAll();
    }
    /* find 
    M : Sélection d'un enregistrement directement avec son id
    O : Tableau contenant l'enregistrement trouvé
    I : $id id de l'enregistrement
*/

    public function find(int $id, string $condition = null)
    {
        // On exécute la requête
        $whereId = ('WHERE ' . $this->first_id . ' = ');
        // $whereId  = (substr($whereId, 0, -1)."="); //enlever le dernier caractère. Avoir id_item pour la table "items"

        $query = $this->executerRequete("SELECT * FROM " . $this->table . ' ' . $whereId . $id);
        return $query->fetch();
    }

    /* findBy
M : Sélection de plusieurs enregistrements suivant un tableau de critères
M: écrire des choses du style : $item = new ModelItem / $resultats = $item->findBy(['admin'=>'true'])
 va donner par ex SELECT * FROM utilisateurs WHERE admin =? AND id=2;
 & parametres (1, valeur)
O : return array Tableau des enregistrements trouvés
I: array $criteres Tableau de critères
*/

    public function findBy(array $criteres, string $condition = null)
    {
        $champs = [];
        $valeurs = [];

        // On boucle pour récupérer les paramètres de la requête et séparer les noms de champs des valeurs
        foreach ($criteres as $champ => $valeur) {

            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        /*implode : méthode php qui rassemble les éléments d'un tableau en une chaîne
            On transforme le tableau "champs" en chaîne de caractères séparée par des AND si il y a plusieurs champs à sélectionner
            (le premier argument de implode, ici 'AND', est un séparateur qui est utilisé que si il  y a plusieurs éléments dans le tableau)
       */
        $liste_champs = implode(' AND ', $champs);
        $liste_champs .= (' ' . $condition);

        // On exécute la requête
        $query = $this->executerRequete('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs . ' ' . $valeurs);
        return $query->fetchAll();
    }

    /*avoir toutes les valeurs des id de categoprod*/
    /*Non utilisé*/
    public function getIdValues()
    {
        $condition = ($this->first_id . 'asc');
        $table = $this->findAll($condition);
        foreach ($table as $id_value) {
            $values[] = $id_value['$this->first_id'];
        }
        var_dump($values);
        $this->id_values = $values;
    }

    //n'importe quelle requete envoyée par une instance

    public function planATrois(model $tableAnnexe1, model $tableAnnexe2, string $condition)
    {
        /*Gros assemblage
            Pour chaque model(=table), dont le model qui appelle la fonction, on va aller chercher
            le nom de la table
            le nom de l'id
            le nom de la "jolie colonne" (celle qui contient l'affichage)
            */


        $table1 = $tableAnnexe1->get_tableName();
        $cle1 = $tableAnnexe1->get_first_id();
        $colonneAPublier1 = $tableAnnexe1->get_columnToGetPrinted();

        $table2 = $tableAnnexe2->get_tableName();
        $cle2 = $tableAnnexe2->get_first_id();
        $colonneAPublier2 = $tableAnnexe2->get_columnToGetPrinted();

        //$this se réfère au model appelant 
        $tablePrincipale = $this->get_tableName();
        $colonnePrincipale = $this->get_columnToGetPrinted();

        //je sélectionne les "jolie colonnes" dans un select

        $listeSelect = ('select ' . $colonnePrincipale . ', ' . $colonneAPublier1 . ', ' . $colonneAPublier2 . ' ');

        $from = ('from ' . $tablePrincipale . ' ');
        //Je fais respecter l'intégrité référentielle
        $premiereJointure = ('inner join ' . $table1 . ' on ' . $tablePrincipale . '.' . $cle1 . ' = ' . $table1 . '.' . $cle1 . ' ');
        $secondeJointure = ('inner join ' . $table2 . ' on ' . $tablePrincipale . '.' . $cle2 . ' = ' . $table2 . '.' . $cle2 . ' ');

        //J'assemble le tout
        $requete = ($listeSelect . $from . $premiereJointure . $secondeJointure . $condition);
        //J'utilise executerRequete qui est une méthode de Model pour aller chercher les donnée
        $request = $this->executerRequete($requete);
        return $request->fetchAll();
    }


    //trouver le nom de la catégorie correspondant à un item
    /*INUTILE : NE MARCHAIT QUE DANS LES CAS OU POUR TABLE LA PK EST ID_TABLE ET ID EST INT*/
    public function findColumn(string $column, string $secondeTable, $id, $condition = null)
    {
        $integriteReferentielle = ('on ' . $id . '.' . $this->table . ' = ' . $id . '.' . $secondeTable);
        $request = $this->executerRequete('select nom_' . $column . ' from ' . $nom_table . ' inner join ' . $this->table . ' on ' . $nom_table . '.id_' . $column . ' = ' . $this->table . '.id_' . $column . ' where id_' . $first_id . ' = ' . $id);
        return $request->fetch();
    }
    /*INUTILE : NE MARCHAIT QUE DANS LES CAS OU POUR TABLE LA PK EST ID_TABLE ET ID EST INT*/
    //trouver les items correspondant à une catégorie.
    public function findChilds(string $childs, $id)
    {
        $nom_idChild = substr($childs, 0, -1);
        $nom_idParent = substr($this->table, 0, -1);
        $request = $this->executerRequete('select * from ' . $childs . ' inner join ' . $this->table . ' on ' . $childs . '.id_' . $nom_idParent . ' = ' . $this->table . '.id_' . $nom_idParent . ' where ' . $this->table . '.id_' . $nom_idParent . ' = ' . $id);
        return $request->fetchAll();
    }

    /*********************PARTIE UPDATE DES DONNEES *********************/

    public function creer(array $model)
    {
        $champs = [];
        $valeurs = [];
        $liste_valeurs = '\''; //pour mettre toutes les insertions entre quotes

        // On réorganise le tableau des paramètres pour l'exploiter
        foreach ($model as $champ => $valeur) {
            // UPDATEpro annonces SET titre = ?, description = ?, actif = ? WHERE id= ?
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ";
                $valeurs[] = "$valeur";
            }
        }

        // On transforme le tableau "champs" en une chaine de caractères
        $liste_champs = implode(', ', $champs);

        $liste_valeurs .= implode('\' , \'', $valeurs);
        $liste_valeurs .= '\'';
        // On exécute la requête (retour vrai ou faux)
        $preRequete = ('INSERT INTO ' . $this->table . ' (' . $liste_champs . ') VALUES (' . $liste_valeurs . ') ');
        return $this->executerRequete($preRequete);
    }
    /*
M : Mise à jour d'un enregistrement suivant un tableau de données
O : booléen (requête éxécutée ou non)
I : int $id id de l'enregistrement à modifier
I: Model $model Objet à modifier
Exemple d'utilisation
donneesDeMonItemModifie = [
    'titre'=>'Item modifié'
    'description'=>'description modifiée'
    'publie'=>true
    ] 
    $itemDejaInstancieDepuisModelItem->update(2,$memeItemDejaCree)

*/
    public function update(int $id, array $criteres)
    {
        $champs = [];
        $valeurs = [];

        // On boucle pour récupérer les paramètres de la requête et séparer les noms de champs des valeurs
        foreach ($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        /*implode : méthode php qui rassemble les éléments d'un tableau en une chaîne
        On transforme le tableau "champs" en chaîne de caractères séparée par des AND si il y a plusieurs champs à sélectionner
        (le premier argument de implode, ici 'AND', est un séparateur qui est utilisé que si il  y a plusieurs éléments dans le tableau)
   */
        $liste_champs = implode(',', $champs);

        $whereId = ('WHERE ' . $this->first_id . ' = ');
        $whereId .= $id;

        // On exécute la requête
        return $this->executerRequete('UPDATE ' . $this->table . ' SET ' . $liste_champs . ' ' . $whereId . ' ', $valeurs);
    }

    /*********************PARTIE SUPPRESSION DES DONNEES *********************/
    /*
M : Suppression d'un enregistrement
O : bool 
I : int $id id de l'enregistrement à supprimer
exemple d'utilisation $machin->delete(6);
*/
    public function delete(int $id)
    {
        return $this->executerRequete("DELETE FROM " . $this->table . " WHERE id = ?", [$id]);
    }
    /*********************PARTIE HYDRATATION = CREATE*********************/

    /* 
M: Hydrater les données. Hydrater le modèle c'est passer d'un tableau 
donneesDeMonNouvelItem = [
    'titre'='Item hydraté'
    'description'=>'très bel item'
    'publie'=>true
    ] 
    de là, il va voir si setTitre, setDescription existent, et les appliquer si oui en leur filant les valeurs renseignées
I: array $donnees Tableau associatif des données
O: self Retourne l'objet hydraté
 */

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            // On récupère le nom du setter correspondant à l'attribut.
            //par ex : titre donne setTitre, donc attention à l'écriture homogène des setters
            //cad retrouver le nom du setter à partir du tableau
            $method = 'set' . ucfirst($key);

            // Je vérifie si le setter correspondant existe.
            if (method_exists($this, $method)) {
                // On appelle le setter.
                $this->$method($value);
            }
        }
        //return de l'objet hydraté
        return $this;
    }
}
