$(document).ready(function(){

	$('#arrow').click(function(){
		$('.dmenu').slideUp(125, function(){
			$('.smenu').slideToggle(125);
		});
	});

	$('#aarrow').click(function(){
		$('.smenu').slideUp(125, function(){
			$('.dmenu').slideToggle(125);
		});
	});

	$('#search').submit(function(event){
		if($('#input').val()==''){
			event.preventDefault()
		}
	});

});