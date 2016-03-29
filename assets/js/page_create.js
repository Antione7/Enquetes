$(function(){
    var question;
    var button_question;
    var count_question = $(".number_question").length;
    var count_type_reponse = $(".number_question").length;
    var remove_question;
    var qcm;
    var block_qcm;
    var more_choice;
    var letters = ["a","b", "c", "d", "e", "f", "g", "h"];
    var delete_choice;

    //On récupère les boutons déjà existant qui supprime une question
    //Ce commentaire est utile pour l'édition de l'enquête: après l'exécution 
    //de la boucle qui récupérera les questions de l'enquête déjà existante
    remove_question = $(".remove_question");
    remove_question.on("click", removeQuestion);

    //On récupère les input radio qcm déjà existants: même loqique que précédemment 
    //pour l'édition de l'enquête c'est important(dans le cas de la création 
    //il n'y a que la première question qui est concerné
    qcm = $(".block input[type=radio]");
    qcm.on('change', addQcmSelection);

    //On récupère la div dans laquelle on va mettre les quesitons suivantes
    question = $("#question");

    //On récupère le bouton d'ajout de question
    button_question = $("#add_question");
    button_question.on("click", createNewQuestion);

    more_choice = $(".more_choice");
    more_choice.on("click", moreChoice);

    //delegated event sur tous les boutons delete_choice
    $("body").on("click", ".delete_choice", deleteChoice);

    function createNewQuestion(event) {

        event.preventDefault();

        //les compteurs sont initialisés au nombre de questions déjà présentes,  
        // on les incrémente lorsqu'on ajoute une question
        count_question++;
        count_type_reponse++;

        //On crée une div pour y mettre le contenu de la nouvelle question
        var block_question;
        block_question = $("<div>");
        block_question.addClass("block_question");
        block_question.html('<fieldset class="block">\n\
    <legend> Question n°<span class="number_question">' + count_question + '</span>: <a class="remove_question btn btn-danger pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></a></legend>\n\
    <label for = "libelle[]"> Libellé: </label>\n\
    <input class = "form-control" type = "text" name = "libelle[]" />\n\
    </br>\n\
    <p><strong>Type:</strong></p>\n\
    <label class = "radio-inline" >\n\
    <input type = "radio" name = "type'+count_type_reponse+'" value = "texte" checked /> Texte\n\
    </label>\n\
    <label class = "radio-inline" >\n\
    <input type = "radio" name = "type'+count_type_reponse+'" value = "nombre" /> Nombre\n\
    </label>\n\
    <label class = "radio-inline" >\n\
    <input type = "radio" name = "type'+count_type_reponse+'" value = "qcm" /> QCM\n\
    </label>\n\
    </fieldset>');

        //On ajoute la nouvelle question à la suite des autres
        question.append(block_question);

        //On récupère le dernier bouton qui supprime une question créée à partir 
        //du bouton ajout d'une question
        remove_question = $(".remove_question").last();
        remove_question.on("click", removeQuestion);

        //On récupère le dernier input radio qcm appartenant à une question créée 
        //à partir du bouton ajout d'une quesiton
        qcm = $(".block:last input[type=radio]");
        qcm.on('change', addQcmSelection);

    }

    function removeQuestion(event) {

        event.preventDefault();

        //On supprime le block_question dans lequel se trouve le bouton 
        //remove_question sur lequel l'utilisateur a appuyé

        $(this).parent().parent().parent().remove();
        count_question--;

        //On boucle pour ajuster les numéros des questions
        var number=0;
        var number_question = $(".number_question");
        number_question.each(function(){
           number++;
           $(this).html(number);
        });

    }

    function addQcmSelection(event) {

        event.preventDefault();


        if ($(this).val() === 'qcm') {

            block_qcm=$("<div>");
            block_qcm.addClass("block_qcm");
            block_qcm.html('<hr/><a class="more_choice btn btn-primary" href="#">Ajouter un choix</a>');
            block_qcm.css({
                "padding":"1em"
            });

            $(this).parent().parent().append(block_qcm);

            //On récupère le bouton pour ajouter plus de choix à la QCM
            more_choice = $(this).parent().siblings(".block_qcm").find(".more_choice");
            more_choice.on("click", moreChoice);
        } else {
            $(this).parent().parent().find(".block_qcm").remove();
        }
    }

    function moreChoice(event) {

        event.preventDefault();

        //On récupère le numéro de la question
        name_type_reponse = $(this).parent().parent().find("input[type='radio']").attr("name");
        numero_question = name_type_reponse.replace("type", "");

        //On récupère le nombre de choix déjà présent dans le DOM
        count_letter = $(this).parent().find(".choice").length;

        if(count_letter === 0){

            $(this).parent().prepend('<div class="choice"><label for = "question'+numero_question+letters[count_letter]+'"> '+letters[count_letter].toUpperCase()+': </label><a class="delete_choice btn btn-danger pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></a>\n\
    <input class = "form-control" type = "text" name = "question'+numero_question+letters[count_letter]+'" /></div>');

        } else if (count_letter >= 0 && count_letter < 7){

            $(this).parent().find(".choice").last().after('<div class="choice"><label for = "question'+numero_question+letters[count_letter]+'"> '+letters[count_letter].toUpperCase()+': </label><a class="delete_choice btn btn-danger pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></a>\n\
    <input class = "form-control" type = "text" name = "question'+numero_question+letters[count_letter]+'" /></div>');

        } else if(count_letter === 7){

            $(this).parent().find(".choice").last().after('<div class="choice"><label for = "question'+numero_question+letters[count_letter]+'"> '+letters[count_letter].toUpperCase()+': </label><a class="delete_choice btn btn-danger pull-right" href="#"><span class="glyphicon glyphicon-remove"></span></a>\n\
    <input class = "form-control" type = "text" name = "question'+numero_question+letters[count_letter]+'" /></div>');

            $(this).attr("disabled", true);

        }

    }

    function deleteChoice(event) {

        event.preventDefault();

        block_qcm = $(this).parent().parent();

        $(this).parent().remove();

        choices = block_qcm.find(".choice");

        if(choices.length === 7){
           block_qcm.find(".more_choice").attr("disabled", false); 
        }

        num_letter = 0;
        choices.each(function(){
            $(this).find("label").attr("for", "question"+numero_question+letters[num_letter]);
            $(this).find("input").attr("name", "question"+numero_question+letters[num_letter]);
            $(this).find("label").html(letters[num_letter].toUpperCase()+":");
        
            num_letter++;
        });

    }
});