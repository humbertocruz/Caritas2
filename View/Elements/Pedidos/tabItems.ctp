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
			<th class="span2">&nbsp;</th>
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
			<td>
				<a href="/pedidos/edit_item/<?php echo $row['id'].'/'.$this->data['Pedido']['id'];?>" class="btn"><i class="icon icon-pencil"></i></a>
				<a href="#" class="bt-del-item btn" data-texto="<?php echo $row['Item']['nome']; ?>" data-id="<?php echo $row['id'];?>"><i class="icon icon-trash"></i></a>
				<a href="/pedidos/calendario/<?php echo $row['id'];?>" class="btn" rel="tooltip" title="Calendário"><i class="icon icon-calendar"></i></a>
			</td>
		</tr>
	<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<th class="alert" style="text-align: right;" colspan="10">Total do pedido: <span id="total_pedido_after"><?php echo number_format( $total_pedido, 2, ',', '.' ); ?></span></th>
		</tr>
	</tfoot>
</table>
<div class="form-actions">
	<a href="/pedidos/add_item/<?php echo $this->data['Pedido']['id'];?>" class="btn btn-primary">Adicionar Item</a>
</div>
<script>
$(document).ready(function(){
	$('#total_pedido_before').html($('#total_pedido_after').html());
});
</script>
<div id="modal-excluir-item" class="modal hide fade in">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Excluir</h3>
    </div>
    <div class="modal-body">
        <p>Tem certeza que deseja excluir o item <span class="text-modal-item-name"></span></p>
    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="bt-modal-cancelar btn" href="#">Cancelar</a>
		<form style="display: inline;" method="post" action="/pedidos/delItem/<?php echo $this->data['Pedido']['id'];?>">
			<input id="modal-item-id" type="hidden" name="data[PedidoItem][id]" value="">
	        <input type="submit" class="bt-modal-excluir btn btn-danger" href="#" value="Excluir">
		</form>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('.bt-del-item').click(function(){
			$('.text-modal-item-name').html($(this).data('texto'));
			$('#modal-item-id').val($(this).data('id'));
			$('#modal-excluir-item').modal('show');
		});
	});
</script>
