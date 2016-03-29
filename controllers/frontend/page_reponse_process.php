<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";

$unique_id=isset($_GET['unique_id'])?$_GET['unique_id']:uniqid();

$id =isset($_GET['id'])?$_GET['id']:null;
$questionManager = new Manager\QuestionManager();
$tab_question = $questionManager->selectAllByEnqueteId($id);

for($i=1; $i <= count($tab_question); $i++){
	$texte['texte'.$i] = isset($_POST['texte'.$i])?$_POST['texte'.$i]:null;
}
$texte=array_filter($texte);

foreach ($texte as $key => $value) {
	
	$newkey = str_replace("texte", "", $key);
	$texte[$newkey]=$value;
	unset($texte[$key]);
}


for($i=1; $i <= count($tab_question); $i++){
	$nombre['nombre'.$i] = isset($_POST['nombre'.$i])?$_POST['nombre'.$i]:null;
}

$nombre=array_filter($nombre);


foreach ($nombre as $key => $value) {
	
	$newkey = str_replace("nombre", "", $key);
	$nombre[$newkey]=$value;
	unset($nombre[$key]);
}


for($i=1; $i <= count($tab_question); $i++){
	$qcm['qcm'.$i] = isset($_POST['qcm'.$i])?$_POST['qcm'.$i]:null;
}

$qcm=array_filter($qcm);

foreach ($qcm as $key => $value) {
	
	$newkey = str_replace("qcm", "", $key);
	$qcm[$newkey]=$value;
	unset($qcm[$key]);
}

$errorMsg = array();

foreach($nombre as $key => $value){
	$nombre[$key] = str_replace(",", ".", $value);

	if(!is_numeric($nombre[$key])){
		$errorMsg[$key]="La réponse à la question ".$key." doit être un nombre";
		unset($nombre[$key]);
	}
}



$reponses= $texte + $nombre + $qcm;


$currentQuestion = 1;

$tab_reponse = array();
foreach($tab_question as $question){
	
	
	if(isset($reponses[$currentQuestion])){
		$data= array('libelle'=>$reponses[$currentQuestion],
						'id_question'=>$question->getId(),
						'unique_id'=>$unique_id);
		$reponse = new Entity\Reponse();
		$reponse->hydrate($data);
		$tab_reponse[]=$reponse;

	}


	$currentQuestion++;
}

$reponseManager = new Manager\ReponseManager();
if(isset($_GET['unique_id'])){
	$reponseManager->deleteByUniqueId($unique_id);
}
$reponseManager->insert($tab_reponse);

ksort($errorMsg);


if(count($errorMsg)>0){
    $msg = implode("<br />", $errorMsg);
    $sessionManager = new Manager\SessionManager();
    $sessionManager->errorMessage = $msg;
    header("Location: ../../views/frontend/page_reponse.php?id=".$id."&unique_id=".$unique_id);
    die();
}

$msg = "Vos r&eacute;ponses ont bien &eacute;t&eacute; enregistr&eacute;es";
$sessionManager = new Manager\SessionManager();
$sessionManager->infoMessage = $msg;
header("Location: ../../views/frontend/page_home.php");
die();