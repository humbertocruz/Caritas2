<?php foreach($cidades as $cidade) { ?>
<option <?php if ($cidade['Cidade']['id'] == $search_cidade) echo 'selected="selected"'; ?> value="<?php echo $cidade['Cidade']['id'];?>"><?php echo $cidade['Cidade']['nome'];?></option>
<?php } ?>