<?php foreach($convenios as $convenio) { ?>
<option value="<?php echo $convenio['Convenio']['id'];?>"><?php echo $convenio['Convenio']['num_convenio'];?></option>
<?php } ?>