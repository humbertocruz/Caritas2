<div class="page-header">
	<h3>Edita Item do Pedido</h3>
</div>
<ul class="nav nav-tabs" id="PedidoItensTab">
	<li class="active"><a href="#tabPedidoItem">Item do Pedidos</a></li>
	<li><a href="#tabPedidoAtividade">Atividade</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tabPedidoItem">
		<?php echo $this->Element('Pedidos/tabPedidoItem'); ?>
	</div>
	<div class="tab-pane" id="tabPedidoAtividade">
		<?php echo $this->Element('Pedidos/tabPedidoAtividade'); ?>
	</div>
</div>
<script>
    $(document).ready( function() {
	$('#PedidoItensTab a').click(function (e) {
	    e.preventDefault();
	    $(this).tab('show');
	});
        $('ul.nav a[href="'+hash+'"]').tab('show');
    });
</script>
