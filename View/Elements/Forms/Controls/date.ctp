<div class="control-group">
    <label class="control-label" for="ctrl_date_<?php echo $ctrl_field['field']; ?>"><?php echo $ctrl_field['name'];?></label>
    <div class="controls">
    	<div class="input-append date" data-date="<?php echo date('d/m/Y', time())?>" data-date-format="dd/mm/yyyy" id="ctrl_date_<?php echo $ctrl_field['field']; ?>">
    		<input class="span4" type="text" name="data[<?php echo $model;?>][<?php echo $ctrl_field['field'];?>]" value="<?php echo (isset($this->data[$model][$ctrl_field['field']]) ? date('d/m/Y', strtotime($this->data[$model][$ctrl_field['field']])) : ''); ?>">
    		<span class="add-on"><i class="icon-calendar"></i></span>
    	</div>
    </div>
</div>
<script >
    $('#ctrl_date_<?php echo $ctrl_field['field'];?>').datepicker();
</script>