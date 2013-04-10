<div class="row">
	<div class="page-header">
		<h3>Backups</h3>
	</div>
	<table class="table table-bordered">
		<tr>
			<th>Arquivo</th>
			<th>Tamanho</th>
		</tr>
		<?php foreach($backups as $bkp) { 
		if (strstr($bkp['arquivo'], 'tar.gz')) { ?>
		<tr>
			<td><a href="<?php echo '/backups_dir/'.$bkp['arquivo']; ?>"><?php echo $bkp['arquivo']; ?></a></td>
			<td><?php echo number_format( (filesize(WWW_ROOT.'/backups_dir/'.$bkp['arquivo'])/1024/1024) ) .' MB';?></td>
		</tr>
		<?php } } ?>
	</table>
	<div class="form-actions">
		<a class="btn btn-danger" href="/backups/gerar_arq">Novo Backup Arquivos</a>
		<a class="btn btn-danger" href="/backups/gerar_db">Novo Backup Banco</a>
	</div>
	
</div>
