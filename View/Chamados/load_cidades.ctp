<option value="0">Escolha a Cidade</option>
<?php foreach ($cidades as $cidade) { ?>
	<?php echo '<option value="'.$cidade['Cidade']['id'].'">'.$cidade['Cidade']['nome'].'</option>'; ?>
<?php } ?>
