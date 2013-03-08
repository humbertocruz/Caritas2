<?php foreach($instituicoes as $instituicao) { ?>
<option value="<?php echo $instituicao['Instituicao']['id'];?>"><?php echo $instituicao['Instituicao']['nome_fantasia'];?></option>
<?php } ?>