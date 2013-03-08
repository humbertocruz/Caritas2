	<?php
		$filter_uf = (isset($filter['uf']))?($filter['uf']):('0');
		$filter_cidade = (isset($filter['cidade']))?($filter['cidade']):('0');
	?>
	<select rel="tooltip" title="Estado" name="data[filter][uf]" class="span1 filter_uf">
		<option value="0">Todos</option>
		<?php foreach ($filter_data['Estado'] as $estado) { ?>
		<option <?php if ($estado['Estado']['id'] == $filter_uf) echo 'selected="selected"'; ?> value="<?php echo $estado['Estado']['id'];?>"><?php echo $estado['Estado']['id'];?></option>
		<?php } ?>
	</select>
	<select rel="tooltip" title="Cidade" name="data[filter][cidade]" class="filter_cidade" data-search-cidade="<?php echo $filter_cidade; ?>">
		<option value="0">Todas</option>
	</select>
	<script>
	$(document).ready(function() {
		estado = $('.filter_uf').val();
		cidade = $('.filter_cidade').data('search-cidade');
		$.get('/systems/cidade/'+estado+'/'+cidade, function(data){
			$('.filter_cidade').html(data);
		});
		$('.filter_uf').change(function(){
			estado = $(this).val();
			$.get('/systems/cidade/'+estado+'/'+cidade, function(data){
				$('.filter_cidade').html(data);
			});
		});
	});
	</script>
