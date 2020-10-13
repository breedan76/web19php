<?php
//fichier de brice
require_once "../vendor/autoload.php";

/*
 * Autoloader de Classe
 */
function chargerClasse($classe){
    //Séparateur répertoire : "\" "/"
    $ds = DIRECTORY_SEPARATOR;
    $dir = __DIR__.$ds."..";
    $className = str_replace("\\",$ds,$classe);

    $file = "{$dir}{$ds}{$className}.php";

    if(is_readable($file)){
        require_once $file;
    }

}
spl_autoload_register("chargerClasse");

/**
 * ROUTEUR
 */
$urls = explode("/",$_GET["url"]);
$controller = (isset($urls[0])) ? $urls[0] : '';
$action = (isset($urls[1])) ? $urls[1] : '';
$param = (isset($urls[2])) ? $urls[2] : '';

if($controller <> '') {
    $class = "src\Controller\\{$controller}Controller";
    if(class_exists($class)){
        $ctrl = new $class;
        if(method_exists($class,$action)){
            echo $ctrl->$action($param);
        }else{
            //Gérer le cas où la méthode n'existe pas
        }
    }else{
        // Route par défaut
        $ctrl = new \src\Controller\DefaultController();
        echo $ctrl->index();
    }

}else{
    // Route par défaut
    $ctrl = new \src\Controller\DefaultController();
    echo $ctrl->index();
}
