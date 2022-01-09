<?php

namespace App\Models;

use App\Models;

/**
 * Modèle pour la table "utilisateurs"
 * qui ne contient qu'un admin pour l'instant
 */
class ModelUtilisateurs extends Model
{

    public function __construct()
    {
        $this->table = 'utilisateurs';
        $this->first_id = 'id_utilisateur';
        $this->columnToGetPrinted = 'nom';
    }
}