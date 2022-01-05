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

    public function get_tableName()
    {
        return $this->table;
    }
    public function get_columnToGetPrinted()
    {
        return $this->columnToGetPrinted;
    }
    // public function getTarificationData(string $column, string $critere, string $secondeTable, $condition = null)
    public function getTarificationData(model $instanceTarifs, model $instanceDuree, model $instanceCatprod)
    {
        


        $nomTablePrincipale = $instanceTarifs->get_tableName(); /*je récupère le nom de la table qui contient les tarifs*/

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
        ('order by '. $nomTablePrincipale.'.'.$instanceDuree->get_first_id().' asc, case '); 
        
       /* Maintenant, le but c'est que les tarifs soient récupérés dans l'ordre souhaité pour l'affichage : 
        les planches de surf en premier, puis bodyboard, puis combinaisons. 
        Cet ordre est mémorisé dans un tableau de ModelCatProd */

        $tableauIdsCatProd=$instanceCatprod->id_values;
            foreach ($tableauIdsCatProd as $abreviation=>$rang){
                $condition .=(' when '.$nomTablePrincipale.'.'.$instanceCatprod->first_id.' like "'.$abreviation.'" then '.$rang);
            }

        $condition .= ' end ';

        //L J'utilise une fonction de Model pour aller chercher les résultats et les ramener à la fonction qui a appelé celle-ci
        return $this->planATrois($instanceDuree, $instanceCatprod, $condition);
    }
}
