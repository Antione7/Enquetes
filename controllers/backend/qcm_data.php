<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";

$question_id = isset($_GET['question_id'])?$_GET['question_id']:null;
$reponseManager = new Manager\ReponseManager();

$choixManager = new Manager\ChoixManager();
$tab_choix = $choixManager->selectAllByQuestionId($question_id);
$tab_occurences_reponse = $reponseManager->selectOccurencesLibelleByQuestionId($question_id);

$tab_reponse_choix = array();
$i=0;
foreach ($tab_choix as $choix){
	$tab_reponse_choix[$i]['label']=$choix->getLibelle();
	$tab_reponse_choix[$i]['y']=isset($tab_occurences_reponse[$choix->getLibelle()])?intval($tab_occurences_reponse[$choix->getLibelle()]):0;
	$i++;
}

echo json_encode($tab_reponse_choix);