<form method="post">
    <input type="hidden" name="data[PedidosItem][id]" value="<?php echo $item['PedidosItem']['id']; ?>">
    <input type="hidden" name="data[PedidosItem][pedido_id]" value="<?php echo $pedido_id; ?>">
    
    <?php echo $this->Bootstrap->select(
	array(
            'model' => 'PedidosItem',
            'label' => 'Item',
            'name' => 'item_id',
            'data' => $items,
            'value' => $item['PedidosItem']['item_id']
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'Nota Fiscal',
            'name' => 'nota_fiscal_man',
            'value' => $item['PedidosItem']['nota_fiscal_man']
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'IF',
            'name' => 'if_man',
            'value' => $item['PedidosItem']['if_man']
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'Num',
            'name' => 'num_man',
            'value' => $item['PedidosItem']['num_man']
	)
    ); ?>
    <?php echo $this->Bootstrap->text(
	array(
            'model' => 'PedidosItem',
            'label' => 'Chassi',
            'name' => 'chassi',
            'value' => $item['PedidosItem']['chassi']
	)
    ); ?>
    <input type="submit" class="btn btn-primary" value="Gravar">
</form>