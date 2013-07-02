<div class="page-header">
	<h2>Chamados</h2>
</div>
<div class="form-actions">
	<a href="/chamados/add" class="btn btn-primary">Novo Chamado</a>
</div>
<table class="table table-stripped">
	<tr class="alert-info">
		<th class="span1">&nbsp;</th>
		<th class="span3">Instituição / Fornecedor</th>
		<th class="span1">UF</th>
		<th class="span2">Contato</th>
		<th class="span1">Início</th>
		<th class="span2">Assunto</th>
		<th class="span2">Solicitação</th>
	</tr>
	<?php foreach ($this->data as $chamado) { ?>
	<tr>
		<td><?php echo $this->Element('common/actions', array('chamado'=>$chamado));?></td>
		<td><?php echo (!empty($chamado['Instituicao']))?($chamado['Instituicao']['nome_fantasia']):($chamado['Fornecedor']['nome_fantasia']);?></td>
		<td><?php echo (!empty($chamado['Instituicao']))?($chamado['Instituicao']['InstituicoesEndereco'][0]['Cidade']['estado_id']):($chamado['Fornecedor']['FornecedoresEndereco'][0]['Cidade']['estado_id']);?></td>
		<td><?php echo $chamado['Contato']['nome'];?></td>
		<td><?php echo $this->Bootstrap->brdate($chamado['Chamado']['data_inicio']);?></td>
		<td><?php echo $chamado['Assunto']['nome'];?></td>
		<td><?php echo $chamado['Chamado']['solicitacao'];?></td>
	</tr>
	<?php } ?> 
</table>
