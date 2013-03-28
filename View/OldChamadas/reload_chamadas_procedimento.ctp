<?php
foreach ($chamadas_procedimentos as $row) { ?>
<tr data-data="<?php echo date('d/m/Y', strtotime($row['ChamadasProcedimento']['data']));?>" data-id="<?php echo $row['ChamadasProcedimento']['id'];?>" data-procedimento-id="<?php echo $row['Procedimento']['id'];?>">
	<td><?php echo date('d/m/Y', strtotime($row['ChamadasProcedimento']['data']));?></td>
	<td><?php echo $row['ChamadasProcedimento']['procedimento'];?></td>
	<td>
		<a href="#" class="btn bt_edit_procedimento">Edita</a>
		<a href="#" class="btn bt_del_procedimento">Excluir</a>
	</td>
</tr>
<?php } ?>