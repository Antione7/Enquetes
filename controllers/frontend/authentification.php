<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";

$email=isset($_POST['email'])?$_POST['email']:null;
$password=isset($_POST['password'])?$_POST['password']:null;

//test sur les champs
$errorMsg = array();

if(!isset($email) || $email==""){
    $errorMsg[] = "Saisir votre email";
}

if(!isset($password) || $password==""){
    $errorMsg[] = "Saisir votre mot de passe";
}

//si il y a des erreurs redirection
if(count($errorMsg)>0){
    $msg = implode("<br />", $errorMsg);
    $sessionManager = new Manager\SessionManager();
    $sessionManager->errorMessage = $msg;
    header("Location: ../../index.php");
    die();
}

//Authentification de l'email et du mot de passe
$utilisateurManager = new Manager\UtilisateurManager();

if($utilisateurManager->authentification($email, $password)){
    //tout est ok redirection vers la page memebre
    header("Location: ../../views/backend/page_membre.php");
    die();
}else{
    //c'est pas bon redirection sur la page d'accueil
    $sessionManager = new Manager\SessionManager();
    $sessionManager->errorMessage = "Problème d'identification";
    header("Location: ../../index.php");
    die();
}