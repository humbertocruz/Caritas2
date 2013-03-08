<form method="post" id="form_<?php echo $model;?>" class="form-horizontal">
	<input type="hidden" id="cancel_input_<?php echo $model;?>" name="data[System][cancel]" value="0">
	<input type="hidden" name="data[System][here]" value="<?php echo $this->here; ?>">
	<input type="hidden" name="data[System][controller]" value="<?php echo $this->name; ?>">
	<input type="hidden" name="data[System][id_chamada]" value="<?php echo (isset($id_chamada))?($id_chamada):('0'); ?>">
	<input type="hidden" name="data[<?php echo $model;?>][id]" value="<?php echo (isset($this->data[$model]['id']) ? $this->data[$model]['id'] : ''); ?>">
	<fieldset>
		<?php foreach($fields as $field) {
			if ($field['type'] == 'none' or $field['type'] == 'source_none' or $field['type'] == 'habtm') continue;
			if (!isset($field['url'])) $field['url'] = '';
			if (!isset($field['search'])) $field['search'] = false;

		
			if (isset($field['fieldset'])){ ?>
				</fieldset>
				<fieldset>
				<legend><?php echo $field['fieldset'];?></legend>
			<?php }
		if (!isset($field['data'])) $field['data'] = array();
		if (!isset($field['url'])) $field['url'] = '';
		
		echo $this->Element('Forms/Controls/'.$field['type'], array('ctrl_field'=>$field,'model'=>$model, 'controller'=>$controller));
		} ?>
	</fieldset>
	<fieldset class="form-actions">
		<input type="submit" value="Gravar" class="btn btn-primary">
		<input type="button" id="cancel_<?php echo $model;?>" value="Cancelar" class="btn">	
	</fieldset>
</form>
<script >
	$(document).ready(function(){
		$('#cancel_<?php echo $model;?>').click(function(){
			$('#cancel_input_<?php echo $model;?>').val(1);
			$('#form_<?php echo $model; ?>').submit();
		});
	});
</script>