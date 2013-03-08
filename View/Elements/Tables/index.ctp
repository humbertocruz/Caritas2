<div class="page-header clearfix">
	<h2><?php echo $header; ?></h2>
</div>
<div class="row">
	<div class="span12">
		<form method="post" class="form-inline">
			<input type="hidden" name="data[filter][clear]" value="0" class="filter_clear_fld">
			<?php if( isset($filter_form)) {
				foreach($filter_form as $filter) {
					echo $this->Element($filter, array('filter'=>$this->Session->read('filter')));
				}
			}
			$search_value = ($this->Session->check('filter'))?($this->Session->read('filter')):(array());
			if (isset($search_value['search'])) $search_value = $search_value['search']; else $search_value = '';
			?>
			
			<input name="data[filter][search]" type="text" placeholder="pesquise..." class="span3" value="<?php echo $search_value;?>">
			<input type="submit" class="btn" value="Pesquisar">
			<input onclick="$('.filter_clear_fld').val(1);" type="submit" class="btn" value="Limpar">
		</form>
	</div>
</div>
<div class="form-actions">
	<a href="/<?php echo $controller; ?>/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> <?php echo $header; ?></a>
</div>

<?php 
if (isset($this->Paginator) ) { 
	$params = $this->Paginator->request->params;
	echo $this->Element('Tables/paginator', array('params'=>$params));
} 
?>
<?php if (count($data_index) == 0) { ?>
<div class="alert alert-warning">
	Nenhum registro no Banco de Dados!
</div>
<?php } else { ?>
<table class="table table-striped">
	<thead>
		<tr class="alert-info">
			<?php if ($this->Session->read('do_belongsTo')) { ?>
			<th class="span1">&nbsp;</th>
			<?php } ?>
			<?php foreach ($forms[$model]['fields'] as $field) { ?>
			<?php if (!isset($field['index'])) $field['index'] = true; if (!$field['index']) continue; ?>
			<th><?php echo ( isset($this->Paginator) ) ? ( $this->Paginator->sort( $field['model'].'.'.$field['field'], $field['name'] ) ) : ( $field['name'] ); ?></th>
			<?php } ?>
			<th class="span3">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php
	 foreach ($data_index as $row) { ?>
		<tr>
			<?php if ($this->Session->read('do_belongsTo')) { ?>
			<td><input class="id_belongsTo" type="radio" name="id" value="<?php echo $model.'|'.$row[$model]['id'].'|'.$row[$model][$del_info[$model]];?>"></td>
			<?php } ?>
			<?php foreach ($forms[$model]['fields'] as $field) { ?>
			<?php if (!isset($field['index'])) $field['index'] = true; if (!$field['index']) continue; ?>
			<?php if (isset($field['model'])) {
				$imodel = $field['model'];
			} else {
				$imodel = $model;
			}
			foreach($del_info as $k=>$v) {
				if ($imodel == $k and $field['field'] == $v) {
					if (isset($row[$k][0])) {
						$del_info_value = $row[$k][0][$v];
					} elseif (isset($row[$k][$v])) {
						$del_info_value = $row[$k][$v];
					} else {
						$del_info_value = 'Nenhum';
					}
				}
			}
			?>
			<td><?php
			if (isset($row[$imodel][0])) {
				$field_value = $row[$imodel][0][$field['field']];
			} else {
				$field_value = (isset($row[$imodel][$field['field']]))?($row[$imodel][$field['field']]):('Nenhum');
			}
			echo AppController::_indexFormat( $field_value, $field['type'] );?></td>
			<?php } ?>
			<td>
				<?php if (isset($ver_detalhes)) { ?>
				<a rel="tooltip" title="<?php echo $ver_detalhes; ?>" class="btn" href="/<?php echo $controller;?>/view/<?php echo $row[$model]['id'];?>"><i class="icon-tasks"></i></a>
				<?php } ?>
				<a href="/<?php echo $controller;?>/edit/<?php echo $row[$model]['id'];?>" class="btn" rel="tooltip" title="Editar"><i class="icon-pencil"></i></a>
				<?php $test = $row; unset($test[$model]); if (AppController::_checkRel($test, strtolower($model).'_id')) { ?>
				<a href="#delModal" data-del-info="<?php echo $del_info_value; ?>" data-id="<?php echo $row[$model]['id']; ?>" data-toggle="modal" class="btn delBtn" rel="tooltip" title="Excluir"><i class="icon-trash"></i></a>
				<?php } else { ?>
				<a href="#" class="btn btn-danger" rel="tooltip" title="Não é possível Excluir"><i class="icon-trash icon-white"></i></a>
				<?php } ?>
				<?php 
				$sess_models = AppController::_sess_models();
				if (isset($sess_models[$this->name]['flag'])) { ?>
				<a href="/projetos/seleciona/<?php echo $row[$model]['id']; ?>" rel="tooltip" title="Selecionar" class="btn"><i class="icon-flag"></i></a>
				<?php } ?>
				<?php if (isset($sub_record)) { ?>
				<a rel="tooltip" title="<?php echo $sub_record; ?>" class="btn" href="/<?php echo $controller;?>/add/<?php echo $row[$model]['id'];?>"><i class="icon-plus-sign"></i></a>
				<?php $sub_num = AppController::_sub_children( $sub_itens, array('id'=>$row[$model]['id'],'model'=>$model,'field'=>$sub_key) );
				if ($sub_num > 0) { ?>
				<a rel="tooltip" data-chamada-id="<?php echo $row[$model]['id'];?>" title="<?php echo $sub_num;?> <?php echo $model;?>(s) relacionada(s)" class="btn btn-info subBtn" href="#"><?php echo $sub_num; ?></a>
				<?php } } ?>
			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } ?>
<div class="form-actions">
	<a href="/<?php echo $controller; ?>/add" class="btn btn-primary"><i class="icon-plus icon-white"></i> <?php echo $header; ?></a>
	<?php if ($this->Session->read('do_belongsTo')) { ?>
	<a href="/systems/back" class="btn btn-info" id="btn-backsel"><i class="icon-arrow-left icon-white"></i> Selecionar e Voltar</a>
	<?php } ?>
</div>
<div class="modal fade hide" id="delModal">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Confirmação</h3>
	</div>
	<div class="modal-body">
		Excluindo registro de <?php echo $header;?><br><br>
		<span id="modal-del-info" class="label label-important"></span><br>
		<br>
		Tem certeza ?
	</div>
	<div class="modal-footer">
		<form method="post" action="/<?php echo $controller.'/del/';?>">
		<input id="modal-id" type="hidden" name="data[<?php echo $model;?>][id]" value="0">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<input type="submit" class="btn btn-danger" value="Apagar">
		</form>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.delBtn').click(function(){
		$('#modal-id').val($(this).data('id'));
		$('#modal-del-info').html($(this).data('del-info'));
	});
	$('.id_belongsTo').click(function(){
		$('#btn-backsel').attr('href','/systems/back/'+$(this).val());
	});
});
</script>
