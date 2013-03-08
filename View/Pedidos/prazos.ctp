<?php $row = $this->data['PedidosItensEtapasAtividade']; ?>
<div class="page-header">
	<h3>Editar Prazos</h3>
</div>
<form class="form form-horizontal" method="post">
	<input type="hidden" name="data[PedidosItensEtapasAtividade][id]" value="<?php echo $row['id'];?>">
	<input type="hidden" name="data[pedido_item_id]" value="<?php echo $row['pedido_item_id'];?>">

	<?php echo $this->Bootstrap->date('PedidosItensEtapasAtividade', 'Data Início Efetiva', 'data_inicio_efetiva'); ?>
	<?php echo $this->Bootstrap->date('PedidosItensEtapasAtividade', 'Data Fim Efetiva', 'data_fim_efetiva'); ?>
	<?php echo $this->Bootstrap->textarea('PedidosItensEtapasAtividade', 'Observação', 'observacao'); ?>
	
	<div class="form-actions">
		<input class="btn btn-primary" type="submit" value=" Gravar ">
		<a href="/pedidos/calendario/<?php echo $row['pedido_item_id'];?>" class="btn">Cancelar</a>
	</div>
</form>
<script>
	$(document).ready(function(){
	    $('#ctrl_date_data_inicio_efetiva').datepicker();
	    $('#ctrl_date_data_fim_efetiva').datepicker();
	}
	);
</script>
