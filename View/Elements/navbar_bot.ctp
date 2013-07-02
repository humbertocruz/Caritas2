<div class="navbar navbar-fixed-bottom">
	<div class="navbar-inner">
		<div class="container">
			<a href="#" class="brand">Cáritas</a>
			<div class="btn-group dropup pull-right btn-sr-form">
				<a href="#" class="btn dropdown-toggle" data-toggle="dropdown">
					Formulários
					<span class="caret"></span>
				</a>
				<?php echo $this->html->url( null, true ); ?>
				<ul class="dropdown-menu sr-form-list">
					<?php foreach($sr_forms as $form) { ?>
					<?php if ( $form['url'] != $this->html->url( null, true ) ) { ?>
						<li><a href="<?php echo $form['url'];?>"><?php echo $form['key'];?></a></li>
					<?php } ?>
					<?php } ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="modal hide fade" data-backdrop="static" id="modal-loading-form">
  <div class="modal-header">
    <h3>Aguarde...</h3>
  </div>
  <div class="modal-body">
    <h4>Carregando dados do formulário!</h4>
  </div>
</div>
<div class="modal hide fade" data-backdrop="static" id="modal-saving-form">
  <div class="modal-header">
    <h3>Aguarde...</h3>
  </div>
  <div class="modal-body">
    <h4>Guardando dados do formulário!</h4>
  </div>
</div>

<script>
$(document).ready(function(){
	<?php if ( !empty( $sr_forms ) ) { ?>
		$('.btn-sr-form').removeClass('hide');
	<?php } ?>
	sr_forms_ready = new Array();
	<?php 
	if (!isset($sr_forms_ready)) $sr_forms_ready = array();
	foreach ($sr_forms_ready as $key=>$value) { ?>
	sr_forms_ready.push('<?php echo $key;?>');
	<?php } ?>

	if ($('form.sr-form').length > 0) {
		$('.btn-sr-form').removeClass('hide');
	
		$('form.sr-form').each(function(){
			savebt= '<button data-form-id="'+$(this).attr('id')+'" title="Guarda Informações" el="tooltip" class="btn btn-small sr-form-save"><span class="icon icon-upload"></span></button>';

			if (sr_forms_ready.indexOf('form_'+$(this).attr('id')) != -1) {
				delbt = '<button data-form-id="'+$(this).attr('id')+'" title="Exclui Informações" el="tooltip" class="btn btn-small btn-danger sr-form-del"><span class="icon icon-white icon-trash"></span></button>';
				loadbt = '<button data-form-id="'+$(this).attr('id')+'" title="Restaura Informações" rel="tooltip" class="btn btn-small sr-form-restore"><span class="icon icon-download-alt"></span></button>';
			} else {
				delbt = '';
				loadbt = '';
			}
			
			$('.sr-form-list').append('<li><a class="sr-form-item" id="sr-form-item-'+$(this).attr('id')+'" href="#">'+$(this).attr('id')+'&nbsp;'+savebt+'&nbsp;'+loadbt+'&nbsp;'+delbt+'</a></li>');
		});
		$('.sr-form-item').hover(
			function(){
				item = $(this).data('form-id');
				$('form#'+item).addClass('alert-info');
			},
			function() {
				item = $(this).data('form-id');
				$('form#'+item).removeClass('alert-info');	
			}
		);
		$('.sr-form-del').click(function(){
			form_del($(this).data('form-id'));
		});
		$('.sr-form-save').click(function(){
			$('#modal-saving-form').modal('show');
			form_save($(this).data('form-id'));
		});
		$('.sr-form-restore').click(function(){
			$('#modal-loading-form').modal('show');
			form_restore($(this).data('form-id'));
		});
	}
});
</script>