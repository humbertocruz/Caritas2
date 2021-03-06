	<?php
		$filter_uf = ($this->Session->check('sessLoadEstado'))?($this->Session->read('sessLoadEstado')):('0');
		$filter_cidade = ($this->Session->check('sessLoadCidade'))?($this->Session->read('sessLoadCidade')):('0');
	?>
	<select rel="tooltip" title="Estado" name="data[filter][uf]" class="span1 filter_uf_for">
		<option value="0">Selecione</option>
		<?php foreach ($filter_data['Estado'] as $estado) { ?>
		<option <?php if ($estado['Estado']['id'] == $filter_uf) echo 'selected="selected"'; ?> value="<?php echo $estado['Estado']['id'];?>"><?php echo $estado['Estado']['id'];?></option>
		<?php } ?>
	</select>
	<select rel="tooltip" title="Cidade" name="data[filter][cidade]" class="filter_cidade_for" data-search-cidade="<?php echo $filter_cidade; ?>">
		<option value="0">Selecione</option>
	</select>
	<script>
	$(document).ready(function() {
		estado = $('.filter_uf_for').val();
		cidade = $('.filter_cidade_for').data('search-cidade');
		$.get('/systems/cidade/'+estado+'/'+cidade, function(data){
			$('.filter_cidade_for').html(data);
			$('.filter_cidade_for').change();
		});
		$('.filter_uf_for').change(function(){
			estado = $(this).val();
			$.get('/systems/cidade/'+estado+'/'+cidade, function(data){
				$('.filter_cidade_for').html(data);
				$('.filter_cidade_for').change();
			});
		});
		$('.filter_cidade_for').change(function(){
			cidade = $(this).val();
			$('#fld_cidade_id').val(cidade);
			$.get('/systems/fornecedor/'+cidade, function(data){
				$('#fld_fornecedor_id').html(data);
				$('#fld_fornecedor_id').change();
			});
		});
	});
	</script>
