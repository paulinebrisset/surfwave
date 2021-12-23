<?php
namespace App;

class Autoload {
    //on met en statique pour ne pas avoir à instancer la classe pour utiliser la fonction register
    //__class__ , constante magique, récupère le nom de la classe courante 

    static function register(){     
        spl_autoload_register([
            __CLASS__, 
            'autoload']); //on appelle la fonction autoload, écrite juste en dessous
    }

    static function autoload($class_name){
            /* tuto utilisé: https://nouvelle-techno.fr/articles/live-coding-php-oriente-objet-namespace-et-autoload*/
            //on échappe le slash pour que lui-même n'échappe pas l'apostrophe
            $class_name = str_replace(__NAMESPACE__. '\\','',$class_name); //on retire le namespace "App" de la class Autoload
            $class_name = str_replace('\\','/',$class_name); //on remplace les \ par des /
        
            if(file_exists(__DIR__ . '/' . $class_name . '.php')){
            require __DIR__ . '/' . $class_name . '.php'; 
        }
    }
}