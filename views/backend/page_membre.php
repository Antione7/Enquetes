<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/check_session.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/displaymessage.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/header.php";
?>
<div class="container">
    <div class="row">
        <h1 class="text-center">
           Page Membre
        </h1>
    </div>
    
    <div class="row" id="message"></div>

    <div class="row message">
        <?php echo $message;?>
    </div>

    <?php
    $sessionManager = new Manager\SessionManager();
    $id_utilisateur = $sessionManager->id_utilisateur;
    ?>

    <div class="row menu-member">
    <a href="#" id="my_account_link" class="btn btn-primary">Mon compte</a>
    <a href="page_create.php" id="create_link" class="btn btn-success">Créer une nouvelle enquête</a>
    <a href="../../controllers/backend/logout.php" class="btn btn-danger">Déconnexion</a>
    <span class="glyphicon glyphicon-user pull-right">&nbsp;<?php echo htmlentities($sessionManager->email) ?></span>
    </div>
    <div id="my_account" data-utilisateur="<?php echo $id_utilisateur ?>" class=" row border-enquete"></div>
    <div id="mes_enquetes">
      <?php

      $enqueteManager = new Manager\EnqueteManager();
      $tab_enquete = $enqueteManager->selectAllByUserId($id_utilisateur);

      $currentEnquete = 0;

      foreach ($tab_enquete as $enquete):?>
        <?php $currentEnquete++ ?>
        <div class="row border-enquete">
            <h3>Enquête n°<span class="enquete-number"><?php echo $currentEnquete ?></span>: <?php echo htmlentities($enquete->getTitre()) ?></h3>
            <div class="bouton-enquete row">
                <a class="btn btn-primary twentytwo" href="../backend/page_preview.php?id=<?php echo $enquete->getId() ?>">Voir l'enquête</a>
                <a class="btn btn-warning twentytwo" href="page_create.php?id=<?php echo $enquete->getId() ?>">Modifier l'enquête</a>
                <a class="btn btn-danger twentytwo delete_enquete" data-enquete="<?php echo $enquete->getId() ?>" href="#">Supprimer l'enquête</a>
                <a class="btn btn-info twentytwo" href="page_resultats.php?id=<?php echo $enquete->getId() ?>">Voir les résultats</a>
            </div>
            <br/>
            <div class="row">
                <div class="col-lg-11 col-lg-offset-1">
                <p>Url du répondant: enquete.local/views/frontend/page_reponse.php?id=<?php echo $enquete->getId() ?>&nbsp;<btn class="btn btn-default copy_link" data-clipboard-text="enquete.local/views/frontend/page_reponse.php?id=<?php echo $enquete->getId() ?>">Copier le lien</btn></p>
                
                </div>
            </div>
        </div>
      <?php endforeach; ?>

    </div>
</div>

<script src="../../assets/js/ZeroClipboard.min.js"></script>
<script src="../../assets/js/page_membre.js"></script>

<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/footer.php";
?>