<?php echo $this->TB->page_header($page_header_title); ?>

<ul class="nav nav-tabs" id="ChamadasTab">
	<li class="active"><a href="#tabChamado">Chamado</a></li>
	<li><a href="#tabProcedimentos">Procedimentos</a></li>
	<?php if (!empty($this->data)) { ?>
	<li><a href="#tabFilhaos">Chamados Filhos</a></li>
	<?php } ?>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="tabChamado">
		<?php echo $this->Element('Chamados/tabChamado'); ?>
	</div>
	<div class="tab-pane" id="tabProcedimentos">
		<?php //echo $this->Element('Chamados/tabProcedimentos'); ?>
	</div>
	<?php if (!empty($this->data)) { ?>
	<div class="tab-pane" id="tabFilhos">
		<?php //echo $this->Element('Chamados/tabFilhos'); ?>
	</div>
	<?php } ?>
</div>
