<div class="page-header"><h2>Permissões</h2>
<form class="form-inline">
	<select name="nivel_acesso_id">
		<?php echo $nivel_acesso_id; foreach($niveis as $nivel) { ?>
		<option <?php if($nivel['NiveisAcesso']['id'] == $nivel_acesso_id) echo 'selected="selected"'; ?> value="<?php echo $nivel['NiveisAcesso']['id']; ?>"><?php echo $nivel['NiveisAcesso']['nome'];?></option>
		<?php } ?>
	</select>
	<input type="submit" class="btn" value="Alterar Nível de Acesso">
</form>
</div>
<table class="table table-bordered">
	<thead>
	<tr class="alert-info">
		<th>Permissão</th>
		<th class="span1">&nbsp</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($permissoes as $permissao) { ?>
	<tr>
		<td><?php echo $permissao['Permissao']['action'];?></td>
		<td>
			<a href="/permissoes/del/<?php echo $permissao['Permissao']['id'];?>" class="btn btn-danger"><i class="icon icon-white icon-trash"></i></a>
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<div class="form-actions">
	<a href="/permissoes/add/<?php echo $nivel_acesso_id; ?>" class="btn btn-primary">Nova Permissão</a>
</div>
