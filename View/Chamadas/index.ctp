<div class="page-header clearfix">
	<h2><?php echo $header; ?></h2>
</div>
<?php
// Filtros
$sess_status_id = (isset( $filters_sess['status_id'] ) )?($filters_sess['status_id']):('0');
$sess_atendente_id = (isset( $filters_sess['atendente_id'] ) )?($filters_sess['atendente_id']):('0');

?>
<div class="row">
	<div class="span12">
		<form method="post" class="form-inline">
			<input type="hidden" name="data[filter][clear]" value="0" class="filter_clear_fld">
			<select name="data[filter][status_id]">
				<option value="0">Todos</option>
				<?php foreach($filters['status'] as $stat) { ?>
					<option <?php if ($stat['Status']['id'] == $sess_status_id) echo 'selected';?> value="<?php echo $stat['Status']['id'];?>"><?php echo $stat['Status']['nome'];?></option>
				<?php } ?>
			</select>
			<select name="data[filter][atendente_id]">
				<option value="0">Todos</option>
				<?php foreach($filters['atendentes'] as $atendente) { ?>
					<option <?php if ($atendente['Atendente']['id'] == $sess_atendente_id) echo 'selected';?>  value="<?php echo $atendente['Atendente']['id'];?>"><?php echo $atendente['Atendente']['nome'];?></option>
				<?php } ?>
			</select>
			<?php
			$search_value = ($this->Session->check('filter'))?($this->Session->read('filter')):(array());
			if (isset($search_value['search'])) $search_value = $search_value['search']; else $search_value = '';
			?>
			
			<input name="data[filter][search]" type="text" placeholder="pesquise..." class="span3" value="<?php echo $search_value;?>">
			<input type="submit" class="btn" value="Pesquisar">
			<input onclick="$('.filter_clear_fld').val(1);" type="submit" class="btn" value="Limpar">
		</form>
	</div>
</div>
<div class="form-actions">
	<a href="/chamadas/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova Chamada</a>
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
			<th class="span1">&nbsp;</th>
			<th class="span3">Institução / Fornecedor</th>
			<th class="span1">UF</th>
			<th class="span2">Contato</th>
			<th class="span1">Início</th>
			<th class="span2">Assunto</th>
			<th class="span2">Solicitação</th>
		</tr>
	</thead>
	<tbody>
		<?php
		//pr($data_index); 
		foreach ($data_index as $row) { ?>
		<tr>
			<td>
				<div class="btn-group">
					<a class="btn" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon icon-wrench"></i>&nbsp;<span class="caret"></span></a>
				<ul class="dropdown-menu">
				<li><a href="/chamadas/view/<?php echo $row['Chamada']['id'];?>" rel="tooltip" title="Ver Detalhes"><i class="icon-th-list"></i>&nbsp;Ver</a></li>
				<li><a href="/chamadas/edit/<?php echo $row['Chamada']['id'];?>" rel="tooltip" title="Editar"><i class="icon-pencil"></i>&nbsp;Editar</a></li>
				<?php if ($row['Chamada']['data_fim'] == null) { ?>
				<li><a href="#FimModal" data-toggle="modal" data-id="<?php echo $row[$model]['id'];?>" data-fim-info="<?php echo $row['Chamada']['id'].' - '.$row['Chamada']['solicitacao']; ?>" rel="tooltip" title="Finalizar Chamada" class="fimBtn btnConfirm"><i class="icon-lock"></i>&nbsp;Finalizar</a></li>
				<?php } else { ?>
				<li><a rel="tooltip" title="Chamada Finalizada em <?php echo date('d/m/Y',strtotime($row['Chamada']['data_fim']));?>" class="disabled"><i class="icon-lock"></i>&nbsp;Finalizada</a></li>
				<?php } ?>
				<?php if (count($row['ChamadasFilha']) == 0 and count($row['ChamadasProcedimento']) == 0) { ?>
				<li><a href="#delModal" data-del-info="<?php echo $row['Chamada']['id'].' - '.$row['Chamada']['solicitacao']; ?>" data-id="<?php echo $row[$model]['id']; ?>" data-toggle="modal" class="delBtn" rel="tooltip" title="Excluir"><i class="icon-trash"></i>&nbsp;Excluir</a></li>
				<?php } else { ?>
				<li><a class="disabled" rel="tooltip" title="Não é possível Excluir"><i class="icon-trash"></i>&nbsp;Não é possível excluir</a></li>
				<?php } ?>
				<?php if ($row['Chamada']['chamada_id'] == 0) { ?>
				<li><a href="/chamadas/add/<?php echo $row['Chamada']['id']; ?>" rel="tooltip" title="Adicionar Chamada Relacionada"><i class="icon-plus"></i>&nbsp;Adicionar Chamada Relacionada</a></li>
				<?php } ?>
				<?php if (count($row['ChamadasFilha']) > 0) { ?>
				<li><a href="#" rel="tooltip" title="Chamadas Relacionadas"><?php echo count($row['ChamadasFilha']); ?><i class="btn-th-list"></i></a>&nbsp; Chamadas relacionadas</li>
				<?php } ?>
				</ul>
				</div>
			</td>
			<td>
			<?php if ($row['Chamada']['instituicao_id'] != null) { echo $row['Instituicao']['nome_fantasia']; } ?>
			<?php if ($row['Chamada']['fornecedor_id'] != null) {  echo $row['Fornecedor']['nome_fantasia']; } ?>
			&nbsp;</td>
			<td>
			<?php if ($row['Chamada']['instituicao_id'] != null) echo $row['Instituicao']['InstituicoesEndereco'][0]['Cidade']['estado_id'];?>
			<?php if ($row['Chamada']['fornecedor_id'] != null) echo $row['Fornecedor']['FornecedoresEndereco'][0]['Cidade']['estado_id'];?>
			</td>
			<td><?php echo $row['Contato']['nome'];?></td>
			<td><?php echo date('d/m/Y H:i', strtotime( $row['Chamada']['data_inicio']) ); ?></td>
			<td><?php echo $row['Assunto']['nome'];?></td>
			<td><?php echo $row['Chamada']['solicitacao'];?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<div class="modal fade hide" id="delModal">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Confirmação</h3>
	</div>
	<div class="modal-body">
		Excluindo registro de <?php echo $header;?><br><br>
		<div id="modal-del-info" class="alert alert-danger"></div>
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
<div class="modal fade hide" id="FimModal">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Confirmação</h3>
	</div>
	<form method="post" action="/<?php echo $controller.'/finalizar/';?>">
	<div class="modal-body">
		Finalizar registro de <?php echo $header;?><br><br>
		<div id="fim-modal-fim-info" class="alert alert-danger"></div>
		<br>
		<div class="control-group">
			<label class="control-label">Data Finalização</label>
			<div class="controls">
				<input name="data[Chamada][data_fim]" type="text" readonly="readonly" class="span2" value="<?php echo date('d/m/Y H:i:s'); ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Status</label>
			<div class="controls">
				<select name="data[Chamada][status_id]" class="span2">
					<?php foreach ($belongsToArray['Status'] as $key=>$value) { ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		Tem certeza ?
	</div>
	<div class="modal-footer">
		<input id="fim-modal-id" type="hidden" name="data[<?php echo $model;?>][id]" value="0">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<input type="submit" class="btn btn-danger" value="Finalizar">
	</div>
	</form>
</div>
<script>
$(document).ready(function() {
	$('.delBtn').click(function() {
		$('#modal-id').val($(this).data('id'));
		$('#modal-del-info').html($(this).data('del-info'));
	});
	$('.fimBtn').click(function() {
		$('#fim-modal-id').val($(this).data('id'));
		$('#fim-modal-fim-info').text($(this).data('fim-info'));
	});
});
</script>
<?php } ?>
<div class="form-actions">
	<a href="/chamadas/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova Chamada</a>
</div>
