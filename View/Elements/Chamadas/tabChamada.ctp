<form class="form-vertical" method="post" id="form_Chamada">
	<input type="hidden" id="cancel_input_Chamada" name="data[System][cancel]" value="0">
	<input type="hidden" name="data[System][here]" value="<?php echo $_SERVER['REQUEST_URI'];?>">
	<input type="hidden" name="data[System][controller]" value="Chamadas">
	<input type="hidden" name="data[System][pedido_id]" value="<?php echo $pedido_id; ?>">	
	<input type="hidden" name="data[Chamada][id]" value="<?php echo (isset($this->data['Chamada']['id']))?($this->data['Chamada']['id']):(0);?>">
	<input type="hidden" name="data[continue]" id="inp-continue" value="0">

	<input type="hidden" name="data[Chamada][chamada_id]" value="<?php echo (isset($this->data['Chamada']['chamada_id']))?($this->data['Chamada']['chamada_id']):(0);?>">
	<input type="hidden" name="data[Chamada][projeto_id]" value="<?php echo $sess_models['Projetos']['id'];?>">
	<input type="hidden" name="data[Chamada][atendente_id]" value="<?php echo $sess_models['Atendentes']['id'];?>">
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
			<?php echo $this->Element('Forms/BSControls/instituicaoSessUFCidade'); ?>
			<?php echo $this->Element('Forms/BSControls/fornecedorSessUFCidade'); ?>
			<?php // Campo especial para Contato da Chamada ?>
			<div class="control-group alert" id="ctrl-contato_id">
				<label class="control-label" for="fld_contato_id">Contato</label>
				<div class="controls">
					<select class="span4 opt-contato" id="fld_contato_id" name="data[Chamada][contato_id]">
						<optgroup label="Seleciossne a Instituição / Fornecedor"></optgroup>
					</select>
					<div class="clearfix">
						<table>
							<tr>
								<td>Cargo</td>
								<td>Status</td>
								<td>Telefone</td>
								<td>Email</td>
							</tr>
						</table>
						<textarea onclick="$(this).select();" rows="4" readonly="readonly" class="span4" id="fld_contato_fones"></textarea>
						<textarea onclick="$(this).select();" rows="4" readonly="readonly" class="span4" id="fld_contato_emails"></textarea>
					</div>
					<br>
					<button type="button" id="btn-edita-contato" data-id-chamada="<?php echo $this->data['Chamada']['id']; ?>" class="btn"><i class="icon-pencil"></i> Editar Contato</button>
					<button type="button" class="btn" data-toggle="modal" data-target="#modal-novo-contato"><i class="icon-plus-sign"></i> Contato</button>
					<button type="button" class="btn" data-toggle="modal" data-target="#modal-novo-telefone"><i class="icon-plus-sign"></i> Telefone</button>
					<button type="button" class="btn" data-toggle="modal" data-target="#modal-novo-email"><i class="icon-plus-sign"></i> Email</button>
				</div>
			</div>
			<?php //echo $this->Bootstrap->session('Pedido', 'Projeto', 'projeto_id', $belongsTo['Projeto'], null, $sess_controls['Projeto']['id'], $sess_controls['Projeto']['texto']); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'projeto_id', 'label'=>'Projeto', 'bt_model'=>'Projeto','search'=>false,'url'=>'projetos' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'tipo_chamada_id', 'label'=>'Tipo de Chamada', 'bt_model'=>'TiposChamada','search'=>false,'url'=>'tipos_chamadas' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'assunto_id', 'label'=>'Assunto', 'bt_model'=>'Assunto','search'=>false,'url'=>'assuntos' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/datetime', array('field' => 'data_inicio', 'label'=>'Data Início', 'value'=>'now' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/datetime', array('field' => 'data_fim', 'label'=>'Data Fim', 'readonly'=>true  ) ); ?>
			<?php echo $this->Element('Forms/BSControls/textarea', array('field' => 'solicitacao', 'label'=>'Solicitação'  ) ); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'prioridade_id', 'label'=>'Prioridade', 'bt_model'=>'Prioridade','search'=>false,'url'=>'prioridades' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'pedido_id', 'label'=>'Pedido', 'bt_model'=>'Pedido', 'search'=>true, 'url'=>'pedidos' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'status_id', 'label'=>'Status', 'bt_model'=>'Status', 'search'=>false, 'url'=>'status' ) ); ?>

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
					<tbody class="chamadas_table">
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
		console.log('ini');
		$('#bt-save-end').click(function(){
			$('#fld_status_id').val(3);
			$('#fld_finalizando').val(1);
			$('#form_Chamada').submit();
		});
	});
</script>
