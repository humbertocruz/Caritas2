<?php 
if (!isset($value)) $value = '';
if ($value == 'now') {
	$value_date = date('d/m/Y', time());
	$value_time = date('H:i:s', time()); 
} else {
	$value_date = '';
	$value_time = ''; 
}
if (isset($this->data[$model][$field])) {
	$datetime = strtotime($this->data[$model][$field]);
	if ($datetime <= 0) {
		$value_date = '';
		$value_time = '';
	} else {
		$value_date = date('d/m/Y', strtotime($this->data[$model][$field]));
		$value_time = date('H:i:s', strtotime($this->data[$model][$field]));
	}
}
?>
<div class="control-group">
    <label class="control-label" for="ctrl_date_<?php echo $field; ?>"><?php echo $label;?></label>
    <div class="controls">
    	<div class="input-append date" data-date="<?php echo date('d/m/Y', time())?>" data-date-format="dd/mm/yyyy" id="ctrl_date_<?php echo $field; ?>">
    		<input <?php echo (isset($readonly))?('readonly="readonly"'):('');?> class="span2" type="text" name="data[<?php echo $model;?>][<?php echo $field; ?>]" value="<?php echo $value_date; ?>">
    		<span class="add-on"><i class="icon-calendar"></i></span>
    	</div>
   		<input <?php echo (isset($readonly))?('readonly="readonly"'):('');?> class="span1" type="text" name="data[<?php echo $model;?>][<?php echo $field; ?>_time]" value="<?php echo $value_time; ?>">
    </div>
</div>
<script >
    <?php if (!isset($readonly)) { ?>$('#ctrl_date_<?php echo $field; ?>').datepicker();<?php } ?>
</script>