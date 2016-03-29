<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/displaymessage.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/header.php";
?>
<div class="container">
	<?php
	$unique_id = isset($_GET['unique_id'])?$_GET['unique_id']:null;
	$id = isset($_GET['id'])?$_GET['id']:null;
	$enqueteManager = new Manager\EnqueteManager();
	$enquete_array = $enqueteManager->selectOneById($id);
	?>
    <div class="row">
	   <h1 class="text-center"><?php echo htmlentities($enquete_array['titre']) ?></h1>
    </div>
    <br/>
    <div class="row message">
   		<?php echo $message;?>
	</div>
    
    <div class="row">
        <a class="btn btn-warning pull-right" href="page_membre.php">Revenir &agrave; la page membre</a>
    </div>
    <br>
    <div class="row">
	   <h4><?php echo htmlentities($enquete_array['description']) ?></h4>
    </div>


	<div class="row">
        <form action="#" method="POST">
        <?php


        $questionManager = new Manager\QuestionManager();
        $tab_question = $questionManager->selectAllByEnqueteId($id);

        $currentQuestion = 0;
        foreach ($tab_question as $question) :?>
            <?php $currentQuestion++ ?>
            <div class="block_question">
                <fieldset class="block">
                    <legend>Question n°<?php echo $currentQuestion ?>:&nbsp;<?php echo htmlentities($question->getLibelle()) ?></legend>

                    <?php 
                    $id_type_reponse = $question->getId_type_reponse();
                    $type_reponse_manager = new Manager\TypeReponseManager();
                    $type_reponse_array = $type_reponse_manager->selectOneById($id_type_reponse);
                    $type_reponse = $type_reponse_array['name'];
                    if(isset($unique_id)){
                        $reponseManager = new Manager\ReponseManager();
                        $tab_reponse = $reponseManager->selectAllByQuestionId($question->getId());
                        foreach($tab_reponse as $value){
                            if($value->getUnique_id() == $unique_id){
                                $reponse = $value;
                                break;
                            } else {
                                $reponse= null;
                            }
                        }
                    }

                    switch($type_reponse):
                    case 'texte': ?>

                    <label for="texte<?php echo $currentQuestion ?>">Réponse:</label>
                    <textarea class="form-control" name="texte<?php echo $currentQuestion ?>" disabled></textarea>

                    <?php 
                    break;
                    case 'nombre': 
                    ?>
                    <label for="nombre<?php echo $currentQuestion ?>">Réponse:&nbsp;<a href="#" class="help_answer"><span class="glyphicon glyphicon-question-sign"></span></a></label>
                    <input class="form-control" type="text" name="nombre<?php echo $currentQuestion ?>" disabled/>
                    <?php break;
                    case 'qcm': 
                    $id_question = $question->getId();
                    $choixManager = new Manager\ChoixManager();
                    $tab_choix = $choixManager->selectAllByQuestionId($id_question);

                    $tab_letter=["a", "b", "c", "d", "e", "f", "g", "h"];
                    $i = 0;
                    foreach ($tab_choix as $choix): ?>
                        <label class="radio radio_reponse">
                            <input type="radio" name="qcm<?php echo $currentQuestion ?>" disabled /><?php echo strtoupper($tab_letter[$i]) ?>:&nbsp;<?php echo htmlentities($choix->getLibelle()) ?>
                        </label>
                        <?php $i++ ?>
                    <?php endforeach; ?>

                    <?php break; ?>
                    <?php endswitch ?>
                </fieldset>
            </div>
        <?php endforeach; ?>
            <hr/>
            <input class="btn btn-success pull-right" disabled type='submit' value='envoyer'/>
        </form>
    </div>
</div>

<script src="../../assets/js/page_reponse.js"></script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/footer.php";
?>