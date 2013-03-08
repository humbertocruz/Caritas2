<?php
$sess_models = AppController::_sess_models();
pr($sess_controls);
?>
<div class="control-group">
	<label class="control-label"><?php echo $ctrl_field['name'];?></label>
	<div class="controls">
		<input type="hidden" name="data[<?php echo $model;?>][<?php echo $ctrl_field['field'];?>]" value="<?php echo $sess_models[$ctrl_field['session']]['id'];?>">
		<input class="span4" type="text" readonly="readonly" value="<?php echo $sess_models[$ctrl_field['session']]['texto'];?>">
	</div>
</div>