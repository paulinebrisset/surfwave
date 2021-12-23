<?php
namespace App\Models;
use App\Models\Model;

/**
 * Modèle pour la table "items"
 */
class ModelTarifs extends Model {

    public function __construct(){
        $this->table = 'tarifs';
        $this->first_id= 'categoProd';
        $this->second_id= 'codeDuree';
    }
}