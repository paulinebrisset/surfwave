<?php

namespace App\Models;

use App\Models\Model;

/**
 * Modèle pour la table "duree"
 */
class ModelDuree extends Model
{

    public function __construct()
    {
        $this->table = 'duree';
        $this->first_id = 'codeDuree';
        $this->columnToGetPrinted='libDuree';
    }

}
