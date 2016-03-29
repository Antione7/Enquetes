$(function(){

    $("body").on("click", ".help_answer", function(event){

        event.preventDefault();
        if($(this).parent().find(".help_content").length === 0){
            help_content = $("<div>");
            help_content.addClass("help_content");
            help_content.css({
                "background-color":"grey",
                "border":"1px solid black",
                "border-radius":"5px",
                "color":"orange",
                "text-align":"center",
                "height":"40px",
                "line-height":"40px",
                "padding-left":"5px",
                "padding-right":"5px",
                "display":"none",
                "cursor":"pointer"
            });
            help_content.html('<p>Veuillez indiquer un nombre pour répondre à cette question</p>');
            $(this).after(help_content);       
        }

        $(this).parent().find(".help_content").slideToggle(800);

    });
    
    $("body").on("click", ".help_content", function(){
        $(this).slideUp(800);
        console.log($(this));
    });
});