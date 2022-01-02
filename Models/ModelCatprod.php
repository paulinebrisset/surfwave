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
        $this->columnToGetPrinted ='libCategoProd';
        $this->id_values= array(
            'PS'  => 1,
            'BB'  => 2,
            'CO'  => 3,
        );
    }

}