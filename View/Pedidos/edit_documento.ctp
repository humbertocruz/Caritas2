<div class="page-header">
	<h3>Adiciona Documento</h3>
</div>
<form class="form form-vertical" enctype="multipart/form-data" method="post">
	<input type="hidden" name="data[Documento][id]" value="<?php echo $this->data['Documento']['id'];?>">
	<?php 
	echo $this->Bootstrap->input_file(array('model'=>'Documento', 'label'=>'Arquivo', 'name'=>'nome_arquivo'));
	echo $this->Bootstrap->date('Documento', 'Data Documento', 'data_documento'); 
	echo $this->Bootstrap->date('Documento', 'Data Cadastro', 'data_cadastro');
	echo $this->Bootstrap->belongsTo('Documento', 'Tipo', 'tipo_documento_id', $tipos_documentos);
	echo $this->Bootstrap->textarea('Documento', 'Observação', 'observacao');
	?>
	<div class="form-actions">
		<input type="submit" value=" Enviar " class="btn btn-primary">
	</div>
</form>