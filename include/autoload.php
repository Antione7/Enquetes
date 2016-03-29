<?php

spl_autoload_register('chargerClasse');

function chargerClasse($nom_classe){
    $path = $_SERVER['DOCUMENT_ROOT']."/models/".$nom_classe.".php";
    $path= str_replace("\\",DIRECTORY_SEPARATOR,$path);
    $path= str_replace("/",DIRECTORY_SEPARATOR,$path);//ceinture et bretelle
    require_once $path;
}