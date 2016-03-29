<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/displaymessage.php";
require_once $_SERVER['DOCUMENT_ROOT']."/include/header.php";
?>

<div class="container">

    <div class="row">
        <h1 class="text-center">
           Les enquêtes
        </h1>
    </div>

    <div class="row message">
      <?php echo $message;?>
    </div>             

    <div class="row border-enquete">

      <h3>Formulaire de connexion</h3>

      <form action="../../controllers/frontend/authentification.php" method="POST">
          <div class="form-group">
            <label for="email">Email:</label>
            <input class="form-control" type="email" name="email" />
          </div>
          <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input class="form-control" type="password" name="password" />
          </div>
          <div class="form-group">
            <input class="btn btn-success pull-right" type='submit' value='Valider'/>
          </div>
      </form>

    </div>

    <div class="row border-enquete">

      <h3>Formulaire d'inscription</h3>

      <form action="../../controllers/frontend/inscription.php" method="POST">
        <div class="form-group">
        <label for="email">Tapez votre email:</label>
        <input class="form-control" type="email" name="email" />
        </div>
        <div class="form-group">
        <label for="password">Tapez un mot de passe:</label>
        <input class="form-control" type="password" name="password" />
        </div>
        <div class="form-group">
        <label for="password2">Retapez le mot de passe:</label>
        <input class="form-control" type="password" name="password2" />
        </div>
        <div class="form-group">
        <input class="btn btn-danger pull-right" type='submit' value='Valider'/>
        </div>
      </form>

    </div> 

</div>
        
<?php
require_once $_SERVER['DOCUMENT_ROOT']."/include/footer.php";
?>
