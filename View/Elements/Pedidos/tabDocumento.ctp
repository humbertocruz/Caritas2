<table class="table table-bordered">
	<thead>
	<tr>
		<th>Nome</th>
		<th>Data Documento</th>
		<th>Data Cadastro</th>
		<th>Observação</th>
		<th>Tipo</th>
		<th class="span2">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($this->data['Documento'] as $row) { ?>
	<tr>
		<td><?php echo $row['nome_arquivo'];?></td>
		<td><?php echo $this->Bootstrap->brdate( $row['data_documento'] );?></td>
		<td><?php echo $this->Bootstrap->brdate( $row['data_cadastro'] );?></td>
		<td><?php echo $row['observacao'];?></td>
		<td><?php echo $row['TiposDocumento']['nome'];?></td>
		<td>
			<a rel="tooltip" data-id="<?php echo $row['id'];?>" data-texto="<?php echo $row['nome_arquivo'];?>" class="bt-del-doc" title="Remover Documento" href="#"><i class="icon icon-trash"></i></a>
			<a rel="tooltip" title="Editar Documento" href="/pedidos/editDocumento/<?php echo $row['id'];?>"><i class="icon icon-pencil"></i></a>
			<a rel="tooltip" title="Download do Documento" href="/documentos/pedidos/<?php echo $row['pedido_id'].'/'.$row['id'].'_'.$row['nome_arquivo'];?>"><i class="icon icon-circle-arrow-down"></i></a>
		</td>
	</tr>
	<?php } ?>
	</tbody>
</table>
<div class="form-actions">
	<a href="/pedidos/addDocumento/<?php echo $this->data['Pedido']['id'];?>" class="btn btn-primary">Novo Documento</a>
</div>
<div id="modal-excluir-documento" class="modal hide fade in">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Excluir</h3>
    </div>
    <div class="modal-body">
        <p>Tem certeza que deseja excluir o documento <span class="text-modal-doc-name"></span></p>
    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="bt-modal-cancelar btn" href="#">Cancelar</a>
		<form style="display: inline;" method="post" action="/pedidos/delDocumento/<?php echo $this->data['Pedido']['id'];?>">
			<input id="modal-doc-id" type="hidden" name="data[Documento][id]" value="">
	        <input type="submit" class="bt-modal-excluir btn btn-danger" href="#" value="Excluir">
		</form>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('.bt-del-doc').click(function(){
			$('.text-modal-doc-name').html($(this).data('texto'));
			$('#modal-doc-id').val($(this).data('id'));
			$('#modal-excluir-documento').modal('show');
		});
	});
</script>
