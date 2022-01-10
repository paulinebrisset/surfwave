<?php

namespace App\Models;

use App\Main\Database;
use PDO;


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
    public function get_second_id()
    {
        return $this->second_id;
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
    private function executerRequete(string $sql, array $attributs = null)
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
    UTILISE PAR : La fonction index() de TarifsController via une instance de ModelTarif
    + pour l'affichage des membres d'équipe
*/

    public function findAll(string $condition = null)
    {
        $query = $this->executerRequete('SELECT * FROM ' . $this->table . ' ' . $condition); //TODO : à vérifier 
        return $query->fetchAll();
    }

    /* findBy
M : Sélection de plusieurs enregistrements suivant un tableau de critères
M: écrire des choses du style : $item = new ModelItem / $resultats = $item->findBy(['admin'=>'true'])
 va donner par ex SELECT * FROM utilisateurs WHERE admin =? AND id=2;
 & parametres (1, valeur)
O : return array Tableau des enregistrements trouvés
I: array $criteres Tableau de critères
*/

    public function findBy(array $criteres, string $condition = null) //Je m'en sers pour check le user 
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
        $query = $this->executerRequete('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs . ' ', $valeurs);
        return $query->fetchAll();
    }

    /***
     * Trouver une donnée dans une table où la clé primaire est composée de deux clés étrangères
     * on lui envoie des instances des modèles correspondant à ces trois tables pour cela. On récupère un tableau associatif
     */

    public function findBy2FK(model $tableAnnexe1, model $tableAnnexe2, string $condition = null, bool $toutesColonnes)
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

        //je sélectionne les "jolie colonnes" dans un select pour la vue au public
      
            $listeSelect = ('select ' . $colonnePrincipale . ', ' . $colonneAPublier1 . ', ' . $colonneAPublier2 . ' ');
        
        //je sélectionne plus de colonnes pour la partie gestion
        if ($toutesColonnes == true) {
            $first_id = $this->first_id;
            $second_id = $this->second_id;
            $listeSelect .= (', ' . $tablePrincipale . '.' . $first_id . ', ' . $tablePrincipale . '.' . $second_id . ' ');
        }
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



    public function findMissing2FK(model $tableAnnexe1, model $tableAnnexe2)
    {
        /*La requete que cela va créer pour la table tarifs 
            SELECT codeDuree,categoProd, libDuree, libcategoProd
            from duree 
            inner join catProd
            where concat(codeDuree, categoprod) not in 
               ( SELECT concat(tarifs.codeDuree, tarifs.categoprod) as con 
                from tarifs))
    */
    
        $table1 = $tableAnnexe1->get_tableName();
        $cle1 = $tableAnnexe1->get_first_id();

        $table2 = $tableAnnexe2->get_tableName();
        $cle2 = $tableAnnexe2->get_first_id();


        //$this se réfère au model appelant 
        $tablePrincipale = $this->get_tableName();

        /***fabrication de la sous-requete ****/
        $sousRequete = ' ( Select concat( ' . $tablePrincipale . '.' . $cle1 . ',' . $tablePrincipale . '.' . $cle2 . ')';
        $sousRequete .= ' from ' . $tablePrincipale.' )';

        /****Requete principale */
        $requete = ' Select * ';
        $requete .= ' from ' . $table1;
        $requete .= ' inner join ' . $table2;
        $requete .= ' where concat(' . $cle1 . ',' . $cle2 . ') not in ';
        $requete .=$sousRequete;

        //J'utilise executerRequete qui est une méthode de Model pour aller chercher les donnée
        $request = $this->executerRequete($requete);
        return $request->fetchAll();
    }

    /*********************PARTIE CREATE DES DONNEES *********************/

    public function creer(array $tableau)
    {
        $champs = [];
        $valeurs = [];
        $liste_valeurs = '\''; //pour mettre toutes les insertions entre quotes
        // On réorganise le tableau des paramètres pour l'exploiter
        foreach ($tableau as $champ => $valeur) {
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

    /*********************PARTIE UPDATE DES DONNEES *********************/
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

    /*
  update de la valeur d'un champ d'une table dont la clé primaire est composée de deux clé étrangères
renvoie probablement un booléen (pas tableau en tout cas, pas de fetch)
  */
    public function update2FK($cle1, $cle2, $value)
    {
        $requete = ('update ' . $this->table . ' set ' . $this->columnToGetPrinted . ' = ' . $value);
        $requete .= (' where ' . $this->first_id . ' = ' . $cle1 . ' and ' . $this->second_id . ' = ' . $cle2);
        // On exécute la requête
        return  $this->executerRequete($requete);
    }

    public function update(int $id, array $criteres)//update standard inutilisé
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
    public function delete(array $criteres)
    {
        foreach ($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }
        return $this->executerRequete("DELETE FROM " . $this->table . " WHERE " . $champs, $valeurs);
    }
    /***
     * Supprimer une valeur dans une table où une clé primaire est composée de deux clés étrangères
     * Il faut donc envoyer la data dans l'ordre first id/second id
     */
    public function delete2FK(array $valeurs)
    {
        $champs = ($this->first_id . ' = ? and ' . $this->second_id . ' =?');
        return $this->executerRequete("DELETE FROM " . $this->table . " WHERE " . $champs, $valeurs);
    }
}
