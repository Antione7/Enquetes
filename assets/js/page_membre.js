
$(function(){

	var id_utilisateur = $("#my_account").attr("data-utilisateur");
	
	$("#my_account").on("submit","form", updateUtilisateur);

	$("#my_account_link").on("click", changeAccountData)

	$(".delete_enquete").on("click", deleteEnquete);
    
    var client = new ZeroClipboard( $(".copy_link") );

    client.on( "ready", function( readyEvent ) {

        client.on( "aftercopy", function( event ) {
            
            console.log("Copied text to clipboard: " + event.data["text/plain"] );
            alert("L'url est copiée dans le presse-papiers");
        
        } );
    } );

	function updateUtilisateur(event){
		event.preventDefault();
		var email = $("#my_account input[type=email]").val();
		var password = $("#my_account input[name=password]").val();
		var password2 = $("#my_account input[name=password2]").val();
		$.ajax({
			type:'POST',
			url:"../../controllers/backend/update_account_data.php",
			data:{
				"id_utilisateur":id_utilisateur,
				"email": email,
				"password": password,
				"password2": password2
			},
			dataType:'json'
		})
		.done(function(response){
			$("#message").html("");
			for(i=0; i<response.length; i++ ){
				
				if(response[i]==""){
					
					$("#message").append('<div class="alert alert-success error_info_message">Vos modifications ont bien été prises en compte</div>');
					break;
				} else {
					
					$("#message").append('<div class="alert alert-danger error_info_message">'+response[i]+'</div>');
				}
			}
		});
	}

	function changeAccountData(event){
		event.preventDefault();
		$("#message").html("");
        
        if($("#my_account_link").html()==="Mon compte"){
            $("#my_account_link").html("Retour");
            $.ajax({
                type:'POST',
                url:"../../controllers/backend/get_account_data.php",
                data:{
                    "id_utilisateur":id_utilisateur
                },
                dataType:'json'
            })
            .done(function(response){
                $("#my_account").html('');
                $("#my_account").html('<form action="#" method="POST"><div class="form-group"><label for="email">Changez votre email:</label><input class="form-control" type="email" name="email" value="'+response.email+'" /></div><div class="form-group"><label for="password">Tapez votre nouveau mot de passe:</label><input class="form-control" type="password" name="password" /></div><div class="form-group"><label for="password2">Retapez le mot de passe:</label><input class="form-control" type="password" name="password2" /></div><div class="form-group"><input class="btn btn-success pull-right" type="submit" value="Valider"/></div></form>');
                
            });
        } else if($("#my_account_link").html()==="Retour"){
            $("#my_account_link").html("Mon compte");
        };
        
        $("#my_account").slideToggle(1400);
		
	}

	function deleteEnquete(event){
		event.preventDefault();
		id_enquete = $(this).attr("data-enquete");
		context = $(this);
		$.ajax({
			url:'../../controllers/backend/delete_enquete_process.php?id='+id_enquete,
			context:context
		})
		.done(function(reponse){
			$(this).parent().parent().remove();
			$(".enquete-number").each(function(i){
				$(this).html(i+1);
			});
		})
		.fail(displayError);

	}

	function displayError(){
		console.log("Impossible de supprimer l'enquête");
	}
});