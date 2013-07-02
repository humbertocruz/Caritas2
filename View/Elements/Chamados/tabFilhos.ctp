<div class="page-header clearfix">
	<h2>Chamadas Filhas</h2>
</div>
<div class="form-actions">
	<a href="/chamadas/add/<?php echo $this->data['Chamada']['id'];?>" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova Chamada Filha</a>
</div>
<?php if (count($hasMany['ChamadasFilha']) == 0) { ?>
<div class="alert alert-warning">
	Nenhuma chamada filha!
</div>
<?php } else { ?>
<table class="table table-striped">
	<thead>
		<tr class="alert-info">
			<th>Institução / Fornecedor</th>
			
			<th>Contato</th>
			<th>Início</th>
			<th>Assunto</th>
			<th>Solicitação</th>
			<th class="span4">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($hasMany['ChamadasFilha'] as $row) { ?>
		<tr>
			<td>
			<?php if ($row['ChamadasFilha']['instituicao_id'] != null) { echo $row['Instituicao']['nome_fantasia']; } ?>
			<?php if ($row['ChamadasFilha']['fornecedor_id'] != null) {  echo $row['Fornecedor']['nome_fantasia']; } ?>
			&nbsp;</td>
			<td><?php echo $row['Contato']['nome'];?></td>
			<td><?php echo date('d/m/Y H:i', strtotime( $row['ChamadasFilha']['data_inicio']) ); ?></td>
			<td><?php echo $row['Assunto']['nome'];?></td>
			<td><?php echo $row['ChamadasFilha']['solicitacao'];?></td>
			<td>
				<a href="/chamadas/view/<?php echo $row['ChamadasFilha']['id'];?>" rel="tooltip" title="Ver Detalhes" class="btn"><i class="icon-th-list"></i></a>
				<a href="/chamadas/edit/<?php echo $row['ChamadasFilha']['id'];?>" rel="tooltip" title="Editar" class="btn"><i class="icon-pencil"></i></a>			
				
				<?php if (empty($row['ChamadasFilha']['data_fim'])) { ?>
				<a href="#FimModal" data-toggle="modal" data-id="<?php echo $row['ChamadasFilha']['id'];?>" data-fim-info="<?php echo $row['ChamadasFilha']['id'].' - '.$row['ChamadasFilha']['solicitacao']; ?>" rel="tooltip" title="Finalizar Chamada" class="btn btn-danger fimBtn btnConfirm"><i class="icon-lock icon-white"></i></a>
				<?php } ?>
				<a href="#delModal" data-del-info="<?php echo $row['ChamadasFilha']['id'].' - '.$row['ChamadasFilha']['solicitacao']; ?>" data-id="<?php echo $row['ChamadasFilha']['id']; ?>" data-toggle="modal" class="btn delBtn" rel="tooltip" title="Excluir"><i class="icon-trash"></i></a>
				
			</td>
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
<div class="modal fade hide" id="FimModal">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Confirmação</h3>
	</div>
	<form method="post" action="/<?php echo $controller.'/finalizar/';?>">
	<div class="modal-body">
		Finalizar registro de <?php echo $header;?><br><br>
		<span id="fim-modal-fim-info" class="label label-important"></span><br>
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
					<?php foreach ($status as $stat) { ?>
						<option value="<?php echo $stat['Status']['id']; ?>"><?php echo $stat['Status']['nome']; ?></option>
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
		$('#fim-modal-fim-info').html($(this).data('fim-info'));
	});
});
</script>
<?php } ?>
<div class="form-actions">
	<a href="/chamadas/add/<?php echo $this->data['Chamada']['id'];?>" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova Chamada Filha</a>
</div>
