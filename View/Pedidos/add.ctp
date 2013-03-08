<div class="page-header">
	<h3>Novo Pedido</h3>
</div>
<ul class="nav nav-tabs" id="PedidosTab">
	<li class="active"><a href="#tabPedidos">Pedidos</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tabPedidos">
		<?php echo $this->Element('Pedidos/tabPedido'); ?>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#fld_instituicao_id_estado').change(function(){
			$.ajax({
				url: '/systems/cidade/'+$(this).val(),
				success: function(data){
					$('#fld_instituicao_id_cidade').html('<option value="0">Selecione a Cidade</option>'+data);
				}
			});
		});
		$('#fld_instituicao_id_cidade').change(function(){
			$.ajax({
				url: '/systems/instituicao/'+$(this).val(),
				success: function(data){
					$('#fld_instituicao_id').html('<option value="0">Selecione a Instituição</option>'+data);
				}
			});
		});
		$('#fld_instituicao_id').change(function(){
			$.ajax({
				url: '/systems/convenio/'+$(this).val(),
				success: function(data){
					$('#fld_convenio_id').html('<option value="0">Selecione o Convênio</option>'+data);
				}
			});
		});
		$('.bt-model').click(function(){
			$('form').attr('action', '/systems/belongsTo/'+$(this).data('controller'));
			$('form').submit();
		});
	});
</script>
