<?php 
namespace App\Controllers;
use App\Models\ModelTarifs;

class MainController extends Controller{

    public function index() {
        $tarifsModel = new ModelTarifs;
        $this->render('main/index', [], 'default');
    }
}