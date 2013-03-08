<div class="page-header">
	<h3>Editar Item</h3>
	<h4><?php echo $data['Item']['nome'];?></h4>
</div>
<ul class="nav nav-tabs">
	<li class="active"><a href="#atividades" data-toggle="tab">Atividades</a></li>
	<li><a href="#prazos" data-toggle="tab">Prazos</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="atividades">
		<form method="post" class="form-horizontal">
			<input type="hidden" name="data[Item][id]" value="<?php echo $data['Item']['id']; ?>">
			<?php
				echo $this->Element('Controls/text', array('model'=>'Item', 'label'=>'Nome', 'field'=>'nome', 'value'=>$data['Item']['nome']));
				echo $this->Element('Controls/money', array('model'=>'Item', 'label'=>'Valor', 'field'=>'valor', 'value'=>$data['Item']['valor']));
				echo $this->Element('Controls/select', array('model'=>'Item', 'label'=>'Ata de Preço', 'field'=>'ata_preco_id', 'value'=>$data['Item']['ata_preco_id'], 'data'=>$ataprecos));
				echo $this->Element('Controls/select', array('model'=>'Item', 'label'=>'Fornecedor', 'field'=>'fornecedor_id', 'value'=>$data['Item']['fornecedor_id'], 'data'=>$fornecedores));
			?>
			<div class="form-actions">
				<input type="submit" value="Gravar" class="btn btn-primary">
				<a href="/itens" class="btn">Cancelar</a>
			</div>
		</form>
	</div>
	<div class="tab-pane" id="prazos">
		<?php echo $this->Element('Itens/prazos', array('foreignKey'=>$data['Item']['id'],'data'=>$data['EtapasAtividadesItem'])); ?>
	</div>
</div>
<script>
	$(document).ready(function(){
		$().tab();
	});
</script>
