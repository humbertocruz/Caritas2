<form class="form-horizontal" method="post">
	<input type="hidden" name="data[Pedido][id]" value="<?php echo (isset($this->data['Pedido']['id']))?($this->data['Pedido']['id']):('');?>">
	<input type="hidden" id="cancel_input_Pedido" name="data[System][cancel]" value="0">
	<input type="hidden" name="data[System][here]" value="<?php echo $this->here ; ?>">
	<input type="hidden" name="data[System][controller]" value="Pedidos">
	<input type="hidden" name="data[continue]" id="ped-continue" value="0">
	<input type="hidden" name="data[System][finalize]" id="ped-finalize" value="0">
	<input type="hidden" name="data[Pedido][atendente_id]" value="<?php echo $this->Session->read('Auth.User.Atendente.id'); ?>">
<div class="row">
	<div class="span12">
		<?php echo $this->Bootstrap->instituicao('Pedido', 'Instituição', 'instituicao_id',
			array('Estado'=>$belongsTo['Estado'],'Cidade'=>$belongsTo['Cidade'],'Instituicao'=>$belongsTo['Instituicao'])); ?>
	</div>
</div>
<div class="row">
	<div class="span5">
		<?php echo $this->Bootstrap->date_time(
			array(
				'model' => 'Pedido',
				'label' => 'Data Início',
				'name' => 'data_inicio',
				'now' => true
			)
		); ?>
	</div>
	<div class="span5">
		<?php echo $this->Bootstrap->date_time(
			array(
				'model' => 'Pedido',
				'label' => 'Data Fim',
				'name' => 'data_fim',
				'now' => false,
				'readonly' => true
			)
		); ?>
	</div>
	<div class="span2"></div>
</div>
<div class="row">
	<div class="span12">
		<?php echo $this->Bootstrap->session('Pedido', 'Projeto', 'projeto_id', $belongsTo['Projeto'], null, $sess_controls['Projeto']['id'], $sess_controls['Projeto']['texto']); ?>
		<?php echo $this->Bootstrap->belongsTo('Pedido', 'Tipo de Pagamento', 'tipo_pagamento_id', $belongsTo['TiposPagamento'], 'tipos_pagamentos'); ?>
		<?php echo $this->Bootstrap->text(
			array(
				'model' => 'Pedido',
				'label' => 'Convênio',
				'name' => 'convenio'
			)); ?>
		<?php echo $this->Bootstrap->belongsTo('Pedido', 'Edital', 'edital_id', $belongsTo['Edital'], 'editais'); ?>
		<?php echo $this->Bootstrap->belongsTo('Pedido', 'Distribuidor', 'distribuidor_id', $belongsTo['Distribuidor'], 'distribuidores'); ?>
		<?php echo $this->Bootstrap->textarea('Pedido', 'Observação', 'observacao'); ?>
		<?php echo $this->Bootstrap->belongsTo('Pedido', 'Status', 'status_id', $belongsTo['Status'], 'status'); ?>
	</div>
</div>
		<div class="form-actions">
			<input type="submit" class="btn btn-primary" value="Salvar">
			<input onclick="$('#ped-continue').val('1');" type="submit" class="btn btn-success" value="Gravar e Continuar">
			<input onclick="$('#ped-finalize').val('1');" type="submit" class="btn btn-danger" value="Gravar e Finalizar">
			<a href="/pedidos" class="btn">Cancelar</a>
		</div>
</form>

