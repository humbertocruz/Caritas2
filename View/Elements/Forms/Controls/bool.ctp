<div class="control-group" id="ctrl-<?php echo $ctrl_field['field'];?>">
    <label class="control-label" for="fld_<?php echo $ctrl_field['field'];?>"><?php echo $ctrl_field['name'];?></label>
    <div class="controls">
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
        if (!empty($this->data[$model])) {
            if ($value_checked == '1')
    		$selected = 'selected="selected"';
            else 
    		$selected = '';	
    	} else { 
            $selected = '';
    	}
        ?>
    		<option <?php echo $selected;?> value="0">Não</option>
    		<option <?php echo $selected;?> value="1">Sim</option>
    	</select>
    </div>
</div>
