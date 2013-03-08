<div class="tab-pane hide" id="<?php echo $ctrl_field['field'];?>">
	<table class="table table-striped">
		<thead>
			<tr class="alert-info">
				<?php foreach($forms[$ctrl_field['model']]['fields'] as $column) { 
						if (isset($column['model']))
							if ($model == $column['model']) continue; 
				if ($column['index'] == false) continue; 
				if ($model == $ctrl_field['model']) continue;
				?>
				<th><?php echo $column['name']; ?></th>
				<?php } ?>
				<th class="span2">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($this->data[$ctrl_field['model']] as $row) { 
			?>
			<tr>
				<?php
					$campo_val_del_info = '';
					foreach($forms[$ctrl_field['model']]['fields'] as $column) { 
						if (isset($column['model']))
							if ($model == $column['model']) continue; 
						if (!isset($ctrl_field['del_info'])) $ctrl_field['del_info'] = false;
						if ($column['index'] == false) continue; 
						//pr($row);
						$manyModel_id = (isset($ctrl_field['manyModel']))?($row[$ctrl_field['manyModel']]['id']):(0);
				?>
				<td>
					<?php
					if (isset($column['model'])) $campo_val = $row[$column['model']][$column['field']];
					else $campo_val = $row[$column['field']];
					if ($column['type'] == 'date' and $campo_val != null) $campo_val = date('d/m/Y', strtotime($campo_val));
					if ($column['type'] == 'email') { ?>
						<a href="mailto:<?php echo $row[$column['field']];?>">
						<?php echo $campo_val; ?>
						</a>
					<?php } else { 
						echo $campo_val; 
					} 
					if ($ctrl_field['del_info'] == $column['field']) $campo_val_del_info = $campo_val;
					?>
				</td>
				<?php } ?>
				<td>
					<a href="/<?php echo $controller;?>/edit<?php echo $ctrl_field['model'];?>/<?php echo $row['id'];?>" class="btn"><i class="icon icon-pencil"></i></a>
					<a data-toggle="modal" data-del-info="<?php echo $campo_val_del_info;?>" data-source-id="<?php echo $this->data[$model]['id'];?>" data-id="<?php echo $row['id'];?>" href="#delModal_<?php echo $ctrl_field['model']; ?>" class="btn delBtn"><i class="icon icon-trash"></i></a>
					<?php if ( isset( $ctrl_field['manyModel'] ) ) { ?>
						<a href="/<?php echo $ctrl_field['manyController']; ?>/edit/<?php echo $manyModel_id; ?>" class="btn" rel="tooltip" title="Editar <?php echo $ctrl_field['manyModel']; ?>"><i class="icon-info-sign"></i></a>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<div class="form-actions">
	<a class="btn btn-primary" href="/<?php echo $controller;?>/add<?php echo $ctrl_field['model'];?>/<?php echo $this->data[$model]['id'];?>"><b class="icon-plus icon-white"></b> <?php echo Inflector::humanize( Inflector::underscore( $ctrl_field['model']));?></a>
	<a href="/<?php echo $controller; ?>/index" class="btn">Cancelar</a>
	</div>
</div>
<div class="modal fade hide" id="delModal_<?php echo $ctrl_field['model']; ?>">
	<div class="modal-header">
		<a href="#" class="close" data-dismiss="modal">x</a>
		<h3>Confirmação</h3>
	</div>
	<div class="modal-body">
		Excluindo registro de <?php echo $ctrl_field['model'];?><br><br>
		<span id="modal-del-info" class="label label-important"></span><br>
		<br>
		Tem certeza ?
	</div>
	<div class="modal-footer">
		<form method="post" action="/<?php echo $controller.'/del'.$ctrl_field['model'].'/';?>">
		<input id="modal-source" type="hidden" name="data[<?php echo $model;?>][id]" value="0">
		<input id="modal-id" type="hidden" name="data[<?php echo $ctrl_field['model'];?>][id]" value="0">
		<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
		<input type="submit" class="btn btn-danger" value="Apagar">
		</form>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.delBtn').click(function(){
		$('#delModal_<?php echo $ctrl_field['model']; ?> #modal-source').val($(this).data('source-id'));
		$('#delModal_<?php echo $ctrl_field['model']; ?> #modal-id').val($(this).data('id'));
		$('#delModal_<?php echo $ctrl_field['model']; ?> #modal-del-info').html($(this).data('del-info'));
	});
});
</script>