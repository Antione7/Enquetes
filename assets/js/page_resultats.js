
$(function(){
	var question_id;
	
	$(".question_id").each(function(){
		question_id = $(this).attr("data-question-id");
		var id_graph = $(this).attr("id");

		$.ajax({
			type:"GET",
			url: "../../controllers/backend/qcm_data.php",
			data:{
				"question_id":question_id
			},
			dataType:'json'
		})
		.done(function(response){

			var chart = new CanvasJS.Chart(id_graph, {

		      title:{
		        text: ""              
		      },
		      data: [             
		        { 
		         type: "column",
		         dataPoints: response
		     	}
		         ]
		     });

	    	chart.render();
	    	
		});
	});
	
});