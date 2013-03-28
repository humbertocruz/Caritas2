<table class="table table-striped">
	<thead>
		<tr class="alert alert-info">
			<th>Item</th>
			<th>Valor</th>
			<th>Data Inicial</th>
			<th>Nota Fiscal</th>
			<th>IF</th>
			<th>Chassi</th>
			<th>Atividade</th>
			<th>Dt. Prevista</th>
			<th>Dt. Efetiva</th>
		</tr>
		<tr>
			<th class="alert" style="text-align: right;" colspan="10">Total do pedido: <span id="total_pedido_before"></span></th>
		</tr>
	</thead>
	
	<tbody>
	<?php
	$total_pedido = 0;
	foreach ( $this->data['PedidosItem'] as $row ) { 
		$total_pedido += $row['Item']['valor'];
	?>
		<tr>
			<td><?php echo $row['Item']['nome']; ?></td>
			<td><?php echo number_format( $row['Item']['valor'], 2, ',', '.' ); ?></td>
			<td><?php echo $row['data_inicial']; ?></td>
			<td><?php echo $row['nota_fiscal_man']; ?></td>
			<td><?php echo $row['if_man']; ?></td>
			<td><?php echo $row['chassi']; ?></td>
			<?php $last = $this->Caritas->calcEtapaAtividade($row['Item']['EtapasAtividadesItem']); ?>
			<td><?php echo $last['atividade'] ?></td>
			<td><?php echo $last['prevista'] ?></td>
			<td><?php echo $last['efetiva'] ?></td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<th class="alert" style="text-align: right;" colspan="10">Total do pedido: <span id="total_pedido_after"><?php echo number_format( $total_pedido, 2, ',', '.' ); ?></span></th>
		</tr>
	</tfoot>
</table>
