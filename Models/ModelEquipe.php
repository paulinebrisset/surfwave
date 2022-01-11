<?php

namespace App\Models;

use App\Models;

/**
 * Modèle pour la table "equipe"
 */
class ModelEquipe extends Model
{

    public function __construct()
    {
        $this->table = 'equipier';
        $this->first_id = 'codeEq';
        $this->columnToGetPrinted = 'fonctionEq';
        $this->ordre_selon_fonction = array(
            'directeur'  => 1,
            'commercial'  => 2,
            'moniteur'  => 3,
            'e-commerce'  => 4,
        );
    }
    /*TODO Il faudrait mettre une partie de cette fonction dans Model pour pouvoir opitmiser avec ModelCatProd*/
    /***
     * Réupérer toute la data concernant les équipiers
     * elle sera rangée selon la fonction de l'équipier
     */
    public function get_EquipeData()
    {
        $tableauOrdreEquipiers = $this->ordre_selon_fonction;
        $condition = 'order by case ';
        foreach ($tableauOrdreEquipiers as $membre => $rang) {
            $condition .= (' when ' . $this->get_columnToGetPrinted() . ' like "' . $membre . '" then ' . $rang);
        }
        $condition .= ' end ';
        return $this->findAll($condition);
    }
}
