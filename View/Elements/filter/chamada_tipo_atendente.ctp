	<?php
		$filter_situacao = (isset($filter['situacao']))?($filter['situacao']):('0');
		$filter_atendente = (isset($filter['atendente']))?($filter['atendente']):('0');
	?>
	<select rel="tooltip" title="Situação" name="data[filter][situacao]" class="span2 filter_situacao">
		<option value="0" <?php echo ($filter_situacao=='0')?('selected="selected"'):('');?>>Todas</option>
		<option value="aberto" <?php echo ($filter_situacao=='aberto')?('selected="selected"'):('');?>>Em Aberto</option>
	</select>
	<select rel="tooltip" title="Atendente" name="data[filter][atendente]" class="filter_atendente">
		<option value="0" <?php echo ($filter_atendente=='0')?('selected="selected"'):('');?>>Todos</option>
		<option value="eu" <?php echo ($filter_atendente=='eu')?('selected="selected"'):('');?>>Abertas por mim...</option>
	</select>
