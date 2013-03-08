<?php
$sess_models = AppController::_sess_models();
?>
<div class="page-header">
	<h3>Edita Prazo</h3>
</div>
<form method="post" class="form form-horizontal">
	<input type="hidden" name="data[EtapasAtividadesItem][id]" value="<?php echo $EtapasAtividadesItem_id;?>">
	<input type="hidden" name="data[EtapasAtividadesItem][item_id]" value="<?php echo $foreignKey; ?>">
	<input type="hidden" name="data[System][cancel]" value="0">
	<input type="hidden" name="data[EtapasAtividadesItem][projeto_id]" value="<?php echo $sess_models['Projetos']['id']; ?>">
	
	<?php
		echo $this->Element('Controls/text', array('model'=>'EtapasAtividadesItem', 'label'=>'Ordem', 'field'=>'ordem_exibicao', 'value'=>$data['EtapasAtividadesItem']['ordem_exibicao']));
		echo $this->Element('Controls/bool', array('model'=>'EtapasAtividadesItem', 'label'=>'Global', 'field'=>'global', 'value'=>$data['EtapasAtividadesItem']['global']));
		echo $this->Element('Controls/select', array('model'=>'EtapasAtividadesItem', 'label'=>'Etapa', 'field'=>'etapas_id', 'value'=>$data['EtapasAtividadesItem']['etapa_id'], 'data'=>$etapas));
		echo $this->Element('Controls/select', array('model'=>'EtapasAtividadesItem', 'label'=>'Atividade', 'field'=>'atividades_id', 'value'=>$data['EtapasAtividadesItem']['atividade_id'], 'data'=>$atividades));
		echo $this->Element('Controls/text', array('model'=>'EtapasAtividadesItem', 'label'=>'Prazo', 'field'=>'prazo', 'value'=>$data['EtapasAtividadesItem']['prazo']));
	?>
	<div class="form-actions">
		<input type="submit" value=" Salvar " class="btn btn-primary">
		<a href="/itens/edit/<?php echo $foreignKey; ?>" class="btn">Cancelar</a>
	</div>
</form>
