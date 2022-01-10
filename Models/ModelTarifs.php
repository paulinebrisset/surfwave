<?php

namespace App\Models;

use App\Models\Model;

/**
 * Modèle pour la table "items"
 */
class ModelTarifs extends Model
{

    public function __construct()
    {
        $this->table = 'tarifs';
        $this->first_id = 'categoProd';
        $this->second_id = 'codeDuree';
        $this->columnToGetPrinted='prixLocation';
    }
    
/*
renvoie tous les tarifs dans l'ordre de la durée la plus courte à la plus longue, 
et dans l'ordre de catégories définit dans le ModelCatProd
et utilise une méthode de Model pour récupérer les résultats
Le booléen $param permet de dire si on veut récupérer toutes les colones (pour l'interface de gestion)
ou seulement les colones à présenter au grand public 
*/
    public function getTarificationData(bool $param)
    {
        $instanceDuree = new ModelDuree;
        $instanceCatprod = new ModelCatprod;

        $nomTablePrincipale = $this->get_tableName(); /*je récupère le nom de la table qui contient les tarifs*/

        // Là je vais écrire la condition. Je veux récupérer la phrase suivante : 

        // ('order by
        //     tarifs.codeDuree asc, 
        //     case 

        //         when tarifs.categoProd LIKE "PS" then 1 
        //         when tarifs.categoProd LIKE "BB" then 2
        //         when tarifs.categoProd LIKE "CO"  then 3
        //     end
        // ');

        $condition =      
        ('order by '. $nomTablePrincipale.'.'.$instanceDuree->get_first_id().' asc, '); 
        
       /* Maintenant, le but c'est que les tarifs soient récupérés dans l'ordre souhaité pour l'affichage : 
        les planches de surf en premier, puis bodyboard, puis combinaisons. 
        Cet ordre est mémorisé dans un tableau de ModelCatProd
        TODO créer une interface où on puisse changer cet ordre ou ajouter une nouvelle catégorie
        Une méthode de ModelCatProd permet de récupérer un string qui met tout ça en ordre */

        $condition.=$instanceCatprod->get_conditionCatProd($nomTablePrincipale);
   
        // J'utilise une fonction de Model pour aller chercher les résultats et les ramener à la fonction qui a appelé celle-ci
        return $this->findBy2FK($instanceDuree, $instanceCatprod, $condition, $param);
    }
    /*faire l'update d'un tarif. Reçoi un array de la part de GestionController qui contient 
    la concaténation des 2FK qui permettent d'identifier le bon tarif, et le nouveau tarif
    TODO: essayer un SQL CONCAT() là-dessus directement
    renvoie true mais je ne m'en sers pas pour l'instant*/

    public function updateTarif(array $prixAChanger){
        foreach ($prixAChanger as $key=>$value){
            $cle1='\''.substr($key, 2, 2).'\'';//Je les met entre guillement sinon requete ne fonctionne pas. Ici on va retourver les categoProd
            $cle2='\''.substr($key, 0,2).'\'';//le code duree
            return $this->update2FK($cle1, $cle2, $value); //contient un tableau associatif avec la requete dedans quand ok
            return true;
        }
    }
    /*********CREATE **** */
    public function creerTarif(array $nouveauxTarifs){ //[$concat=>$_POST[$concat]];
        
        foreach ($nouveauxTarifs as $key=>$value){
            var_dump($nouveauxTarifs);
            $cle1=substr($key, 2, 2);//Je les met entre guillement sinon requete ne fonctionne pas. Ici le code categoprod
           
           
            echo($cle1);
            $cle2=substr($key, 0,2);//le code duree

            $values [$this->get_first_id()]= $cle1;
            $values [$this->get_second_id()] = $cle2;
            $values [$this->get_columnToGetPrinted()]=$value;
            $resultat = $this->creer($values);
            return $resultat;
        }
    }
    public function trouverLesTarifsManquants(){
        $instanceDuree = new ModelDuree;
        $instanceCatprod = new ModelCatprod;
        return $this->findMissing2FK($instanceDuree, $instanceCatprod);
    }
}