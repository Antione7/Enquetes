<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/header.php";
?>
<div class="container">
	<div class="row">
        <h1 class="text-center">
           Résultats
        </h1>
 	</div>
    <br/>
    <div class="row">
        <a class="btn btn-warning pull-right" href="page_membre.php">Revenir &agrave; la page membre</a>
    </div>
    <br/>

 	<?php
	$id = isset($_GET['id'])?$_GET['id']:null;
	$enqueteManager = new Manager\EnqueteManager();
	$enquete_array = $enqueteManager->selectOneById($id);
	?>
    <div class="row">
        <h3><?php echo htmlentities($enquete_array['titre']) ?></h3>
    </div>
	<?php
	$reponseManager = new Manager\ReponseManager();
	$answer_number = $reponseManager->getAnswerNumberByEnqueteId($id);
	?>
    <div class="row">
        <h4>Nombre de réponses:&nbsp;<?php echo $answer_number ?></h4>
    </div>

	<?php
	
	$questionManager = new Manager\QuestionManager();
	$tab_question = $questionManager->selectAllByEnqueteId($id);

	$currentQuestion = 0;
	foreach ($tab_question as $question) :?>
		<?php $currentQuestion++ ?>
		<div class="row border-question">
	        <h4>Question n°<?php echo $currentQuestion ?>:&nbsp;<?php echo htmlentities($question->getLibelle()) ?></h4>

			<?php 
			$id_type_reponse = $question->getId_type_reponse();
			$type_reponse_manager = new Manager\TypeReponseManager();
			$type_reponse_array = $type_reponse_manager->selectOneById($id_type_reponse);
			$type_reponse = $type_reponse_array['name'];
			$id_question = $question->getId();
			$tab_reponse = $reponseManager->selectAllByQuestionId($id_question);

			
			switch($type_reponse):
			case 'texte': 
			
				foreach($tab_reponse as $reponse): ?>
				
				<div class="row">
					<p><?php echo htmlentities($reponse->getLibelle()) ?></p>
				</div>

			<?php
				endforeach;
			break;
			case 'nombre':
				$tab_reponse_nombre = array();
				foreach($tab_reponse as $reponse){

					$tab_reponse_nombre[] = $reponse->getLibelle();
					
				}

			?>
			<div class="row">
				<p> Minimum :&nbsp;<?php echo !empty($tab_reponse_nombre)?min($tab_reponse_nombre):0 ?></p>
				<p> Maximum :&nbsp;<?php echo !empty($tab_reponse_nombre)?max($tab_reponse_nombre):0 ?></p>
				<p> Somme :&nbsp;<?php echo array_sum($tab_reponse_nombre) ?></p>
				<p> 
                    Moyenne :&nbsp;<?php echo !empty($tab_reponse_nombre)?array_sum($tab_reponse_nombre)/count($tab_reponse_nombre):0 ?>                   </p>
			</div>

			<?php break;
			case 'qcm': ?>
			
			<div id="chartContainer<?php echo $currentQuestion ?>" class="question_id" data-question-id="<?php echo $question->getId() ?>" style="height: 300px; width: 100%;"></div>
			
			<?php break; ?>
			<?php endswitch ?>
		</div>
	<?php endforeach; ?>

<script src="../../assets/js/jquery.canvasjs.min.js"></script>
<script src="../../assets/js/page_resultats.js"></script>

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/footer.php";
?>