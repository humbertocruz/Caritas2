<div class="page-header clearfix">
	<div class="row">
		<form method="post" class="form-inline pull-right">
		<div class="span2"><h2><?php echo $header; ?></h2></div>
		<div class="span6">
			<select name="situacao">
				<option value="aberto">Em aberto</option>
				<option value="todas">Todas</option>
			</select>
			<select name="atendente">
				<option value="eu">Abertas por mim...</option>
				<option value="todas">Todas</option>
			</select>
		</div>
		<div class="span4">
			<input name="data[search]" type="text" placeholder="pesquise..." class="span2" value="<?php if (isset($search)) echo $search;?>">
			<input type="submit" class="btn" value="Pesquisar"> 
		</div>
		</form>
	</div>
</div>

<?php if (count($data_index) == 0) { ?>
<div class="alert alert-warning">
	Nenhum registro no Banco de Dados!
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
		//pr($data_index); 
		foreach ($data_index as $row) { ?>
		<tr>
			<?php if ($row['Chamada']['instituicao_id'] != null) { ?><td><?php echo $row['Instituicao']['nome_fantasia'];?></td><?php } ?>
			<?php if ($row['Chamada']['fornecedor_id'] != null) { ?><td><?php echo $row['Fornecedor']['nome_fantasia'];?></td><?php } ?>
						
			<td><?php echo $row['Contato']['nome'];?></td>
			<td><?php echo date('d/m/Y H:i', strtotime( $row['Chamada']['data_inicio']) ); ?></td>
			<td><?php echo $row['Assunto']['nome'];?></td>
			<td><?php echo $row['Chamada']['solicitacao'];?></td>
			<td>
				<a href="/chamadas/view/<?php echo $row['Chamada']['id'];?>" rel="tooltip" title="Ver Detalhes" class="btn"><i class="icon-th-list"></i></a>
				<a href="/chamadas/edit/<?php echo $row['Chamada']['id'];?>" rel="tooltip" title="Editar" class="btn"><i class="icon-pencil"></i></a>			
				<a href="/chamadas/finalizar/<?php echo $row['Chamada']['id'];?>" rel="tooltip" title="Finalizar Chamada" class="btn btn-danger btnConfirm"><i class="icon-lock icon-white"></i></a>
				<?php if (count($row['ChamadasFilha']) == 0) { ?>
				<a href="#delModal" data-del-info="<?php echo $row['Chamada']['id'].' - '.$row['Chamada']['solicitacao']; ?>" data-id="<?php echo $row[$model]['id']; ?>" data-toggle="modal" class="btn delBtn" rel="tooltip" title="Excluir"><i class="icon-trash"></i></a>
				<?php } else { ?>
				<a href="#" class="btn btn-danger" rel="tooltip" title="Não é possível Excluir"><i class="icon-trash icon-white"></i></a>
				<?php } ?>
				<?php if ($row['Chamada']['chamada_id'] == 0) { ?>
				<a href="#" rel="tooltip" title="Adicionar Chamada Relacionada" class="btn"><i class="icon-plus"></i></a>
				<?php } ?>
				<?php if (count($row['ChamadasFilha']) > 0) { ?>
				<a href="/chamadas/relacionadas/<?php echo $row['Chamada']['id'];?>" rel="tooltip" title="Ver Chamadas Relacionadas" class="btn btn-success"><?php echo count($row['ChamadasFilha']); ?><i class="btn-th-list"></i></a>
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
<script>
$(document).ready(function() {
	$('.delBtn').click(function() {
		$('#modal-id').val($(this).data('id'));
		$('#modal-del-info').html($(this).data('del-info'));
	});
});
</script>
<?php } ?>