<?php if ($resultado) { ?>
<div class="alert alert-success">
Sua nova senha foi enviada para seu email com sucesso!
<!-- <?php echo $nova_senha; ?> -->
</div>
<?php } else { ?>
<div class="alert alert-error">
Não encontramos o email [ <?php echo $emailrec; ?> ] em nosso sistema, tente novamente!
</div>
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
<?php } ?>
