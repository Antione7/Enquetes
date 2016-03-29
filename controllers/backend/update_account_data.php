<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";

$id_utilisateur=isset($_POST['id_utilisateur'])?$_POST['id_utilisateur']:null;
$email=isset($_POST['email'])?$_POST['email']:null;
$password=isset($_POST['password'])?$_POST['password']:null;
$password2=isset($_POST['password2'])?$_POST['password2']:null;

$utilisateurManager = new Manager\UtilisateurManager();
$old_utilisateur = $utilisateurManager->selectOneById($id_utilisateur);

//test sur les champs
$errorMsg = array();

if(!isset($email) || $email==""){
    $errorMsg[] = "Saisir votre email";
}

if($utilisateurManager->emailExist($email) && $old_utilisateur['email']!=$email ){
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

//si il y a des erreurs redirection
if(count($errorMsg)>0){
    echo json_encode($errorMsg);
    die();
}

//Mis à jour de l'utilisateur
$utilisateur = new Entity\Utilisateur();
$utilisateur->setEmail($email);
$utilisateur->setPassword($password);
$utilisateur->setId($id_utilisateur);

$utilisateurManager->update($utilisateur);
$msg=array();
$msg[] = "";
echo json_encode($msg);
die();