<h3>Níveis de Acesso</h3>
<hr>
<?php if (count($niveis_acessos) == 0) { ?>
<div class="alert alert-warning">
	Nenhum Atendente cadastrado no Banco de Dados!
</div>
<?php } else { ?>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Nome</th>
			<th class="span2">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($niveis_acessos as $nivel_acesso) { ?>
		<tr>
			<td><?php echo $nivel_acesso['NiveisAcesso']['nome'];?></td>
			<td>
				<a href="/niveis_acesso/edit/<?php echo $nivel_acesso['NiveisAcesso']['id'];?>" class="btn" rel="tooltip" title="Editar"><i class="icon-pencil"></i></a>
				<a href="#modal-excluir" data-toggle="modal" class="btn" rel="tooltip" title="Excluir"><i class="icon-trash"></i></a>
				<a href="/niveis_acesso/dup/<?php echo $nivel_acesso['NiveisAcesso']['id'];?>" data-toggle="modal" rel="tooltip" title="Copiar" data-id="<?php echo $nivel_acesso['NiveisAcesso']['id'];?>" class="btn"><i class="icon icon-share"></i></a>

			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<div class="form-actions">
	<a href="/niveis_acesso/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> Novo Nível de Acesso</a>
</div>
<div class="modal fade hide" id="modal-excluir">
	<form method="post" action="/assuntos/del">
	<input type="hidden" name="assunto_id" value="0">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">x</a>
		<h3>Mensagem</h3>
	</div>
	<div class="modal-body">
		<p>Tem certeza que deseja excluir este Nível de Acesso ?</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<input type="submit" href="/niveis_acesso/del/<?php echo $nivel_acesso['NiveisAcesso']['id'];?>" class="btn btn-danger" value="Excluir">
	</div>
	</form>
</div>