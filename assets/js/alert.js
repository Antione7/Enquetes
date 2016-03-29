$(function(){
    
    $(".message").on("click", deleteMessage);
    
    function deleteMessage(event){
        
        event.preventDefault();
        
        $(".message").animate({
            opacity:"0",
            height:"0"
        }, 400, function(){
            $(this).remove();
        });
        
    }
    
});