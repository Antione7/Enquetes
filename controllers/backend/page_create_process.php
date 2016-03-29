<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";

//recup de tous les champs
$id_enquete=isset($_GET['id'])?$_GET['id']:null;
$titre=isset($_POST['titre'])?$_POST['titre']:null;
$description=isset($_POST['description'])?$_POST['description']:null;
$libelle=isset($_POST['libelle'])?$_POST['libelle']:array();

for($i = 1; $i <= count($libelle); $i++){
	$type_reponse[]=isset($_POST['type'.$i])?$_POST['type'.$i]:array();
}

$tab_letter = ["a", "b", "c", "d", "e", "f", "g", "h"];

for($i = 1; $i <= count($libelle); $i++){
	for($j = 0; $j < count($tab_letter); $j++){
		if(isset($_POST['question'.$i.$tab_letter[$j]])){
			$tab_options['question'.$i][$tab_letter[$j]]=$_POST['question'.$i.$tab_letter[$j]];
		}else {
			break;
		}
	}
}


// //test sur les champs
$errorMsg = array();

if(!isset($titre) || $titre==""){
    $errorMsg[] = "Veuillez saisir un titre";
}

if(!isset($description) || $description==""){
    $errorMsg[] = "Veuillez saisir une description";
}

if(isset($libelle) && $libelle!=array()) {
	for($i = 0; $i < count($libelle); $i++){
		if($libelle[$i]==""){
			$errorMsg[] = "Veuillez vérifier que tous les libellés de vos questions soient bien remplis";
			break;
		}
	}
}

for($i = 1; $i <= count($libelle); $i++){
    if(!isset($errorMsg) || $errorMsg===array()){
        for($j = 0; $j < count($tab_letter); $j++){
            if(isset($_POST['question'.$i.$tab_letter[$j]]) && $_POST['question'.$i.$tab_letter[$j]] == ""){
                $errorMsg[] = "Veuillez vérifier que tous les choix de vos QCM soient bien remplis";
                break;
            }else {
                break;
            }
        }
    } else {
        break;
    }
}

//si il y a des erreurs redirection
if(count($errorMsg)>0){
    $msg = implode("<br />", $errorMsg);
    $sessionManager = new Manager\SessionManager();
    $sessionManager->errorMessage = $msg;
    if(isset($id_enquete)){
        header("Location: ../../views/backend/page_create.php?id=".$id_enquete);
    } else {
        header("Location: ../../views/backend/page_create.php");
    }
    die();
}

$sessionManager = new Manager\SessionManager();

$data = array('titre'=>$titre,
               'description'=>$description,
               'id_utilisateur'=>$sessionManager->id_utilisateur);

$enquete = new Entity\Enquete();
$enquete->hydrate($data);

$enqueteManager = new Manager\EnqueteManager();
if(isset($id_enquete)){
	$enquete->setId($id_enquete);
	$enqueteManager->update($enquete);
}else{
	$enqueteManager->insert($enquete);
}


if(isset($libelle) && $libelle!=array()){
    for($i=0; $i < count($libelle); $i++){
        $type_reponse_manager = new Manager\TypeReponseManager();
        $type_reponse_array = $type_reponse_manager->selectOneByName($type_reponse[$i]);
        $id_type_reponse = $type_reponse_array['id'];
        $data = array('libelle'=>$libelle[$i],
                    'id_enquete'=>$enquete->getId(),
                    'id_type_reponse'=>$id_type_reponse);

        $question = new Entity\Question();
        $question->hydrate($data);
        $tab_question[] = $question;

    }

    $questionManager = new Manager\QuestionManager();

    $reponseManager = new Manager\ReponseManager();

    $choixManager = new Manager\ChoixManager();



    //On supprime les choix puis les questions associés à l'ancienne enquête
    if(isset($id_enquete)){
        $old_tab_question = $questionManager->selectAllByEnqueteId($id_enquete);
        foreach ($old_tab_question as $old_question) {

            $id_old_question = $old_question->getId();
            $reponseManager->deleteByQuestionId($id_old_question);

            if($old_question->getId_type_reponse() == 3){
                $choixManager->deleteByQuestionId($id_old_question);
            }
        }

        $questionManager->deleteByEnqueteId($id_enquete);

    }

    $questionManager->insert($tab_question);

    for($i=0; $i < count($tab_question); $i++){
        $k=$i+1;
        if($tab_question[$i]->getId_type_reponse() == 3){
            for($j = 0; $j < count($tab_letter); $j++){
                if(isset($tab_options['question'.$k][$tab_letter[$j]])){
                    $data = array('libelle'=>$tab_options['question'.$k][$tab_letter[$j]],
                            'id_question'=>$tab_question[$i]->getId());

                }else{
                    break;
                }

                $choix = new Entity\Choix();
                $choix->hydrate($data);
                $tab_choix[] = $choix;
            }
        }
    }

    $choixManager->insert($tab_choix);
}

$sessionManager = new Manager\SessionManager();
if(isset($id_enquete)){
	$sessionManager->infoMessage = "Vos modifications ont bien été enregistrées, mais s'il y avait déjà des réponses, elles ont été supprimées.";
} else {
	$sessionManager->infoMessage = "Votre nouvelle enquête est bien enregistrée!";
}

header("Location: ../../views/backend/page_membre.php");
die();