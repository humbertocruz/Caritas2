<div class="page-header">
	<h3>Edita Chamada</h3>
</div>
<ul class="nav nav-tabs" id="ChamadasTab">
	<li class="active"><a href="#tabChamada">Chamada</a></li>
	<li><a href="#tabProcedimentos">Procedimentos</a></li>
	<?php if ($this->data['Chamada']['chamada_id'] == 0) { ?>
	<li><a href="#tabFilhas">Chamadas Filhas</a></li>
	<?php } ?>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tabChamada">
		<?php echo $this->Element('Chamadas/tabChamada'); ?>
	</div>
	<div class="tab-pane" id="tabProcedimentos">
		<?php echo $this->Element('Chamadas/tabProcedimentos'); ?>
	</div>
	<?php if ($this->data['Chamada']['chamada_id'] == 0) { ?>
	<div class="tab-pane" id="tabFilhas">
		<?php echo $this->Element('Chamadas/tabFilhas'); ?>
	</div>
	<?php } ?>
</div>

<div class="modal hide fade" id="modal-novo-contato">
	<form method="post" id="frm-addContato" class="form-vertical">
	<input type="hidden" id="fld_contato_instituicao_id" name="data[ContatosInstituicao][instituicao_id]" value="0">
	<input type="hidden" id="fld_contato_fornecedor_id" name="data[ContatosFornecedor][fornecedor_id]" value="0">
	<input type="hidden" id="fld_cidade_id" name="data[Cidade][id]" value="0">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Novo Contato</h3>
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
</div>

<div class="modal hide fade" id="modal-edita-contato">
	<form method="post" id="frm-addContato" class="form-vertical">
	<input type="hidden" id="fld_contato_instituicao_id" name="data[ContatosInstituicao][instituicao_id]" value="0">
	<input type="hidden" id="fld_contato_fornecedor_id" name="data[ContatosFornecedor][fornecedor_id]" value="0">
	<input type="hidden" id="fld_cidade_id" name="data[Cidade][id]" value="0">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Edita Contato</h3>
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
		//var chamada_id = <?php echo $chamada_id; ?>;
		
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
		});
		function chamadas_from(deonde) {
			return false;
			if ($('#fld_'+deonde+'_id').val() != null) {
				$.ajax({
					'url':'/chamadas/carrega_chamadas/'+deonde+'/'+$('#fld_'+deonde+'_id').val(),
					'success': function(data) {
						$('.chamadas_table').html(data);
						$('#fld_contato_id').change();
					}
				});
			}
		}
		$('#fld_contato_id').change(function(){
			atualiza_edita_contato( $(this).val() );
			//contatos_fones();
			//contatos_emails();
		});
		
		function atualiza_edita_contato(value){
			$('#btn-edita-contato').data('idContatoInstituicao', value);
		}

		function contatos_from(deonde) {
			contato_id = <?php echo $this->data['Chamada']['contato_id']; ?>;
			if ($('#fld_'+deonde+'_id').val() != null) {
				$.ajax({
					'dataType':'html',
					'url':'/chamadas/contatos_from/'+deonde+'/'+$('#fld_'+deonde+'_id').val(),
					'success': function(data) {
						console.log(data);
						$('#contatos-table').html(data);
						//$('#btn-edita-contato').data('idContato', parseInt( data[0]['Contato']['id'] ));
						$('#fld_contato_id').change();
					}
				});
			}
		}
		/*
		$('#btn-edita-contato').click(function(){
			//location.href = 'system/belongsTo/'. encodeURI( 'contatos/edit/'+$(this).data('idContato')+'/'+$(this).data('idChamada') );
			$('form#form_Chamada').attr('action','/systems/belongsTo/form_data' );
			$('form#form_Chamada').prepend('<input type="hidden" name="data[form_data]" value="/contatos/edit/'+$(this).data('idContatoInstituicao')+'/'+$(this).data('idChamada')+'">');
			$('form#form_Chamada').submit();
		});
		
		$('#bt-addContato').click(function() {
			$('#fld_contato_instituicao_id').val( $('#fld_instituicao_id').val() );
			$.ajax({
				'url':'/chamadas/addContatoChamada',
				'data':$('#frm-addContato').serialize(),
				'type':'POST',
				'success': function(data){
					$('#modal-novo-contato').modal('hide');
					$('#fld_instituicao_id').change();
				}
			});
		});
		$('#bt-addContatoFone').click(function() {
			$('#fld_addFone_contato_id').val( $('#fld_contato_id').val() );
			$.ajax({
				'url':'/chamadas/addContatoFone',
				'data':$('#frm-addContatoFone').serialize(),
				'type':'POST',
				'success': function(data){
					$('#modal-novo-telefone').modal('hide');
					$('#fld_contato_id').change();
				}
			});
		});
		$('#bt-addContatoEmail').click(function() {
			$('#fld_addEmail_contato_id').val( $('#fld_contato_id').val() );
			$.ajax({
				'url':'/chamadas/addContatoEmail',
				'data':$('#frm-addContatoEmail').serialize(),
				'type':'POST',
				'success': function(data){
					$('#modal-novo-email').modal('hide');
					$('#fld_contato_id').change();
				}
			});
		});
		*/
		$('#ChamadasTab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
		
		/*

		function contatos_fones() {
			$.ajax({
				'dataType':'json',
				'url':'/chamadas/contatos_fones/'+$('#fld_contato_id').val(),
				'success': function(data) {
					var fones = '';
					$.each(data, function(i, item) {
						fones+= item['ContatosFone']['fone']+' - '+item['TiposFone']['nome']+'\n';
					});
					$('#fld_contato_fones').val(fones);
				}
			});
		}
		function contatos_emails() {
			$.ajax({
				'dataType':'json',
				'url':'/chamadas/contatos_emails/'+$('#fld_contato_id').val(),
				'success': function(data) {
					var emails = '';
					$.each(data, function(i, item) {
						emails+= item['ContatosEmail']['email']+'\n';
					});
					$('#fld_contato_emails').val(emails);
				}
			});
		}
		*/
	});
</script>
