<?php
foreach($chamadas as $chamada) { ?>
<tr>
	<td class="span2"><?php echo date('d/m/Y H:i', strtotime( $chamada['Chamada']['data_inicio'] ) );?></td>
	<td><?php echo $chamada['Contato']['nome'];?></td>
	<td><?php echo $chamada['Chamada']['solicitacao'];?></td>
	<td><?php echo $chamada['Atendente']['nome'];?>a</td>
</tr>
<?php } ?>