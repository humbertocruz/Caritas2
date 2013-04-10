<?php
if(!isset($source_model)) $source_model = '';
if(!isset($sessLoad)) $sessLoad = true;
if (!isset($ini_value)) $ini_value = 0;

if ($bt_model == $source_model) { 
pr($belongsTo);
?>
<input type="hidden" name="data[<?php echo $model;?>][<?php echo strtolower($source_model); ?>_id]" value="<?php echo $this->data[$source_model]['id'];?>">
<?php } else { ?>
<div class="control-group" id="ctrl-<?php echo $field;?>">
	<label class="control-label" for="fld_<?php echo $field;?>"><?php echo $label;?></label>
	<div class="controls">
		<div class="input-append">
			<?php 
			if ($search == true) { 
				if (isset($ret_belongsTo[$bt_model])) {
					$ret_belongsTo_key = $ret_belongsTo[$bt_model][1];
					$ret_belongsTo_value = $ret_belongsTo[$bt_model][2];
				} elseif (isset($this->data[$bt_model])) {
					$ret_belongsTo_key = $this->data[$bt_model]['id'];
					if (!empty($ret_belongsTo_key)) $ret_belongsTo_value = $belongsTo[$bt_model][$ret_belongsTo_key];
					else $ret_belongsTo_value = '';
				} elseif (isset($this->data[$model])) {
					if ($this->data[$model][$field] != 0) {
						$ret_belongsTo_key = $this->data[$model][$field];
						$ret_belongsTo_value = $belongsTo[$bt_model][$this->data[$model][$field]];
					} else {
						$ret_belongsTo_key = 0;
						$ret_belongsTo_value = '';
					}
				} else {
					$ret_belongsTo_key = 0;
					$ret_belongsTo_value = '';
				}
				?>
				<input type="hidden" id="fld_<?php echo $model.'_'.$field;?>_hidden" name="data[<?php echo $model.']['.$field.']';?>" value="<?php echo $ret_belongsTo_key; ?>">
				<input class="span4" type="text" readonly="readonly" value="<?php echo $ret_belongsTo_value; ?>">
		<?php } else { ?>
		<?php 
		if ($sessLoad == false) { 
			if ($bt_model == 'Instituicao') echo $this->Element('filter/instituicao_uf_cidade');
			if ($bt_model == 'Fornecedor') echo $this->Element('filter/fornecedor_uf_cidade');
		}
		?>
		<select class="span3" id="fld_<?php echo $field;?>" name="data[<?php echo $model;?>][<?php echo $field;?>]">
			<?php
			if (isset($ret_belongsTo[$bt_model])) {
				$value_checked = $ret_belongsTo[$bt_model][1];	
			} else {
				if (isset($this->data[$model])) {
					$value_checked = $this->data[$model][$field];
				} else {
					$value_checked = 0;
				}
			}
			foreach($belongsTo[$bt_model] as $key=>$value) {
			if (!empty($this->data[$model])) {
				if ($value_checked == $key)
					$selected = 'selected="selected"';
				else 
					$selected = '';	
			} else { 
				if ($ini_value == $key)
					$selected = 'selected="selected"';
				else 
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
		<?php if(Inflector::classify($this->name) !=  $bt_model && $sessLoad == true) { ?>
		<span class="add-on" type="button" id="btn_access_<?php echo $bt_model;?>"><b class="icon-plus-sign"></b></span>
		<?php } ?>
		</div>
	</div>
</div>
<script>
$('document').ready(function(){
	$('#btn_access_<?php echo $bt_model;?>').click(function(){
		$('form#form_<?php echo $model;?>').attr('action','/systems/belongsTo/<?php echo $url; ?>');
		$('form#form_<?php echo $model;?>').submit();
	});
});
</script>
<?php } ?>