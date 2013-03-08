<div class="control-group">
	<label class="control-label"><?php echo $label; ?></label>
	<div class="controls">
		<select name="data[<?php echo $model; ?>][<?php echo $field; ?>]">
			<?php foreach($data as $key=>$val) { ?>
			<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
			<?php } ?>
		</select>
	</div>
</div>