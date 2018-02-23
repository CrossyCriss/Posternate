$(document).ready(function(){

	$('.hidden').hide();

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

		$('.toggle').click(function(){
			if ($(this).next().is(':hidden')){
				$('.hidden').hide();
				$(this).next().toggle();
			}else{
				$(this).next().hide();
			}
		});
		
		$('#mcheck').click(function(){
			if($('#mcheck').is(':checked')){
				$(".check").prop("checked", true);
			}else{
				$(".check").prop("checked", false);
			}
		});
		
		$(".check").change(function(){
			if($('.check:checked').length == $('.check').length){
				$("#mcheck").prop("checked", true);
			}else{
				$("#mcheck").prop("checked", false);
			}
		});

		$('#search').submit(function(event){
			if($('#input').val()==''){
				event.preventDefault()
			}
		});

});