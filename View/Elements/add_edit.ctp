<div class="page-header">
	<h3><?php echo $header; ?></h3>
	<?php if (isset($this->data[$model]['id'])) { 
		foreach($del_info as $k=>$v) {
		?>
		<h5><?php if(isset($this->data[$k][$v])) echo $this->data[$k][$v];?></h5>
	<?php } } ?>
</div>
<?php
if (!isset($forms['template'])) {
	$forms['template'] = 'default'; 
}
$actionModel = str_replace('add', '', $this->params->action);
$actionModel = str_replace('edit', '', $actionModel);

if (isset($source[$actionModel])) {
	$model = $actionModel;
	$forms['fields'] = $source[$actionModel];
}

if ($forms[$model]['template'] == 'tabs') {
	$hasMany = (isset($forms[$model]['hasMany']) ? $forms[$model]['hasMany'] : array() );
	$oneMany = (isset($forms[$model]['oneMany']) ? $forms[$model]['oneMany'] : array() );
	$habtMany = (isset($forms[$model]['habtMany']) ? $forms[$model]['habtMany'] : array() );
	
	echo $this->Element('Forms/tabs', array('model'=>$model, 'controller'=>$controller, 'fields'=>$forms[$model]['fields'],'hasMany'=>$hasMany,'oneMany'=>$oneMany, 'habtMany'=>$habtMany));
} else {
	echo $this->Element('Forms/generic', array('model'=>$model, 'controller'=>$controller, 'fields'=>$forms[$model]['fields']));
}
?>
<div class="modal fade hide" id="linkModal">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Campos Alterados!</h3>
	</div>
	<div class="modal-body">
		Os dados do formulário foram alterados, saindo agora essas alterações serão perdidas.<br>
		<br>
		Tem certeza ?
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<a href="#" id="link-confirmation" class="btn btn-primary">Seguir Link</a>
		</form>
	</div>
</div>
<script >
	$('document').ready(function() {
		var changed = false;
		$(':input').change(function() {
			changed = true;
		});
		$('.navbar .nav a[href!=#]').click(function(){
			if (changed == true) {
				$('#link-confirmation').attr('href',$(this).attr('href'));
				$('#linkModal').modal('show');
				return false;
			}
		});
	});
</script>
