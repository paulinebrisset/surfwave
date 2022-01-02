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
        // ('order by
        //     tarifs.codeDuree asc, 
        //     case 
        //         when tarifs.categoProd LIKE "PS" then 1 
        //         when tarifs.categoProd LIKE "BB" then 2
        //         when tarifs.categoProd LIKE "CO"  then 3
        //     end
        // ');

        $nomTablePrincipale = $instanceTarifs->get_tableName();
        /*organiser l'ordre de réception des tarifs
        j'ai un tableau qui contient tous les id dans ModelCatProd*/

        $condition =      
        ('order by '. $nomTablePrincipale.'.'.$instanceDuree->get_first_id().', case ');


        $catprodIds=$instanceCatprod->id_values;
        foreach ($catprodIds as $abreviation=>$rang){
            $condition .=(' when '.$nomTablePrincipale.'.'.$instanceCatprod->first_id.' like "'.$abreviation.'" then '.$rang);
        }
        $condition .= ' end ';
        return $this->planATrois($instanceTarifs, $instanceDuree, $instanceCatprod, $condition);
    }
}
