<?php
namespace App\Models;
use App\Models\Model;

/**
 * Modèle pour la table "qdp"
 */
class ModelQDP extends Model {

    public function __construct(){
        $this->table = 'qdp';
        $this->first_id= 'codeEq';
        $this->second_id= 'idQuest';
    }
}