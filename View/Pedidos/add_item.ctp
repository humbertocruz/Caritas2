<div class="page-header">
	<h3>Adicionar Item ao Pedido</h3>
</div>

<form method="post">
    <input type="hidden" name="data[PedidosItem][pedido_id]" value="<?php echo $pedido_id; ?>">
    <?php echo $this->Bootstrap->select(
	array(
            'model' => 'PedidosItem',
            'label' => 'Item',
            'name' => 'item_id',
            'data' => $items
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'Data Inicial',
            'name' => 'data_inicial',
            'value' => date_format(date_create(), 'd/m/Y')
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'Nota Fiscal',
            'name' => 'nota_fiscal_man'
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'IF',
            'name' => 'if_man'
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'Num',
            'name' => 'num_man'
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'Chassi',
            'name' => 'chassi'
	)
    ); ?>
    <input type="submit" class="btn btn-primary" value="Gravar">
</form>