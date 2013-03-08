<div class="page-header">
	<h3>Edita Pedido</h3>
	<h4><?php echo $this->data['Instituicao']['nome_fantasia'];?></h4>
	<h5></h5>
</div>
<ul class="nav nav-tabs" id="PedidosTab">
	<li class="active"><a href="#tabPedidos">Pedidos</a></li>
	<li><a href="#tabItems">Items</a></li>
	<li><a href="#tabChamada">Chamadas</a></li>
	<li><a href="#tabDocumento">Documentos</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tabPedidos">
		<?php echo $this->Element('Pedidos/tabPedido'); ?>
	</div>
	<div class="tab-pane" id="tabItems">
		<?php echo $this->Element('Pedidos/tabItems'); ?>
	</div>
	<div class="tab-pane" id="tabChamada">
		<?php echo $this->Element('Pedidos/tabChamada'); ?>
	</div>
	<div class="tab-pane" id="tabDocumento">
		<?php echo $this->Element('Pedidos/tabDocumento'); ?>
	</div>
</div>

<script>
	$(document).ready(function(){
		
		$('#PedidosTab a').click(function (e) {
			e.preventDefault();
			$(this).tab('show');
		});
		
		//tabUrl = window.location.pathname.split('#');
		//console.log(window.location.pathname);
		//if (tabUrl.length == 2) {
			//$('a#'+tabUrl[1]).tab('show');
		//}
		
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
		var hash = window.location.hash;
		$('ul.nav a[href="'+hash+'"]').tab('show');
		
	});
</script>
