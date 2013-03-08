<div class="control-group">
	<label class="control-label"><?php echo($ctrl_field['name']);?></label>
	<div class="controls">
		<input type="hidden" name="data[<?php echo $model;?>][<?php echo $ctrl_field['foreign_key']; ?>]" value="<?php echo $this->data[$ctrl_field['source_model']][$ctrl_field['source_key']];?>">
		<?php echo ($this->data[$ctrl_field['source_model']][$ctrl_field['source_display']]); ?>
	</div>
</div>
