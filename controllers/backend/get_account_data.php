<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";

$id_utilisateur=isset($_POST['id_utilisateur'])?$_POST['id_utilisateur']:null;

$utilisateurManager = new Manager\UtilisateurManager();
$utilisateur= $utilisateurManager->selectOneById($id_utilisateur);

echo json_encode($utilisateur);