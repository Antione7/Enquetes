 <?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/displaymessage.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/header.php";

$id_enquete = isset($_GET['id'])?$_GET['id']:null;
?>
<div class="container">
	<div class="row">
    	<h1 class="text-center">
       		<?php
       		 $page=isset($id_enquete)?"Modification de l'enquête":"Nouvelle enquête";
       		 echo $page;
       		 ?>
    	</h1>
	</div>
    <div class="row message">
   		<?php echo $message;?>
	</div>
    
    <div class="row">
        <a class="btn btn-warning pull-right" href="page_membre.php">Revenir &agrave; la page membre</a>
    </div>
    
    <br />

    <div class="row">
        <?php if(!isset($id_enquete)): ?>        	
        <form action="../../controllers/backend/page_create_process.php" method="POST">

            <label for="titre">Titre:</label>
            <input class="form-control" type="text" name="titre" />
            <label for="description">Description:</label>
            <textarea class="form-control" name="description"></textarea>


            <?php 
            else: 
            $enqueteManager = new Manager\EnqueteManager();
            $tab_enquete = $enqueteManager->selectOneById($id_enquete);
            ?>

            <form action="../../controllers/backend/page_create_process.php?id=<?php echo 
    $id_enquete ?>" method="POST">

                <label for="titre">Titre:</label>
                <input class="form-control" type="text" name="titre" value="<?php echo htmlentities($tab_enquete["titre"]) ?>" />
                
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" ><?php echo htmlentities($tab_enquete["description"]) ?></textarea>

                <?php $questionManager = new Manager\QuestionManager();
                $tab_question = $questionManager->selectAllByEnqueteId($id_enquete);
                $currentQuestion = 0;
                foreach ($tab_question as $question): 
                    $currentQuestion++ ?>
                <div class="block_question">
                    <fieldset class="block">

                        <legend>Question n°<span class="number_question"><?php echo $currentQuestion ?></span>:
                            <a class="remove_question btn btn-danger pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                        </legend>
                        <label for="libelle[]">Libellé:</label>
                        <input class="form-control" type="text" name="libelle[]" value="<?php echo htmlentities($question->getLibelle()) ?>"/>

                        <p><strong>Type:</strong></p>
                        <?php 
                        $id_type_reponse = $question->getId_type_reponse();
                        $type_reponse_manager = new Manager\TypeReponseManager();
                        $type_reponse_array = $type_reponse_manager->selectOneById($id_type_reponse);
                        $type_reponse = $type_reponse_array['name']; 
                        ?>
                        <label class='radio-inline'>
                            <input type="radio" name="type<?php echo $currentQuestion ?>" value="texte" <?php echo $type = $type_reponse=="texte"?  "checked": null ?> />Texte
                        </label>
                        <label class='radio-inline'>
                            <input type="radio" name="type<?php echo $currentQuestion ?>" value="nombre" <?php echo $type = $type_reponse=="nombre"?  "checked": null ?> />Nombre
                        </label>
                        <label class='radio-inline'>
                            <input type="radio" name="type<?php echo $currentQuestion ?>" value="qcm" <?php echo $type = $type_reponse=="qcm"?  "checked": null ?> />QCM
                        </label>
                        
                        <?php 
                        if($type_reponse == "qcm"): ?>
                        <div class="block_qcm" style="padding: 1em;">
                            <?php
                            $id_question = $question->getId();
                            $choixManager = new Manager\ChoixManager();
                            $tab_choix = $choixManager->selectAllByQuestionId($id_question);

                            $tab_letter=["a", "b", "c", "d", "e", "f", "g", "h"];
                            $i = 0;
                            foreach ($tab_choix as $choix): ?>
                            <div class="choice">
                                <label for = "question<?php echo $currentQuestion ?><?php echo $tab_letter[$i] ?>"> <?php echo strtoupper($tab_letter[$i]) ?>: </label><a class="delete_choice btn btn-danger pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                <input class = "form-control" type = "text" name = "question<?php echo $currentQuestion ?><?php echo $tab_letter[$i] ?>" value="<?php echo htmlentities($choix->getLibelle()) ?>" />
                            </div>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                            <hr/>
                            <a class="more_choice btn btn-primary" href="#">Ajouter un choix</a>
                        </div>
                        <?php endif; ?>
                    </fieldset>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <div id="question"></div>


            <hr />
            <ul id="bottombar_create">
                <li>
                    <a class="btn btn-primary" href="#" id="add_question">Ajouter une question</a>
                </li>
                <li class="pull-right">
                    <input class="btn btn-success" type='submit' value='Enregistrer'/>
                </li>
            </ul>
        </form>
    </div>
</div>

<script src="../../assets/js/page_create.js"></script>
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/footer.php";
?>