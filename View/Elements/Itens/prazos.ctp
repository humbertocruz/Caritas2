<table class="table table-bordered">
	<thead>
		<tr>
			<th class="span1">&nbsp;</th>
			<th>Ordem</th>
			<th>Etapa</th>
			<th>Atividade</th>
			<th>Prazo</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $row) { ?>
		<tr>
			<td>
				<a href="/itens/editaPrazo/<?php echo $row['id'];?>"><i class="icon icon-pencil"></i></a>
				<a href="/itens/delPrazo/<?php echo $row['id'];?>"><i class="icon icon-trash"></i></a>
			</td>
			<td><?php echo $row['ordem_exibicao']; ?></td>
			<td><?php echo $row['Etapa']['nome']; ?></td>
			<td><?php echo $row['Atividade']['nome']; ?></td>
			<td><?php echo $row['prazo']; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="form-actions">
	<a href="/itens/addPrazo/<?php echo $foreignKey;?>" class="btn btn-primary">Novo Prazo</a>
</div>