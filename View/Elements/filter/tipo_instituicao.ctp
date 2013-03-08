	<?php
		$filter_tipo_instituicao = (isset($filter['tipo_instituicao']))?($filter['tipo_instituicao']):(0);
	?>
	<select rel="tooltip" title="Tipo de Instituição" name="data[filter][tipo_instituicao]">
		<option value="0">Todas</option>
		<?php foreach ($filter_data['TiposInstituicao'] as $tipo) { ?>
		<option <?php if ($tipo['TiposInstituicao']['id'] == $filter_tipo_instituicao) echo 'selected="selected"'; ?> value="<?php echo $tipo['TiposInstituicao']['id'];?>"><?php echo $tipo['TiposInstituicao']['nome'];?></option>
		<?php } ?>
	</select>
