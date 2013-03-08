<form method="post">
	<input type="hidden" name="data[id]" value="<?php echo (isset($this->data[$model]['id']) ? $this->data[$model]['id'] : ''); ?>">
	<fieldset>
		<legend><?php echo $model; ?></legend>
		<div class="control-group">
			<label class="control-label" for="nome">Data</label>
			<div class="controls">
				<input type="text" id="nome" name="data[data]" value="<?php echo (isset($this->data[$model]['data']) ? $this->data[$model]['data'] : ''); ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" id="nome" name="data[nome]" value="<?php echo (isset($this->data[$model]['nome']) ? $this->data[$model]['nome'] : ''); ?>">
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="nome">Edital</label>
			<div class="controls">
				<select id="edita_id" name="data[edital_id]" value="<?php echo (isset($this->data[$model]['edital_id']) ? $this->data[$model]['edital_id'] : ''); ?>">
				<?php foreach($editais as $edital) { ?>
					<option value="<?php echo $edital['id'];?>"><?php echo $edital['nome'];?></option>
				<?php } ?>
				</select>
			</div>
		</div>

	</fieldset>
	<fieldset class="form-actions">
		<input type="submit" value="Gravar" class="btn btn-primary">
		<a href="/<?php echo $controller; ?>/index" class="btn">Cancelar</a>
	</fieldset>
</form>