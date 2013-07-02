<?php
if ( isset( $this->data[$bt_model][$field] ) ) {
	$dt_key = $this->data[$bt_model][$field];
} else {
	$dt_key = 0;
}
echo $dt_key;
?>
<div class="control-group" id="bt-<?php echo $field;?>">
	<div class="control-label">
		<label><?php echo $label; ?></label>
	</div>
	<div class="controls controls-row">
		<select name="<?php echo 'data['.$bt_model.']['.$field.']'; ?>" class="span5">
			<?php foreach($data as $key=>$value) { ; ?>
			<option <?php echo ( $key == $dt_key )?('selected="selected"'):(''); ?> value="<?php echo $key; ?>"><?php echo $value; ?></option>
			<?php } ?>
		</select>
		&nbsp;
		<a class="btn sr-form-bt" rel="tooltip" title="Gerenciar <?php echo $bt_model; ?>" href="#" data-url="<?php echo $url;?>"><span class="icon icon-plus-sign"></span></a>
	</div>
</div>
