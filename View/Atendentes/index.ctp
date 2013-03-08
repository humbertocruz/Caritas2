<h3>Atendentes</h3>
<hr>
<?php if (count($atendentes) == 0) { ?>
<div class="alert alert-warning">
	Nenhum Atendente cadastrado no Banco de Dados!
</div>
<?php } else { ?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Nome</th>
			<th class="span2">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($atendentes as $atendente) { ?>
		<tr>
			<td><?php echo $atendente['Atendente']['nome'];?></td>
			<td>
				<a href="/atendentes/edit/<?php echo $atendente['Atendente']['id'];?>" class="btn" rel="tooltip" title="Editar"><i class="icon-pencil"></i></a>
				<a href="/atendentes/del/<?php echo $atendente['Atendente']['id'];?>" class="btn" rel="tooltip" title="Excluir"><i class="icon-trash"></i></a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<div class="form-actions">
	<a href="/atendentes/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> Novo Atendente</a>
</div>
