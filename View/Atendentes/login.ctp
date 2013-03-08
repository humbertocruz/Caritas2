<div class="alert alert-info">
Utilize o formulário da barra superior para fazer o login.
</div>
Caso tenha esquecido sua senha, digite seu email no campo abaixo para gerar uma nova. A nova senha será enviada para seu email cadastrado.
<form class="form form-vertical" method="post" action="/atendentes/recupera">
	<div class="control-group">
		<label class="control-label">Email</label>
		<div class="controls">
			<input type="text" name="data[Atendente][email]">
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" value="Gerar nova senha" class="btn btn-primary">
	</div>
</form>