<?php foreach($fornecedores as $fornecedor) { ?>
<option value="<?php echo $fornecedor['Fornecedor']['id'];?>"><?php echo $fornecedor['Fornecedor']['nome_fantasia'];?></option>
<?php } ?>