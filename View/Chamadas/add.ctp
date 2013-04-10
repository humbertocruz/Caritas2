<?php
$sess_models = AppController::_sess_models();
?>
<div class="page-header">
	<h3>Nova Chamada</h3>
	<?php echo (isset($instituicao_pedido))?('<h4>'.$instituicao_pedido.'</h4>'):(''); ?>
</div>
<form class="form-vertical" method="post" id="form_Chamada">
	<input type="hidden" id="cancel_input_Chamada" name="data[System][cancel]" value="0">
	<input type="hidden" name="data[System][here]" value="/chamadas/add">
	<input type="hidden" name="data[System][controller]" value="Chamadas">
	<input type="hidden" name="data[System][pedido_id]" value="<?php echo $pedido_id; ?>">	
	<input type="hidden" name="data[Chamada][id]" value="0">
	<input type="hidden" name="data[continue]" id="inp-continue" value="0">

	<input type="hidden" name="data[Chamada][chamada_id]" value="<?php echo (isset($this->data['Chamada']['chamada_id']))?($this->data['Chamada']['chamada_id']):(0);?>">
	<input type="hidden" name="data[Chamada][projeto_id]" value="<?php echo $sess_models['Projetos']['id'];?>">
	<input type="hidden" name="data[Chamada][atendente_id]" value="<?php echo $sess_models['Atendentes']['id'];?>">
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
			<?php echo $this->Element('Chamadas/tabContato'); ?>
			<?php //echo $this->Bootstrap->session('Chamada', 'Projeto', 'projeto_id', $belongsTo['Projeto'], null, $sess_controls['Projeto']['id'], $sess_controls['Projeto']['texto']); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'projeto_id', 'label'=>'Projeto', 'bt_model'=>'Projeto','search'=>false,'url'=>'projetos', 'ini_value'=>$sess_models['Projetos']['id'] ) ); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'tipo_chamada_id', 'label'=>'Tipo de Chamada', 'bt_model'=>'TiposChamada','search'=>false,'url'=>'tipos_chamadas' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/datetime', array('field' => 'data_inicio', 'label'=>'Data Início', 'value'=>'now' ) ); ?>
			<?php echo $this->Element('Forms/BSControls/datetime', array('field' => 'data_fim', 'label'=>'Data Fim', 'readonly'=>true  ) ); ?>
			<?php echo $this->Element('Forms/BSControls/belongsTo', array('field' => 'assunto_id', 'label'=>'Assunto', 'bt_model'=>'Assunto','search'=>false,'url'=>'assuntos' ) ); ?>
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
		<?php if (!isset($this->data['Chamada']['chamada_id'])) { ?>
		<input type="submit" class="btn btn-success bt-savecontinue" value="Gravar e Continuar">
		<?php } ?>
		<input type="button" class="btn btn-danger" value="Gravar e Finalizar">
		<?php
		if ($pedido_id != 0) { ?>
			<a href="/pedidos/edit/<?php echo $pedido_id;?>#tabChamada" class="btn">Cancelar</a>
		<?php } else { ?>
			<a href="/chamadas" class="btn">Cancelar</a>
		<?php } ?>
	</div>

</form>

<div class="modal hide fade" id="modal-novo-contato">
	<form method="post" id="frm-addContato" class="form-vertical">
	<input type="hidden" id="fld_contato_instituicao_id" name="data[ContatosInstituicao][instituicao_id]" value="0">
	<input type="hidden" id="fld_contato_fornecedor_id" name="data[ContatosFornecedor][fornecedor_id]" value="0">
	<input type="hidden" id="fld_cidade_id" name="data[Cidade][id]" value="0">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Novo Contato</h3>
	</div>
		<div class="modal-body">
				<div class="control-group ">
					<label class="control-label" for="fld_nome">Nome</label>
					<div class="controls">
						<input type="text" class="span4" id="fld_nome" name="data[Contato][nome]" value="">
					</div>
				</div>
				<div class="control-group ">
					<label class="control-label" for="fld_cpf">CPF</label>
					<div class="controls">
						<input type="text" class="span4" id="fld_cpf" name="data[Contato][cpf]" value="">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="ctrl_date_data_nascimento">Data de Nascimento</label>
					<div class="controls">
						<div class="input-append date" data-date="<?php echo date('d/m/Y');?>" data-date-format="dd/mm/yyyy" id="ctrl_date_data_nascimento">
							<input class="span4" type="text" name="data[Contato][data_nascimento]" value="">
							<span class="add-on"><i class="icon-calendar"></i></span>
						</div>
					</div>
				</div>
				<script>
					$('#ctrl_date_data_nascimento').datepicker();
				</script>
				<div class="control-group" id="ctrl-sexo_id">
					<label class="control-label" for="fld_sexo_id">Sexo</label>
					<div class="controls">
						<select class="span4" id="fld_sexo_id" name="data[Contato][sexo_id]">
							<?php foreach($addContatoSexo as $sexo) { ?>
							<option value="<?php echo $sexo['Sexo']['id'];?>"><?php echo $sexo['Sexo']['nome'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="control-group" id="ctrl-cargo_id">
					<label class="control-label" for="fld_cargo_id">Cargo</label>
					<div class="controls">
						<select class="span4" id="fld_cargo_id" name="data[ContatosInstituicao][cargo_id]">
							<?php foreach($addContatoCargo as $cargo) { ?>
							<option value="<?php echo $cargo['Cargo']['id'];?>"><?php echo $cargo['Cargo']['nome'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="control-group" id="ctrl-situacao_id">
					<label class="control-label" for="fld_situacao_id">Situação</label>
					<div class="controls">
						<select class="span4" id="fld_situacao_id" name="data[ContatosInstituicao][situacao_contato_id]">
							<?php foreach($addContatoSituacao as $situacao) { ?>
							<option value="<?php echo $situacao['SituacoesContato']['id'];?>"><?php echo $situacao['SituacoesContato']['nome'];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Fechar</a>
			<a href="#" id="bt-addContato" class="btn btn-primary">Gravar</a>
		</div>
	</form>
</div>

<div class="modal hide fade" id="modal-novo-telefone">
	<form method="post" id="frm-addContatoFone" class="form-vertical">
	<input type="hidden" id="fld_addFone_contato_id" name="data[ContatosFone][contato_id]" value="0">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Novo Telefone de Contato</h3>
		<div class="modal-body">
			<div class="control-group ">
				<label class="control-label" for="fld_nome">Telefone</label>
				<div class="controls">
					<input type="text" class="span4" id="fld_fone" name="data[ContatosFone][fone]" value="">
				</div>
			</div>
			<div class="control-group" id="ctrl-sexo_id">
				<label class="control-label" for="fld_tipo_fone_id">Tipo de Telefone</label>
				<div class="controls">
					<select class="span4" id="fld_tipo_fone_id" name="data[ContatosFone][tipo_fone_id]">
						<?php foreach($addContatoTiposFone as $fone) { ?>
						<option value="<?php echo $fone['TiposFone']['id'];?>"><?php echo $fone['TiposFone']['nome'];?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Fechar</a>
			<a href="#" id="bt-addContatoFone" class="btn btn-primary">Gravar</a>
		</div>
	</div>
	</form>
</div>

<div class="modal hide fade" id="modal-novo-email">
	<form method="post" id="frm-addContatoEmail" class="form-vertical">
	<input type="hidden" id="fld_addEmail_contato_id" name="data[ContatosEmail][contato_id]" value="0">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Novo Email de Contato</h3>
		<div class="modal-body">
			<div class="control-group ">
				<label class="control-label" for="fld_nome">Email</label>
				<div class="controls">
					<input type="text" class="span4" id="fld_email" name="data[ContatosEmail][email]" value="">
				</div>
			</div>
			<div class="control-group" id="ctrl-email_id">
				<label class="control-label" for="fld_tipo_email_id">Tipo de Email</label>
				<div class="controls">
					<select class="span4" id="fld_tipo_email_id" name="data[ContatosEmail][tipo_email_id]">
						<?php foreach($addContatoTiposEmail as $email) { ?>
						<option value="<?php echo $email['TiposEmail']['id'];?>"><?php echo $email['TiposEmail']['nome'];?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Fechar</a>
			<a href="#" id="bt-addContatoEmail" class="btn btn-primary">Gravar</a>
		</div>
	</div>
	</form>
</div>

<script>
	$(document).ready(function(){
		var contatos_instituicao = new Array();
				
		$('.btns').button();
		$('.btI').click(function(){
			$('.opt-fornecedor').addClass('hide');
			$('.opt-instituicao').removeClass('hide');
			$('#fld_instituicao_id').change();
		});
		$('.btF').click(function(){
			$('.opt-instituicao').addClass('hide');
			$('.opt-fornecedor').removeClass('hide');
			$('#fld_fornecedor_id').change();
		});
		$('.bt-savecontinue').click(function() {
			$('#inp-continue').val(1);
		});
		$('#fld_instituicao_id').change(function(){
			contatos_from('instituicao');
			chamadas_from('instituicao');
		});
		$('#fld_fornecedor_id').change(function(){
			contatos_from('fornecedor');
			chamadas_from('fornecedor');
		});
		function chamadas_from(deonde) {
			if ($('#fld_'+deonde+'_id').val() != null) {
				$.ajax({
					'url':'/chamadas/carrega_chamadas/'+deonde+'/'+$('#fld_'+deonde+'_id').val(),
					'success': function(data) {
						$('.chamadas_table').html(data);
					}
				});
			}
		}

		function contatos_from(deonde) {
			contato_id = 0;
			if ($('#fld_'+deonde+'_id').val() != null) {
				$.ajax({
					'dataType':'html',
					'url':'/chamadas/contatos_from/'+deonde+'/'+$('#fld_'+deonde+'_id').val(),
					'success': function(data) {
						$('#list-contatos').html(data);
						contato_show_table();
					}
				});
			}
		}
		$('#ChamadasTab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});

		function contato_show_table() {
			$('.contato-table').hide();
			contato_id = $('#contato-select').val();
			$('#contato-table-'+contato_id).show();
		}

		$('#contato-select').live('change', function() {
			contato_show_table(); 
		} );
		
		contato_show_table();
	
	});
</script>
