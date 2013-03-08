	<div class="opt-fornecedor <?php if (empty($this->data['Chamada']['fornecedor_id'])) echo 'hide'; ?>">
	<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'fornecedor_id', 'label'=>'Fornecedor', 'bt_model'=>'Fornecedor','search'=>false, 'url'=>'fornecedores','sessLoad'=>false ) ); ?>
	</div>	
