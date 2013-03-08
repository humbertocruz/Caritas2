<div class="page-header clearfix">
	<h2>Procedimentos</h2>
</div>

<div id="ChamadasProcedimento-msg">
</div>

<div class="form-actions">
	<a href="#" data-id="" class="btn btn-primary bt-add-procedimento"><i class="icon-plus icon-white"></i> Novo Procedimento</a>
</div>

<table class="table table-bordered">
	<thead class="alert-info">
		<tr>
			<th>Data</th>
			<th>Procedimento</th>
			<th class="span3">&nbsp;</th>
		</tr>
	</thead>
	<tbody id="chamada_procedimento_list">
		<?php foreach($hasMany['ChamadasProcedimento'] as $row) { ?>
		<tr data-data="<?php echo date('d/m/Y', strtotime($row['ChamadasProcedimento']['data']));?>" data-id="<?php echo $row['ChamadasProcedimento']['id'];?>" data-procedimento-id="<?php echo $row['Procedimento']['id'];?>">
			<td><?php echo date('d/m/Y', strtotime($row['ChamadasProcedimento']['data']));?></td>
			<td><?php echo $row['ChamadasProcedimento']['procedimento'];?></td>
			<td>
				<a href="#" class="btn bt_edit_procedimento">Editar</a>
				<a href="#" class="btn bt_del_procedimento">Excluir</a>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<div class="form-actions">
	<a href="#" data-id="" class="btn btn-primary bt-add-procedimento"><i class="icon-plus icon-white"></i> Novo Procedimento</a>
</div>
<script>
	$(document).ready(function(){
		$('.bt_edit_procedimento').live('click', function(){
			linha = $(this).parents('tr');
			$('#fld_procedimento_id').val($(linha).data('id'));
			$('#fld_procedimento_data').val($(linha).data('data'));
			$('#fld_procedimento_tipo').val($(linha).data('procedimento-id')).change();
			$('#modal_edit_procedimento').modal('show');
		});
		$('.bt-add-procedimento').live('click', function(){
			date_time = new Date();
			day = date_time.getDate();
			if (day < 10) day = '0'+day;
			month = date_time.getMonth()+1;
			if (month < 10) month = '0'+month;
			date_formated = day+'/'+month+'/'+date_time.getFullYear();
			$('#fld_procedimento_id').val(0);
			$('#fld_procedimento_data').val(date_formated);
			$('#fld_procedimento_tipo').val(0).change();
			$('#modal_edit_procedimento').modal('show');
		});
		$('#fld_procedimento_tipo').change(function(){
			item = this.options[this.selectedIndex];
			$('#fld_procedimento_desc').val($(item).data('desc'));
		});
		$('#bt-addProcedimento').click(function(){
			console.log($('#modal_remove_procedimento form').serialize());
			
			$.ajax({
				url: '/chamadas/edit_chamadas_procedimento',
				type: 'post',
				data: $('#modal_edit_procedimento form').serialize(),
				success: function(data){
					reload_procedimentos(data, <?php echo $this->data['Chamada']['id'];?>);
				}
			});
		});
		$('.bt_del_procedimento').live('click', function(){
			$('#fld_exc_procedimento').val($(this).parents('tr').data('id'));
			$('#modal_remove_procedimento').modal('show');
		});
		$('#bt-ConfExcProcedimento').click(function(){
			$.ajax({
				type: 'post',
				url: '/chamadas/del_chamadas_procedimento',
				data: $('#modal_remove_procedimento form').serialize(),
				success: function(data) {
					reload_procedimentos(data, <?php echo $this->data['Chamada']['id'];?>);
				}
			});
		});
		
		function reload_procedimentos(msg, chamada_id) {
			$('.modal').modal('hide');
			$('#ChamadasProcedimento-msg').html('<div class="alert">'+msg+'</div>');
			$.ajax({
				type: 'get',
				url: '/chamadas/reload_chamadas_procedimento/'+chamada_id,
				success: function(data) {
					$('#chamada_procedimento_list').html(data);
				}
			});
		}
	});
</script>
<div class="modal hide fade" id="modal_remove_procedimento">
	<form>
	<input type="hidden" id="fld_exc_procedimento" name="data[ChamadasProcedimento][id]" value="0">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">x</button>
		<h3>Excluir Procedimento</h3>
	</div>
	<div class="modal-body">
	<p>Tem Certeza que deseja excluir este Procedimento ?</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<a href="#" id="bt-ConfExcProcedimento" class="btn btn-danger">Excluir</a>
	</div>
	</form>
</div>
<div class="modal hide fade" id="modal_edit_procedimento">
	<form method="post">
		<input type="hidden" id="fld_procedimento_id" name="data[ChamadasProcedimento][id]" value="0">
		<input type="hidden" name="data[ChamadasProcedimento][chamada_id]" value="<?php echo $this->data['Chamada']['id'];?>">
		<input type="hidden" name="data[ChamadasProcedimento][atendente_id]" value="<?php echo $sess_models['Atendentes']['id'];?>">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">x</button>
			<h3>Procedimento</h3>
		</div>
		<div class="modal-body">
			<div class="control-group">
				<label class="control-label">Data</label>
				<div class="controls">
					<div class="input-append date">
						<input type="text" class="date span2" id="fld_procedimento_data" name="data[ChamadasProcedimento][data]">
						<span class="add-on">
							<i class="icon-calendar"></i>
						</span>	
					</div>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Tipo de Procedimento</label>
				<div class="controls">
					<select class="span4" id="fld_procedimento_tipo" name="data[ChamadasProcedimento][procedimento_id]">
						<option value="0">Selecione o Procedimento</option>
						<?php foreach ($addChamadaProcedimentos as $row) { ?>
						<option data-desc="<?php echo $row['Procedimento']['descricao'];?>" value="<?php echo $row['Procedimento']['id'];?>"><?php echo $row['Procedimento']['nome'];?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label">Procedimento</label>
				<div class="controls">
					<textarea class="span4" id="fld_procedimento_desc" rows="4" name="data[ChamadasProcedimento][procedimento]"></textarea>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Fechar</a>
			<a href="#" id="bt-addProcedimento" class="btn btn-primary">Gravar</a>
		</div>
	</form>
</div>
