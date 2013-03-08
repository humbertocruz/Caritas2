<div class="tabbable">
	<ul id="tab" class="nav nav-tabs">
		<li class="active"><a href="#<?php echo $model;?>" data-toggle="tab"><?php echo $model;?></a></li>
		<?php if(!empty($this->data[$model]['id'])) { 
		foreach($oneMany as $field) { ?>
			<li><a href="#<?php echo $field['field'];?>" data-toggle="tab"><?php echo $field['name'];?></a></li>
		<?php }
		foreach($hasMany as $field) { ?>
			<li><a href="#<?php echo $field['field'];?>" data-toggle="tab"><?php echo $field['name'];?></a></li>
		<?php }
		foreach($habtMany as $field) { ?>
			<li><a href="#<?php echo $field['field'];?>" data-toggle="tab"><?php echo $field['name'];?></a></li>
		<?php } } ?>
	</ul>
	<div class="tab-content">
		<div class="tab-pane active" id="<?php echo $model;?>">
			<form method="post" id="form_<?php echo $model;?>" class="form-horizontal">
				<input type="hidden" id="cancel_input_<?php echo $model;?>" name="data[System][cancel]" value="0">
				<input type="hidden" name="data[System][here]" value="<?php echo $this->here; ?>">
				<input type="hidden" name="data[System][controller]" value="<?php echo $this->name; ?>">
				<input type="hidden" name="data[<?php echo $model;?>][id]" value="<?php echo (isset($this->data[$model]['id']) ? $this->data[$model]['id'] : ''); ?>">
				<input type="hidden" name="data[System][chamada_id]" value="<?php echo $id_chamada;?>">
				<input type="hidden" name="data[continue]" id="inp-continue" value="0">
				<?php foreach($fields as $field) {
					if ($field['type'] == 'none' or $field['type'] == 'habtm') continue;
					if (!isset($field['url'])) $field['url'] = '';
					echo $this->Element('Forms/Controls/'.$field['type'], array('ctrl_field'=>$field, 'model'=>$model, 'controller'=>$controller));
				} ?>
				<fieldset class="form-actions">
					<input type="submit" value="Gravar" class="btn btn-primary">
					<?php if (!isset($this->data[$model]['id'])) { ?>
						<input type="submit" value="Gravar e Continuar" class="btn btn-success bt-savecontinue">
					<?php } ?>
					<input type="button" id="cancel_<?php echo $model;?>" value="Cancelar" class="btn">
				</fieldset>
			</form>
		</div>
		<?php
		foreach($oneMany as $field) {
			echo $this->Element('Forms/Controls/oneMany', array('ctrl_field'=>$field, 'model'=>$model, 'controller'=>$controller));
		}
		foreach($hasMany as $field) {
			echo $this->Element('Forms/Controls/hasMany', array('ctrl_field'=>$field, 'model'=>$model, 'controller'=>$controller));
		}
		foreach($habtMany as $field) {
			echo $this->Element('Forms/Controls/habtMany', array('ctrl_field'=>$field, 'model'=>$model, 'controller'=>$controller));
		}
		?>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('.bt-savecontinue').click(function() {
			$('#inp-continue').val(1);
		});
		if(window.location.hash) {
			$('#tab a[href="'+window.location.hash+'"]').tab('show');
		}
		$('#cancel_<?php echo $model;?>').click(function(){
			$('#cancel_input_<?php echo $model;?>').val(1);
			$('#form_<?php echo $model; ?>').submit();
		});
	});
</script>