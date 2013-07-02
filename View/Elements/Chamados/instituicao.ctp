<div class="row" id="<?php echo $field.'_row';?>">
	<div class="span1"><?php echo $this->TB->input('Chamado.instituicao_estado_id',array('label'=>'Estado','class'=>'span1','options'=>array($estados))); ?>
</div>
	<div class="span2"><?php echo $this->TB->input('Chamado.instituicao_cidade_id',array('label'=>'Cidade','disabled'=>'disabled','title'=>'Selecione o Estado','class'=>'span2','options'=>array())); ?>
</div>
	<div class="span3"><?php echo $this->TB->input($field, array('label'=>'Instituição','disabled'=>'disabled','title'=>'Selecione o Município','class'=>'span3','options'=>array())); ?></div>
</div>
<script>
$(document).ready(function(){
	row = $('#<?php echo $field.'_row';?>');
	row.find('#ChamadoInstituicaoEstadoId').change(function(){
		row.find('#ChamadoInstituicaoCidadeId').html('').removeAttr('title').attr('disabled','disabled').popover({'trigger':'manual','placement':'top','content':'Carregando Cidades...','title':'Aguarde'}).popover('show');
		row.find('#instituicao_id').html('').removeAttr('title').attr('disabled','disabled');
		$('#contato_id').html('').removeAttr('title').attr('disabled','disabled');
		$('#contatos-detalhes').html('');
		$.ajax({
			'url':'/chamados/loadCidades',
			'type':'post',
			'dataType':'html',
			'data':{'data':{'estado_id':$(this).val()}},
			'success':function(data) {
				row.find('#ChamadoInstituicaoCidadeId').html(data).removeAttr('disabled').popover('hide').attr('title','Selecione a Cidade');
			}
		});
	});
	
	row.find('#ChamadoInstituicaoCidadeId').change(function(){
		row.find('#instituicao_id').html('').removeAttr('title').attr('disabled','disabled').popover({'trigger':'manual','placement':'top','content':'Carregando Instituições...','title':'Aguarde'}).popover('show');
		$('#contato_id').html('').removeAttr('title').attr('disabled','disabled');
		$('#contatos-detalhes').html('');
		$.ajax({
			'url':'/chamados/loadInstituicoes',
			'type':'post',
			'dataType':'html',
			'data':{'data':{'cidade_id':$(this).val()}},
			'success':function(data) {
				row.find('#instituicao_id').html(data).removeAttr('disabled').popover('hide').attr('title','Selecione a Instituição');
			}
		});
	});
	
	row.find('#instituicao_id').change(function(){
		$('#contato_id').html('').removeAttr('title').attr('disabled','disabled').popover({'trigger':'manual','placement':'top','content':'Carregando Contatos...','title':'Aguarde'}).popover('show');
		$('#chamados-table').html('').removeAttr('title').attr('disabled','disabled').popover({'trigger':'manual','placement':'top','content':'Carregando Hitórico...','title':'Aguarde'}).popover('show');
		$('#contatos-detalhes').html('');
		
		$.ajax({
			'url':'/chamados/loadContatos',
			'type':'post',
			'dataType':'html',
			'data':{'data':{'instituicao_id':$(this).val()}},
			'success':function(data) {
				$('#contato_id').html(data).removeAttr('disabled').popover('hide').attr('title','Selecione o Contato');
			}
		});
		$.ajax({
			'url':'/chamados/loadContatosDetalhes',
			'type':'post',
			'dataType':'html',
			'data':{'data':{'instituicao_id':$(this).val()}},
			'success':function(data) {
				$('#contatos-detalhes').html(data);
			}
		});
		$.ajax({
			'url':'/chamados/loadHistoricos',
			'type':'post',
			'dataType':'html',
			'data':{'data':{'instituicao_id':$(this).val()}},
			'success':function(data) {
				$('#chamados-table').html(data).removeAttr('disabled').popover('hide').attr('title','Selecione o Contato');
			}
		});
	});
	$('#contato_id').change(function(){
		$('.contato-table').hide();
		$('#contato-table-'+$(this).val()).show();
	});
});
</script>

