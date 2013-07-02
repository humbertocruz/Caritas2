<option value="0">Escolha a Instituição</option>
<?php foreach ($instituicoes as $instituicao) { ?>
	<?php echo '<option value="'.$instituicao['Instituicao']['id'].'">'.$instituicao['Instituicao']['nome_fantasia'].'</option>'; ?>
<?php } ?>
