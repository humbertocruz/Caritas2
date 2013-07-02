$(document).ready(function(){
	var utimeout = 20*60;
	
	var utimeout_interval = window.setInterval(change_interval, 1000);
	
	function change_interval() {
		utimeout--;
		
		min = parseInt( utimeout / 60 );
		if (min < 10) min = '0' + min;
		sec = utimeout - ( min * 60 );
		if (sec < 10) sec = '0' + sec;
		
		$('#user_timeout').html(min + ':' + sec );
		
		if (utimeout == 0) {
			clearInterval( utimeout_interval );
			location.href = '/atendentes/logout';
		}
		
		$('#btn-forms-save-restore').click(function(){
			$('.form-save-restore').toggle();
		});
		
		$('.btn-form-save').click(function(){
			form_save($(this).parent().parent());
			return false;
		});
		$('.btn-form-restore').click(function(){
			form_restore($(this).parent().parent());
			return false;
		});
	}
		$( '.sr-form-bt' ).live('click', function() {
			/*
			form = $(this).parents('form');
			data = form.serializeArray();
			data = JSON.stringify(data);
			url = $(this).data('url');
			console.log(url);
			$.ajax({
			'type': 'post',
			'url': '/systems/guardaForm/'+form.attr('id'),
			'data': {'json':data},
			'success': function(data) {
				location.href = '/'+url;
			}
			});
			*/
			form = $(this).parents('form');
			url = $(this).data('url');
			$('#modal-saving-form').modal('show');
			form_save(form.attr('id'), url);
		});
});			
function create_options(data, key, value) {
	options = '<option value="0">Escolha uma opção</option>';
	jQuery.each(data, function(option) {
		options+= '<option value="'+eval( 'data[option]'+key )+'">'+eval( 'data[option]'+value )+'</option>';
	});
	return options;
}

function create_instituicoes(data) {
	institu = new Array();
	jQuery.each(data, function(option) {
		institu[data[option]['Cidade']['id']] = data[option]['InstituicoesEndereco'];
	});
	return institu;
}

function form_save(form, url) {
		form = $('#'+form);
		data = form.serializeArray();
		data = JSON.stringify(data);
		$.ajax({
			'type': 'post',
			'url': '/systems/guardaForm/'+form.attr('id'),
			'data': {'json':data},
			'success': function(data) {
				$('#modal-saving-form').modal('hide');
				if (typeof url !== 'undefined') {
					location.href = url;
				}
			}
		});
}

function form_del(form) {
	form = $('#'+form);
	$.ajax({
			'dataType':'json',
			'type': 'get',
			'url': '/systems/excluiForm/'+form.attr('id'),
			'success': function(data) {
				location.reload();
			}
		});
}

function form_restore(form) {
		form = $('#'+form);
		$.ajax({
			'dataType':'json',
			'type': 'get',
			'url': '/systems/restauraForm/'+form.attr('id'),
			'success': function(data) {
				allData = data;
				if ($('#instituicao_id_row').length > 0 ) {

					estado = data[5]['value'];
					cidade = data[6]['value'];
					instituicao = data[7]['value'];
					contato = data[8]['value'];

					$.post('/chamados/loadCidades', {'data[estado_id]':estado}, function(data){
						$('#instituicao_cidade').html(data).removeAttr('disabled');
						$.post('/chamados/loadInstituicoes', {'data[cidade_id]':cidade}, function(data){
							$('#instituicao_id').html(data).removeAttr('disabled');
							$.post('/chamados/loadContatos', {'data[instituicao_id]':instituicao}, function(data){
								$('#contato_id').html(data).removeAttr('disabled');
								form.deserialize(allData);
							});
							$.post('/chamados/loadContatosDetalhes', {'data[instituicao_id]':instituicao}, function(data){
								$('#contatos-detalhes').html(data).removeAttr('disabled');
								$('#contato-table-'+contato).show();
							});
							$.post('/chamados/loadHistoricos', {'data[instituicao_id]':instituicao}, function(data){
								$('#chamados-table').html(data);
								$('#modal-loading-form').modal('hide');
							});
						});
					});
					
				}
			}
		});
}
