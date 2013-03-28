<div class="page-header">
<h3>Chamada</h3>
</div>

<div class="alert alert-info">
	<h3>Solicita&ccedil;&atilde;o</h3>
	<p><?php echo $data_view['Chamada']['solicitacao'];?></p>
</div>
<div class="row">
	<div class="span6"><h3>In&iacute;cio</h3><p><?php echo date( 'd/m/Y', strtotime( $data_view['Chamada']['data_inicio'] ) ); ?></p></div>
	<div class="span6"><h3>Fim</h3><p><?php echo date( 'd/m/Y', strtotime( $data_view['Chamada']['data_fim'] ) ); ?></p></div>
</div>
<div class="row">
	<div class="span6"><h3>Projeto</h3><p><?php echo $data_view['Projeto']['nome']; ?></p></div>
	<div class="span6"><h3>Assunto</h3><p><?php echo $data_view['Assunto']['nome']; ?></p></div>
</div>
<div class="row">
	<div class="span6"><h3>Prioridade</h3><p><?php echo $data_view['Prioridade']['nome']; ?></p></div>
	<div class="span6"><h3>Status</h3><p><?php echo $data_view['Status']['nome']; ?></p></div>
</div>
<div class="row">
	<div class="span6"><h3>Institui&ccedil;&atilde;o</h3><p><?php echo $data_view['Instituicao']['nome_fantasia']; ?></p></div>
	<div class="span6"><h3>Fornecedor</h3><p><?php echo $data_view['Fornecedor']['nome_fantasia']; ?><p></div>
</div>
<div class="row">
	<div class="span6"><h3>Atendente</h3><p><?php echo $data_view['Atendente']['nome']; ?></p></div>
	<div class="span6"><h3>Tipo de Chamada</h3><p><?php echo $data_view['TiposChamada']['nome']; ?></p></div>
</div>
<div class="row">
	<div class="span12"><h3>Contato</h3><p><?php echo $data_view['Contato']['nome'].' - '.$data_view['Contato']['ContatosFone'][0]['fone'].' - '.$data_view['Contato']['ContatosEmail'][0]['email'];?></p></div>
</div>
<?php if ( count( $data_view['ChamadasFilha'] ) > 0 ) { ?>
<div class="row">
	<div class="span12"><h3>Chamadas Relacionadas</h3></div>
</div>
<table class="table">
	<tr>
		<th>In&iacute;cio</th>
		<th>Fim</th>
		<th>Status</th>
	</tr>
	<?php foreach ($data_view['ChamadasFilha'] as $filhas) { ?>
	<tr>
		<td><a href="/chamadas/view/<?php echo $filhas['id'];?>"><?php echo date('d/m/Y', strtotime( $filhas['data_inicio'] ) );?></a></td>
		<td><a href="/chamadas/view/<?php echo $filhas['id'];?>"><?php echo date('d/m/Y', strtotime( $filhas['data_fim'] ) );?></a></td>
		<td><a href="/chamadas/view/<?php echo $filhas['id'];?>"><?php echo $filhas['Status']['nome'];?></a></td>
	</tr>
	<?php } ?>
</table>
<?php } ?>
<div class="form-actions">
	<?php
	if ($pedido_id != 0) { ?>
		<a href="/pedidos/edit/<?php echo $pedido_id;?>#tabChamada" class="btn">Cancelar</a>
	<?php } else { ?>
		<a href="/chamadas" class="btn">Cancelar</a>
	<?php } ?>
</div>
