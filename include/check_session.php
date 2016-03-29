<?php

$sessionManager = new Manager\SessionManager();

if(!$sessionManager->Z45THYIOPOK67){
    $sessionManager->errorMessage= "Veuillez vous authentifier ou vous inscrire";
    header("Location: ../../index.php");
    die();
}
