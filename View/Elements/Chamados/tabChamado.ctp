<form class="form-vertical sr-form" method="post" id="form_Chamado">
	<input type="hidden" name="data[Chamado][id]" value="<?php echo (isset($this->data['Chamada']['id']))?($this->data['Chamada']['id']):(0);?>">
	<input type="hidden" name="data[Chamado][chamada_id]" value="<?php echo (isset($this->data['Chamada']['chamada_id']))?($this->data['Chamada']['chamada_id']):(0);?>">
	<input type="hidden" name="data[Chamado][atendente_id]" value="<?php echo $atendente_id['Atendente']['id']; ?>">
	<input type="hidden" name="data[System][finalizando]" id="fld_finalizando" value="0">
	<div class="row">
		<div class="span6">
			<div class="control-group btns">
				<label class="control-label">&nbsp;</label>
				<div class="controls">
					<div class="btn-group" data-toggle="buttons-radio">
					<button type="button" class="btn btn-primary btI <?php if (!empty($this->data['Chamada']['instituicao_id']) or (empty($this->data['Chamada']['instituicao_id']) and empty($this->data['Chamada']['fornecedor_id']))) echo 'active'; ?>">Instituição</button>
					<button type="button" class="btn btn-primary btF <?php if (!empty($this->data['Chamada']['fornecedor_id'])) echo 'active'; ?>">Fornecedor</button>
					</div>	
				</div>
			</div>
			<?php echo $this->Element('Chamados/instituicao',array('bt_model'=>'Chamado', 'field'=>'instituicao_id')); ?>
			<?php echo $this->Element('Chamados/fornecedor',array('bt_model'=>'Chamado','field'=>'fornecedor_id')); ?>
			
			<?php echo $this->Element('Chamados/tabContato'); ?>
			<?php echo $this->Element('Chamados/belongsTo', array('field' => 'projeto_id', 'label'=>'Projeto', 'bt_model'=>'Chamado','search'=>false,'url'=>'projetos','data'=>$projetos ) ); ?>
			<?php echo $this->Element('Chamados/belongsTo', array('field' => 'tipo_chamada_id', 'label'=>'Tipo de Chamada', 'bt_model'=>'Chamado','search'=>false,'url'=>'tipos_chamadas','data'=>$tipos_chamada ) ); ?>
			<?php echo $this->Element('Chamados/belongsTo', array('field' => 'assunto_id', 'label'=>'Assunto', 'bt_model'=>'Chamado','search'=>false,'url'=>'assuntos','data'=>$assuntos ) ); ?>
			<?php echo $this->Element('Chamados/date', array('field' => 'data_inicio', 'label'=>'Data Início', 'value'=>'now' ) ); ?>
			<?php echo $this->Element('Chamados/date', array('field' => 'data_fim', 'label'=>'Data Fim', 'readonly'=>true  ) ); ?>
			<?php echo $this->TB->input('Chamado.solicitacao', array('class'=>'span6','type'=>'textarea','label'=>'Solicitação') ); ?>
			<?php echo $this->Element('Chamados/belongsTo', array('field' => 'prioridade_id', 'label'=>'Prioridade', 'bt_model'=>'Chamado','search'=>false,'url'=>'prioridades','data'=>$prioridades ) ); ?>
			<?php echo $this->Element('Chamados/belongsTo', array('field' => 'pedido_id', 'label'=>'Pedido', 'bt_model'=>'Chamado', 'search'=>true, 'url'=>'pedidos','data'=>$pedidos ) ); ?>
			<?php echo $this->Element('Chamados/belongsTo', array('field' => 'status_id', 'label'=>'Status', 'bt_model'=>'Chamado', 'search'=>false, 'url'=>'status','data'=>$status ) ); ?>

		</div>
		<div class="span6">
			<div class="alert alert-success">
				<h3>Histórico de Chamadas</h3>
				<table class="table table-bordered" style="background-color: #fff;">
					<thead>
						<tr>
							<th>Dia / Hora</th>
							<th>Contato</th>
							<th>Solicitação</th>
							<th>Atendente</th>
						</tr>
					</thead>
					<tbody id="chamados-table">
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="form-actions">
		<input type="submit" class="btn btn-primary" value="Salvar">
		<input type="submit" class="btn btn-success bt-savecontinue" value="Gravar e Continuar">
		<input type="button" class="btn btn-danger" id="bt-save-end" value="Gravar e Finalizar">
		<?php
		if ($pedido_id != 0) { ?>
			<a href="/pedidos/edit/<?php echo $pedido_id;?>#tabChamada" class="btn">Cancelar</a>
		<?php } else { ?>
			<a href="/chamadas" class="btn">Cancelar</a>
		<?php } ?>
	</div>
</form>
<script>
	$(document).ready(function(){
		$('#bt-save-end').click(function(){
			$('#fld_status_id').val(3);
			$('#fld_finalizando').val(1);
			$('#form_Chamada').submit();
		});
	});
</script>
