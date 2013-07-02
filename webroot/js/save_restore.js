$(document).ready(function(){
	$('.btn-form-save').click(function(){
		form = $(this).parents('form');
		data = form.serializeArray();
		data = JSON.stringify(data);
		console.log(data);
		$.ajax({
			'type': 'post',
			'url': '/systems/guardaForm/'+form.attr('id'),
			'data': {'json':data},
			'success': function(data) {
				console.log(data);
			}
		});
	});
	
	$('.btn-form-restore').click(function(){
		form = $(this).parents('form');
		$.ajax({
			'dataType':'json',
			'type': 'get',
			'url': '/systems/restauraForm/'+form.attr('id'),
			'success': function(data) {
				console.log('Falta criar um codigo para chamar os dados dos combos cidade, instituicao e contato');
				form.deserialize(data);
			}
		});
	});
});