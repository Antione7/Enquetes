<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";

$sessionManager = new Manager\SessionManager();
$sessionManager->destroy();

$sessionManager->restart();
$sessionManager->infoMessage = "Votre session est terminée";
header('Location: ../../index.php');
die();