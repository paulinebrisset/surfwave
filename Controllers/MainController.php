<?php 
namespace App\Controllers;
use App\Models\ModelCatprod;
use App\Models\ModelTarifs;
use App\Models\ModelDuree;

class MainController extends Controller{

    public function index() {
        $instanceTarifs= new ModelTarifs;
        $instanceDuree= new ModelDuree;
        $instanceCatprod= new ModelCatprod;
        
    //J'utilise une méthode de ModelTarifs pour aller récupérer tous les tarifs
    //Cette méthode préparera la requête et la fera excécuter via des méthode de Model et de Database

       $tarifs=$instanceTarifs->getTarificationData($instanceTarifs, $instanceDuree, $instanceCatprod);
       $this->render('tarifs/index', ['tarifs'=>$tarifs], 'default');
    }
}