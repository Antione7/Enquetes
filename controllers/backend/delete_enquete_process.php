<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";

$id_enquete=isset($_GET['id'])?$_GET['id']:null;

$enqueteManager = new Manager\EnqueteManager();
$questionManager = new Manager\QuestionManager();
$choixManager = new Manager\ChoixManager();
$reponseManager = new Manager\ReponseManager();

if(isset($id_enquete)){
	$tab_question = $questionManager->selectAllByEnqueteId($id_enquete);
	foreach ($tab_question as $question) {
		if($question->getId_type_reponse() == 3){
			$id_question = $question->getId();
			$choixManager->deleteByQuestionId($id_question);
            $reponseManager->deleteByQuestionId($id_question);
		}
	}

	$questionManager->deleteByEnqueteId($id_enquete);
	$enqueteManager->deleteById($id_enquete);
	
}