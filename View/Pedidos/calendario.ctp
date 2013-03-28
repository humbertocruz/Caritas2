<div class="page-header">
	<h3>Calendário de Ítem de Pedido</h3>
	<h4><?php echo $calendario['Pedido']['Instituicao']['razao_social'];?> - <?php echo $calendario['Item']['nome'];?></h4>
</div>
<table class="table table-bordered">
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>Atividade</th>
		<th>Prazo</th>
		<th>Data Inicio Prevista</th>
		<th>Data Inicio Efetiva</th>
		<th>Data Fim Prevista</th>
		<th>Data Fim Efetiva</th>
		<th>Situação</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	$etapa = '';
	foreach($calendario['PedidosItensEtapasAtividade'] as $prazo) {
		$hoje = date_create();
		$inip = date_create_from_format('Y-m-d', $prazo['data_inicio_prevista']);
		$inie = date_create_from_format('Y-m-d', $prazo['data_inicio_efetiva']);
		$fimp = date_create_from_format('Y-m-d', $prazo['data_fim_prevista']);
		$fime = date_create_from_format('Y-m-d', $prazo['data_fim_efetiva']);
		
		if ($hoje < $inip) {
			$situacao = 'Na fila';
		} else {
			if ($inie == false) {
				$situacao = 'Atrasada';
			} else {
				if ($hoje >= $fimp) {
					if ($hoje > $fime) {
						$situacao = 'Finalizada';
					} else {
						$situacao = 'Atrasada';
					}
				} else {
					$situacao = 'Em execução';
				}
			}
		}
	?>
	<?php if ($prazo['EtapasAtividadesItem']['Etapa']['nome'] != $etapa) { $etapa = $prazo['EtapasAtividadesItem']['Etapa']['nome'];?>
	<tr>
		<th colspan="8"><h3><?php echo $etapa; ?></h3></th>
	</tr>
	<?php } ?>
	<tr>
		<th class="center"><a href="/pedidos/prazos/<?php echo $prazo['id'];?>"><i class="icon icon-pencil"></i></a></th>
		<td><?php echo $prazo['EtapasAtividadesItem']['Atividade']['nome']; ?></td>
		<td><?php echo $prazo['EtapasAtividadesItem']['prazo']; ?></td>
		<td><?php echo ($inip)?($inip->format('d/m/Y')):(''); ?></td>
		<td><?php echo ($inie)?($inie->format('d/m/Y')):('-x-x-x-'); ?></td>
		<td><?php echo ($fimp)?($fimp->format('d/m/Y')):(''); ?></td>
		<td><?php echo ($fime)?($fime->format('d/m/Y')):('-x-x-x-'); ?></td>
		<td><?php echo $situacao; ?></td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<div class="form-actions">
	<a href="/pedidos/edit/<?php echo $calendario['PedidosItem']['pedido_id'];?>#tabItems" class="btn">Voltar</a>
</div>

