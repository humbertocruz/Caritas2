<?php
if (isset($invalidFields)) {
	if (isset($invalidFields[$ctrl_field['field']])) {
		$fieldError = $invalidFields[$ctrl_field['field']][0];
	}
}
?>
<div class="control-group <?php echo (isset($fieldError)?'error':NULL);?>">
	<label class="control-label" for="fld_<?php echo $ctrl_field['field'];?>"><?php echo $ctrl_field['name'];?></label>
	<div class="controls">
		<textarea rows="5" type="text" class="span4" id="fld_<?php echo $ctrl_field['field'];?>" name="data[<?php echo $model;?>][<?php echo $ctrl_field['field'];?>]"><?php echo (isset($this->data[$model][$ctrl_field['field']]) ? $this->data[$model][$ctrl_field['field']] : ''); ?></textarea>
		<?php echo (isset($fieldError)?'<span class="help-inline">'.$fieldError.'</span>':NULL);?>
	</div>
</div>