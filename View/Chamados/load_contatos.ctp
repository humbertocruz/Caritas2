<option value="0">Escolha o Contato</option>
<?php foreach ($contatos as $contato) { ?>
	<?php echo '<option value="'.$contato['Contato']['id'].'">'.$contato['Contato']['nome'].'</option>'; ?>
<?php } ?>
