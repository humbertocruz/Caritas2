<div class="page-header clearfix">
	<h2><?php echo $header; ?></h2>
</div>
<form method="post" class="form-inline">
<div class="row">
	<div class="span12">
		<input type="hidden" name="data[ped_filter][clear]" value="0" class="filter_clear_fld">
		<select name="data[ped_filter][status_id]">
			<option value="0">Todos os Status</option>
			<?php foreach($status as $key=>$val) { ?>
			<option <?php echo ($key == $filters['status_id'])?('selected="selected"'):(''); ?> value="<?php echo $key;?>"><?php echo $val;?></option>
			<?php } ?>
		</select>
		<select name="data[ped_filter][estado_id]" class="span1" id="search_estado">
			<option value="0">Todas</option>
			<?php foreach($estados as $key=>$val) { ?>
			<option <?php echo ($key === $filters['estado_id'])?('selected="selected"'):(''); ?> value="<?php echo $key;?>"><?php echo $val;?></option>
			<?php } ?>
		</select>
		<select name="data[ped_filter][cidade_id]" id="search_cidade">
			<option value="0">Todas</option>
			<?php foreach($cidades as $key=>$val) { ?>
			<option <?php echo ($key == $filters['cidade_id'])?('selected="selected"'):(''); ?> value="<?php echo $key;?>"><?php echo $val;?></option>
			<?php } ?>
		</select>
		<select name="data[ped_filter][tipos_pagamento_id]">
			<option value="0">Todos Tipos Pagamento</option>
			<?php foreach($tipos_pagamento as $key=>$val) { ?>
			<option <?php echo ($key == $filters['tipos_pagamento_id'])?('selected="selected"'):(''); ?> value="<?php echo $key;?>"><?php echo $val;?></option>
			<?php } ?>
		</select>
	</div>
</div>
<div class="row">
	<div class="span12">
		<input name="data[ped_filter][data_inicio]" rel="date" data-date-format="dd/mm/yyyy" data-date="<?php echo $filters['data_inicio'];?>" type="text" placeholder="Data Inicial" class="span2" value="<?php echo $filters['data_inicio'];?>">
		<input name="data[ped_filter][data_fim]" rel="date" data-date-format="dd/mm/yyyy" data-date="<?php echo $filters['data_fim'];?>" type="text" placeholder="Data Fim" class="span2" value="<?php echo $filters['data_fim'];?>">
		<input name="data[ped_filter][instnome]" type="text" placeholder="Instituição" class="span2" value="<?php echo $filters['instnome'];?>">

		<input type="hidden" name="data[ped_filter][clear_filter]" class="filter_clear_fld" value="0">
		<input type="submit" class="btn pull-right" value="Pesquisar">
		<input onclick="$('.filter_clear_fld').val(1);" type="submit" class="btn pull-right" value="Limpar">
	</div>
</div>
</form>
<div class="form-actions">
	<a href="/<?php echo $controller; ?>/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> <?php echo $header; ?></a>
</div>

<?php 
if (isset($this->Paginator) ) { 
	$params = $this->Paginator->request->params;
	echo $this->Element('Tables/paginator', array('params'=>$params));
} 
?>
<?php if (count($data_index) == 0) { ?>
<div class="alert alert-warning">
	Nenhum registro no Banco de Dados!
</div>
<?php } else { ?>
<table class="table table-striped">
	<thead>
		<tr class="alert-info">
			<th><?php echo $this->Paginator->sort( 'Instituicao.InstituicoesEndereco.Cidade.id', 'UF' ); ?></th>
			<th><?php echo $this->Paginator->sort( 'Instituicao.razaosocial', 'Instituição' ); ?></th>
			<th>Edital</th>
			<th>Convênio</th>
			<th><?php echo $this->Paginator->sort( 'TiposPagamento.nome', 'Forma de Pagamento' ); ?></th>
			<th>Valor Total</th>
			<th>Qtd. Itens</th>
			<th>Qtd. Chamadas</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	 foreach ($data_index as $row) {
		 $valor_pedido = 0;
		 foreach($row['PedidosItem'] as $item) {
			 $valor_pedido+=$item['Item']['valor'];
		 }
	 ?>
		<tr>
			<td><?php echo $row['Instituicao']['InstituicoesEndereco'][0]['Cidade']['estado_id']; ?></td>
			<td><?php echo $row['Instituicao']['razao_social']; ?></td>
			<td><?php echo $row['Edital']['numero'];?></td>
			<td><?php echo $row['Convenio']['num_convenio'];?></td>
			<td><?php echo $row['TiposPagamento']['nome']; ?></td>
			<td style="text-align: right;"><?php echo number_format($valor_pedido, 2, ',','.'); ?></td>
			<td><?php echo count( $row['PedidosItem'] ); ?></td>
			<td><?php echo count( $row['Chamada'] ); ?></td>
			<td>
				<a href="#detModal" data-id="<?php echo $row['Pedido']['id'];?>" class="btn detBtn" rel="tooltip" title="Detalhes"><i class="icon-eye-open"></i></a>
				<a href="/<?php echo $controller;?>/edit/<?php echo $row[$model]['id'];?>" class="btn" rel="tooltip" title="Editar"><i class="icon-pencil"></i></a>
				<a href="#delModal" data-del-info="<?php echo $row['Instituicao']['razao_social']; ?>" data-id="<?php echo $row['Pedido']['id']; ?>" data-toggle="modal" class="btn delBtn" rel="tooltip" title="Excluir"><i class="icon-trash"></i></a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<div class="form-actions">
	<a href="/<?php echo $controller; ?>/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> <?php echo $header; ?></a>
	<?php if ($this->Session->read('do_belongsTo')) { ?>
	<a href="/systems/back" class="btn btn-info" id="btn-backsel"><i class="icon-arrow-left icon-white"></i> Selecionar e Voltar</a>
	<?php } ?>
</div>
<div class="modal fade hide" id="delModal">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Confirmação</h3>
	</div>
	<div class="modal-body">
		Excluindo registro de <?php echo $header;?><br><br>
		<span id="modal-del-info" class="label label-important"></span><br>
		<br>
		Tem certeza ?
	</div>
	<div class="modal-footer">
		<form method="post" action="/<?php echo $controller.'/del/';?>">
		<input id="modal-id" type="hidden" name="data[<?php echo $model;?>][id]" value="0">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<input type="submit" class="btn btn-danger" value="Apagar">
		</form>
	</div>
</div>
<div class="modal fade hide span10" id="detModal" style="margin-left: -510px;">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Detalhes do Pedido</h3>
	</div>
	<div class="modal-body">
	
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.detBtn').click(function(){
		$.ajax({
			url: '/pedidos/view/'+$(this).data('id'),
			success: function(data){
				$('#detModal .modal-body').html(data);
				$('#detModal').modal('show');
			}
		});
	});
	$(':input[rel=date]').datepicker();
	$('.delBtn').click(function(){
		$('#modal-id').val($(this).data('id'));
		$('#modal-del-info').html($(this).data('del-info'));
	});
	$('.id_belongsTo').click(function(){
		$('#btn-backsel').attr('href','/systems/back/'+$(this).val());
	});
	$('#search_estado').change(function() {
		$.ajax({
			url: '/systems/cidade/'+$(this).val(),
			success: function(data) {
				$('#search_cidade').html(data);
			}
		});
	});
});
</script>
