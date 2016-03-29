<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";

//var_dump($_POST);

$email=isset($_POST['email'])?$_POST['email']:null;
$password=isset($_POST['password'])?$_POST['password']:null;
$password2=isset($_POST['password2'])?$_POST['password2']:null;

$utilisateurManager = new Manager\UtilisateurManager();

//test sur les champs
$errorMsg = array();

if(!isset($email) || $email==""){
    $errorMsg[] = "Saisir votre email";
}

if($utilisateurManager->emailExist($email)){
    $errorMsg[] = "Cet email existe déjà";
}

if(!isset($password) || $password==""){
    $errorMsg[] = "Saisir votre mot de passe";
}

if(!isset($password2) || $password2==""){
    $errorMsg[] = "Saisir votre confirmation de mot de passe";
}

//verif password et password2
if($password!=$password2){
    $errorMsg[] = "Le mot de passe et sa confirmation sont différents";
}

//s'il y a des erreurs redirection
if(count($errorMsg)>0){
    $msg = implode("<br />", $errorMsg);
    $sessionManager = new Manager\SessionManager();
    $sessionManager->errorMessage = $msg;
    header("Location: ../../index.php");
    die();
}

//Insertion du nouvel utilisateur
$utilisateur = new Entity\Utilisateur();
$utilisateur->setEmail($email);
$utilisateur->setPassword($password);
$utilisateurManager->insert($utilisateur);

//On monte les variables en session, puis on redirige vers la page membre
$sessionManager = new Manager\SessionManager();
$sessionManager->id_utilisateur = $utilisateur->getId();
$sessionManager->email = $email;
$sessionManager->Z45THYIOPOK67 = true;
$sessionManager->infoMessage = "Merci pour votre inscription, vous pouvez désormais 
créer votre première enquête en cliquant sur le bouton \"créer une nouvelle enquête\"";
header("Location: ../../views/backend/page_membre.php");
die();

