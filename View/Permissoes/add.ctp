<div class="page-header"><h2>Permissões</h2></div>
<form class="form-vertical" method="post">
	<input type="hidden" name="data[Permissao][nivel_acesso_id]" value="<?php echo $nivel_acesso_id; ?>">
	<div class="control-group">
		<label class="control-label">Permissão</label>
		<div class="controls">
			<input type="text" name="data[Permissao][action]">
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Gravar">
		<a href="/permissoes" class="btn">Cancelar</a>
		</div>
</form>
