<div class="form-actions">
	<a href="/chamadas/add/0/<?php echo $this->data['Pedido']['id'];?>" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova Chamada</a>
</div>

<table class="table table-bordered">
	<thead>
	<tr class="alert-info">
		<th>Início</th>
		<th>Assunto</th>
		<th>Solicitação</th>
		<th class="span3">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($this->data['Chamada'] as $row) { ?>
	<tr>
		<td><?php echo $this->Bootstrap->br( $row['data_inicio'] );?></td>
		<td><?php echo $row['Assunto']['nome'];?></td>
		<td><?php echo $row['solicitacao'];?></td>
		<td>
			<a href="/chamadas/view/<?php echo $row['id'].'/'.$this->data['Pedido']['id'];?>" rel="tooltip" title="Ver Detalhes" class="btn"><i class="icon-th-list"></i></a>
			<a href="/chamadas/edit/<?php echo $row['id'].'/'.$this->data['Pedido']['id'];?>" rel="tooltip" title="Editar Chamada" class="btn"><i class="icon icon-pencil"></i></a>
			<?php if ($row['data_fim'] == null) { ?>
				<a href="#FimModal" data-toggle="modal" data-id="<?php echo $row['id'];?>" data-fim-info="<?php echo $row['id'].' - '.$row['solicitacao']; ?>" rel="tooltip" title="Finalizar Chamada" class="btn btn-warning fimBtn btnConfirm"><i class="icon-lock icon-white"></i></a>
				<?php } else { ?>
				<a href="#" rel="tooltip" title="Chamada Finalizada em <?php echo date('d/m/Y',strtotime($row['data_fim']));?>" class="btn btn-warning disabled"><i class="icon-lock icon-white"></i></a>
				<?php } ?>
				<?php if (count($row['ChamadasFilha']) == 0 and count($row['ChamadasProcedimento']) == 0) { ?>
				<a href="#delModal" data-del-info="<?php echo $row['id'].' - '.$row['solicitacao']; ?>" data-id="<?php echo $row['id']; ?>" data-toggle="modal" class="btn btn-danger delBtn" rel="tooltip" title="Excluir"><i class="icon-trash icon-white"></i></a>
				<?php } else { ?>
				<a href="#" class="btn btn-danger disabled" rel="tooltip" title="Não é possível Excluir"><i class="icon-trash icon-white"></i></a>
				<?php } ?>
				<?php if ($row['chamada_id'] == 0) { ?>
				<a href="/chamadas/add/<?php echo $row['id'].'/'.$this->data['Pedido']['id']; ?>" rel="tooltip" title="Adicionar Chamada Relacionada" class="btn btn-primary"><i class="icon-plus icon-white"></i></a>
				<?php } ?>
				<?php if (count($row['ChamadasFilha']) > 0) { ?>
				<a href="#" rel="tooltip" title="Chamadas Relacionadas" class="btn btn-success"><?php echo count($row['ChamadasFilha']); ?><i class="btn-th-list"></i></a>
				<?php } ?>
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
		<div id="modal-del-info" class="alert alert-danger"></div>
		<br>
		Tem certeza ?
	</div>
	<div class="modal-footer">
		<form method="post" action="/<?php echo $controller.'/del/'.$this->data['Pedido']['id'];?>">
		<input id="modal-id" type="hidden" name="data[Chamada][id]" value="0">
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
	<form method="post" action="/chamadas/finalizar/<?php echo $this->data['Pedido']['id'];?>';?>">
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
<div class="form-actions">
	<a href="/chamadas/add/0/<?php echo $this->data['Pedido']['id'];?>" class="btn btn-primary"><i class="icon-plus icon-white"></i> Nova Chamada</a>
</div>