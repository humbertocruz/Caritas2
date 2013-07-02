<div class="btn-group">
	<a class="btn" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon icon-wrench"></i>&nbsp;<span class="caret"></span></a>
	<ul class="dropdown-menu">
		<li><a href="/chamados/view/<?php echo $chamado['Chamado']['id'];?>" rel="tooltip" title="Ver Detalhes"><i class="icon-th-list"></i>&nbsp;Ver</a></li>
		<li><a href="/chamados/edit/<?php echo $chamado['Chamado']['id'];?>" rel="tooltip" title="Editar"><i class="icon-pencil"></i>&nbsp;Editar</a></li>
		<?php if ($chamado['Chamado']['data_fim'] == null) { ?>
		<li><a href="#FimModal" data-toggle="modal" data-id="<?php //echo $chamado[$model]['id'];?>" data-fim-info="<?php echo $chamado['Chamado']['id'].' - '.$chamado['Chamado']['solicitacao']; ?>" rel="tooltip" title="Finalizar Chamada" class="fimBtn btnConfirm"><i class="icon-lock"></i>&nbsp;Finalizar</a></li>
		<?php } else { ?>
		<li><a rel="tooltip" title="Chamada Finalizada em <?php echo date('d/m/Y',strtotime($chamado['Chamado']['data_fim']));?>" class="disabled"><i class="icon-lock"></i>&nbsp;Finalizada</a></li>
		<?php } ?>
		<?php if (count($chamado['ChamadasFilha']) == 0 and count($chamado['ChamadasProcedimento']) == 0) { ?>
		<li><a href="#delModal" data-del-info="<?php echo $chamado['Chamado']['id'].' - '.$chamado['Chamado']['solicitacao']; ?>" data-id="<?php //echo $chamado[$model]['id']; ?>" data-toggle="modal" class="delBtn" rel="tooltip" title="Excluir"><i class="icon-trash"></i>&nbsp;Excluir</a></li>
		<?php } else { ?>
		<li><a class="disabled" rel="tooltip" title="Não é possível Excluir"><i class="icon-trash"></i>&nbsp;Não é possível excluir</a></li>
		<?php } ?>
		<?php if ($chamado['Chamado']['chamada_id'] == 0) { ?>
		<li><a href="/chamados/add/<?php echo $chamado['Chamado']['id']; ?>" rel="tooltip" title="Adicionar Chamada Relacionada"><i class="icon-plus"></i>&nbsp;Adicionar Chamada Relacionada</a></li>
		<?php } ?>
		<?php if (count($chamado['ChamadasFilha']) > 0) { ?>
		<li><a href="#" rel="tooltip" title="Chamadas Relacionadas"><?php echo count($chamado['ChamadasFilha']); ?><i class="btn-th-list"></i></a>&nbsp; Chamadas relacionadas</li>
		<?php } ?>
	</ul>
</div>