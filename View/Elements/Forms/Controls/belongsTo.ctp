<?php
//pr($this->data);
//pr($ctrl_field);
//pr($belongsTo);
if(!isset($source_model)) $source_model = '';
if ($ctrl_field['model'] == $source_model) { 

?>
<input type="hidden" name="data[<?php echo $model;?>][<?php echo strtolower($source_model); ?>_id]" value="<?php echo $this->data[$source_model]['id'];?>">
<?php } else { ?>
<div data-type="belongsTo" class="control-group" id="ctrl-<?php echo $ctrl_field['field'];?>">
	<label class="control-label" for="fld_<?php echo $ctrl_field['field'];?>"><?php echo $ctrl_field['name'];?></label>
	<div class="controls">
		<div class="input-append">
			<?php 
			if ($ctrl_field['search'] == true) { 
				if (isset($ret_belongsTo[$ctrl_field['model']])) {
					$ret_belongsTo_key = $ret_belongsTo[$ctrl_field['model']][1];
					$ret_belongsTo_value = $ret_belongsTo[$ctrl_field['model']][2];
				} elseif (isset($this->data[$ctrl_field['model']])) {
					$ret_belongsTo_key = $this->data[$ctrl_field['model']]['id'];
					$ret_belongsTo_value = $belongsTo[$ctrl_field['model']][$ret_belongsTo_key];
				} elseif (isset($this->data[$model])) {
					if ($this->data[$model][$ctrl_field['field']] != 0) {
						$ret_belongsTo_key = $this->data[$model][$ctrl_field['field']];
						$ret_belongsTo_value = $belongsTo[$ctrl_field['model']][$this->data[$model][$ctrl_field['field']]];
					} else {
						$ret_belongsTo_key = 0;
						$ret_belongsTo_value = '';
					}
				} else {
					$ret_belongsTo_key = 0;
					$ret_belongsTo_value = '';
				}
				?>
				<input type="hidden" name="data[<?php echo $model.']['.$ctrl_field['field'].']';?>" value="<?php echo $ret_belongsTo_key; ?>">
				<input class="span4" type="text" readonly="readonly" value="<?php echo $ret_belongsTo_value; ?>">
		<?php } else { ?>
		<select class="span4" id="fld_<?php echo $ctrl_field['field'];?>" name="data[<?php echo $model;?>][<?php echo $ctrl_field['field'];?>]">
			<?php
			if (isset($ret_belongsTo[$ctrl_field['model']])) {
				$value_checked = $ret_belongsTo[$ctrl_field['model']][1];	
			} else {
				if (isset($this->data[$model])) {
					$value_checked = $this->data[$model][$ctrl_field['field']];
				} else {
					$value_checked = 0;
				}
			}
			foreach($belongsTo[$ctrl_field['model']] as $key=>$value) {
			if (!empty($this->data[$model])) {
				if ($value_checked == $key)
					$selected = 'selected="selected"';
				else 
					$selected = '';	
			} else { 
				$selected = '';
			}	
			if (is_array($value)) { ?>
			<optgroup label="<?php echo $key; ?>">
			<?php foreach($value as $subvalue) { ?>
			<option <?php echo $selected;?> value="<?php echo $subvalue;?>"><?php echo $subvalue;?></option>
			<?php } ?>
			</optgroup>
			<?php } else { ?>
			<option <?php echo $selected;?> value="<?php echo $key;?>"><?php echo $value;?></option>
			<?php } ?>
		<?php } ?>
		</select>
		<?php } ?>
		<?php if(Inflector::classify($this->name) !=  $ctrl_field['model']) { ?>
		<span class="add-on" type="button" id="btn_access_<?php echo $ctrl_field['model'];?>"><b class="icon-plus-sign"></b></span>
		<?php } ?>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	$('#btn_access_<?php echo $ctrl_field['model'];?>').click(function(){
		$('form').attr('action','/systems/belongsTo/<?php echo $ctrl_field['url'];?>');
		$('form').submit();
	});
});
</script>
<?php } ?>