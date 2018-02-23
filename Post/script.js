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

	$('.dbminus, .dbplus').click(function(){
		var $box = this;
		var $id = $('[name="poster"]').val();
		if(this.className == 'dbplus'){
			var $l = 1;
		}
		else
			var $l = 0;
		$.post( "db.php", { id: $id, l: $l }, function(data){
		$($box).parent().remove();
		});
		return false;
	});
	
	$('#cboxh').on('click','.cbutton', function(){
		$.post('loader.php', $('#load').serialize(), function(data){
			$('#bcont').parent().remove();
			$('#cboxh').append(data);
		});
		return false;
	});

	$('#cboxh').on('click', '.plus', function(){
		var cid1 = this;
		var fdr1 = $(this).closest('#clike');
		var poster1 = fdr1.find("[name='poster']").val();
		var id1 = fdr1.find("[name='id']").val();
		var r1 = fdr1.find("[name='rater']").val();
		
		$.post('like.php', {poster1, id1, r1}, function(data){
			$(cid1).parent().nextAll('(.rtctext):first').find('.rtctext').text(data);
		});
		return false;
	});

	$('#cboxh').on('click', '.minus', function(){
		var cid2 = this;
		var fdr2 = $(this).closest('#clike');
		var poster2 = fdr2.find("[name='poster']").val();
		var id2 = fdr2.find("[name='id']").val();
		var r2 = fdr2.find("[name='rater']").val();
		
		$.post('dislike.php', {poster2, id2, r2}, function(data){
			$(cid2).parent().nextAll('(.rtctext):first').find('.rtctext').text(data);
		});
		return false;
	});

	$('#cboxh').on('click', '.cross', function(){	
		var cont = $(this).closest('#sbcont');
		var idx = $(this).closest('#clike');
		var poster = idx.find("[name='poster']").val();
		var id = idx.find("[name='id']").val();
	
		$.post('delete.php', {poster, id}, function(data){
			cont.remove();
			alert(data);
		});
		return false;
	});	

});