<div class="page-header">
	<h3>Atendimentos</h3>
</div>
<form class="form-search frm-atendimentos" method="post">
<div class="alert alert-info">
	<h3>Pesquisa...</h3>
		<input type="text" class="span4" name="data[search][text]" value="<?php echo (isset($this->data['search']['text']))?($this->data['search']['text']):(''); ?>">
		<input class="btn" type="submit" value="Buscar">
</div>
<div class="alert alert-danger">
	<h3>Contatos
	<span class="pull-right"><?php echo (isset($contatos))?(count($contatos)):(''); ?></span>
	</h3>
	<div class="scroller" style="max-height: 400px; overflow: auto;">
	<?php if(isset($contatos)) { ?>
	<table class="table table-bordered" style="background-color: #fff;">
		<thead>
			<tr>
				<th class="span1">&nbsp;</th>
				<th>Nome</th>
			</tr>
		</thead>
		<tbody>
				<?php foreach($contatos as $contato) {
				$selected = (isset($this->data['search']['contato_id']) && $this->data['search']['contato_id'] == $contato['Contato']['id'])?('checked="checked"'):('');
				?>
			<tr>
				<td><input <?php echo $selected; ?> onclick="$('.frm-atendimentos').submit();" type="radio" name="data[search][contato_id]" value="<?php echo $contato['Contato']['id']; ?>"></td>
				<td><?php echo $contato['Contato']['nome']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
	</div>
</div>
<div class="alert">
	<h3>Instituições / Fornecedores
	<span class="pull-right"><?php echo (isset($instituicoes))?(count($instituicoes)):(''); ?></span>
	</h3>
	<div class="scroller" style="max-height: 400px; overflow: auto;">
	<?php if(isset($instituicoes)) { ?>
	<table class="table table-bordered" style="background-color: #fff;">
		<thead>
			<tr>
				<th class="span1">&nbsp;</th>
				<th>Nome Fantasia</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($instituicoes as $instituicao) {
			$selected = (isset($this->data['search']['instituicao_id']) && $this->data['search']['instituicao_id'] == $instituicao['Instituicao']['id'])?('checked="checked"'):('');
			?>
			<tr>
				<td><input <?php echo $selected; ?> onclick="$('.frm-atendimentos').submit();" type="radio" name="data[search][instituicao_id]" value="<?php echo $instituicao['Instituicao']['id']; ?>"></td>
				<td><?php echo $instituicao['Instituicao']['nome_fantasia']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php } ?>
	</div>
</div>
<div class="alert alert-success">
	<h3>Chamadas</h3>
	<span class="pull-right"><?php echo (isset($chamadas))?(count($chamadas)):(''); ?></span>
	</h3>
	<div class="scroller" style="max-height: 400px; overflow: auto;">
	<?php if(isset($chamadas)) { ?>
	<table class="table table-bordered" style="background-color: #fff;">
		<thead>
			<tr>
				<th>Dia / Hora</th>
				<th>Solicitação</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($chamadas as $chamada) { ?>
			<tr>
				<td><?php echo date('d/m/Y H:i', strtotime( $chamada['Chamada']['data_inicio'] ) );?></td>
				<td><?php echo $chamada['Chamada']['solicitacao'];?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
	<?php } ?>
</div>
</form>
