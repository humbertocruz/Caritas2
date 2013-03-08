<?php
//pr($this->data['Cidade']);
//pr($ctrl_field);
if(!isset($source_model)) $source_model = '';

if ($this->Session->check('ContatosEndereco.estado_id')) {
	$sess_estado = $this->Session->read('ContatosEndereco.estado_id');
	$load_cidade = true;
}
if ($this->Session->check('ContatosEndereco.cidade_id')) {
	$sess_cidade = $this->Session->read('ContatosEndereco.cidade_id');
}

if ($ctrl_field['model'] == $source_model) { 

?>
<input type="hidden" name="data[<?php echo $model;?>][<?php echo strtolower($source_model); ?>_id]" value="<?php echo $this->data[$source_model]['id'];?>">
<?php } else { ?>
<div class="control-group" id="ctrl-<?php echo $ctrl_field['field'];?>">
    <label class="control-label" for="fld_<?php echo $ctrl_field['field'];?>"><?php echo $ctrl_field['name'];?></label>
    <div class="controls">
    	<div class="input-append">
    	<select class="span1" name="data[<?php echo $model;?>][estado_id]" id="uf_fld_<?php echo $ctrl_field['field'];?>">
    		<?php foreach ($belongsTo['Estado'] as $k=>$v) {
	    		if (isset($sess_estado))
	    			if ($sess_estado == $k) {
			    		$selected = ' selected="selected"';
			    	} else {
				    	$selected = '';
				    }
	    		elseif (isset($this->data['Cidade']['estado_id'])) 
		    		if ($this->data['Cidade']['estado_id'] == $k) {
			    		$selected = ' selected="selected"';
			    	} else {
				    	$selected = '';
				    }
				else $selected = '';
    		 ?>
    		<option <?php echo $selected;?> value="<?php echo $k;?>"><?php echo $k;?></option>
    		<?php } ?>
    	</select>
    	<select class="span3" id="fld_<?php echo $ctrl_field['field'];?>" name="data[<?php echo $model;?>][<?php echo $ctrl_field['field'];?>]">
    		<?php
    		if (isset($ret_belongsTo[$ctrl_field['model']])) {
	    		$value_checked = $ret_belongsTo[$ctrl_field['model']][1];	
    		} else {
	    		$value_checked = $this->data[$model][$ctrl_field['field']];
    		}
    		foreach($belongsTo[$ctrl_field['model']] as $key=>$value) {
    		if(isset($sess_cidade))
    			if ($sess_cidade == $key)
    				$selected = 'selected="selected"';
    			else 
    				$selected = '';
    		elseif (!empty($this->data[$model])) {
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
	$('#uf_fld_<?php echo $ctrl_field['field'];?>').change(function(event) { 
		$.ajax({
			url: '/cidades/findByUf/'+$(this).val(),
			success: function(data) { 
				$('#fld_<?php echo $ctrl_field['field'];?>').html(data);
			}
		});
	});
	<?php if (isset($load_cidade)) { ?>
		$.ajax({
			url: '/cidades/findByUf/'+$('#uf_fld_<?php echo $ctrl_field['field'];?>').val(),
			success: function(data) { 
				$('#fld_<?php echo $ctrl_field['field'];?>').html(data);
			}
		});
	<?php } ?>
});
</script>
<?php } ?>