<?php

namespace App\Models;

use App\Models\Model;

/**
 * Modèle pour la table "catprod"
 */
class ModelCatprod extends Model
{

    public function __construct()
    {
        $this->table = 'catprod';
        $this->first_id = 'categoProd';
        $this->columnToGetPrinted = 'libCategoProd';
        $this->id_values = array(
            'PS'  => 1,
            'BB'  => 2,
            'CO'  => 3,
        );
    }
    /*
    Méthode pour créer un string qui permette de sortir les résultats des tarifs
    en respectant l'ordre des catégories voulu par l'utilisateur
    retourne un string avec une condition prête à l'emploi pour la table qui l'appelle, 
    seulement "tarif" pour le moment
    */

    public function get_conditionCatProd($table) // ModelTarifs l'utilise aussi
    {
        $tableauIdsCatProd = $this->get_id_values();
        $condition = 'case ';
        foreach ($tableauIdsCatProd as $abreviation => $rang) {
            $condition .= (' when ' . $table . '.' . $this->get_first_id() . ' like "' . $abreviation . '" then ' . $rang);
        }
        $condition .= ' end ';
        return $condition;
    }

    /* récupère tous les libellés de produits à vendre
        en fonction de l'ordre définit dans le tableau de la classe*/
    public function get_lib_values()
    {
        $condition = ' order by ';
        $condition .= $this->get_conditionCatProd($this->get_tableName()); //$this = ModelCatProd
        $libellesColonnes = $this->findAll($condition);
        foreach ($libellesColonnes as $nomCat) {
            $option[] = $nomCat['libcategoProd'];
        }
        return $option;
    }
}
