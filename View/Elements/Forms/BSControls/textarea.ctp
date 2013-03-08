<?php
if (isset($invalidFields)) {
	if (isset($invalidFields[$field])) {
		$fieldError = $invalidFields[$field][0];
	}
}
?>
<div class="control-group <?php echo (isset($fieldError)?'error':NULL);?>">
	<label class="control-label" for="fld_<?php echo $field;?>"><?php echo $label; ?></label>
	<div class="controls">
		<textarea rows="5" type="text" class="span4" id="fld_<?php echo $field;?>" name="data[<?php echo $model;?>][<?php echo $field;?>]"><?php echo (isset($this->data[$model][$field]) ? $this->data[$model][$field] : ''); ?></textarea>
		<?php echo (isset($fieldError)?'<span class="help-inline">'.$fieldError.'</span>':NULL);?>
	</div>
</div>