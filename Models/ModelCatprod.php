<?php

namespace App\Models;

use App\Models\Model;

/**
 * Modèle pour la table "items"
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
    //bref les deux fonctions en dessous ne sont pas satisfaisantes du tout parce qu'elles ne sont pas otpimisées

    public function get_conditionCatProd($table) // IL FAUDRAIT LA METTRE EN PRIVATE MAIS JE N Y ARRIVE PAS
    {
        $tableauIdsCatProd = $this->id_values;
        $condition = 'case ';
        foreach ($tableauIdsCatProd as $abreviation => $rang) {
            $condition .= (' when ' . $table . '.' . $this->first_id . ' like "' . $abreviation . '" then ' . $rang);
        }
        $condition .= ' end ';
        return $condition;
    }

    //TODO A AMELIORER PARCE QUE LA IL S instancie tout seul pour faire des trucs, bref c'est le bazar
    public function get_lib_values()
    {
        $instanceCatProd = new ModelCatprod;

        $condition = ' order by ';
        $condition .= $instanceCatProd->get_conditionCatProd($instanceCatProd->get_tableName());
        $libellesColonnes = $instanceCatProd->findAll($condition);
        foreach ($libellesColonnes as $nomCat) {
            $option[] = $nomCat['libcategoProd'];
        }
        return $option;
    }
}
