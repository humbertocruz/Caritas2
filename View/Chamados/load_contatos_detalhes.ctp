<?php
if ( isset( $contatos ) ) { 
	foreach ($contatos as $contato) { ?>
		<table class="table table-bordered hide contato-table" id="contato-table-<?php echo $contato['Contato']['id'];?>">
			<tr>
				<th class="span1 alert-info">Nome</th>
				<td class="alert-info">
					<?php echo $contato['Contato']['nome']; ?>
					<a class="btn pull-right sr-form-bt" href="#" data-url="/contatos/edit/<?php echo $contato['Contato']['id'];?>"><span class="icon icon-edit"></span></a>
				</td>
			</tr>
			<tr>
				<th>Cargo</th>
				<td><?php echo $contato['Cargo']['nome'];?></td>
			</tr>
			<?php foreach ($contato['Contato']['ContatosEmail'] as $emails) { ?>
			<tr>
				<td colspan="2"><a href="#" data-url="/contatos/editContatosEmail/<?php echo $emails['id'];?>" class="btn sr-form-bt"><span class="icon icon-edit"></span></a>&nbsp;<?php echo $emails['email']; ?></td>
			</tr>
			<?php } ?>
			<?php foreach ($contato['Contato']['ContatosFone'] as $fones) { ?>
			<tr>
				<td colspan="2"><a href="#" class="btn sr-form-bt" rel="tooltip" title="Editar Fone" href="#" data-url="/contatos/editContatosFone/<?php echo $fones['id'];?>"><span class="icon icon-edit"></span></a>&nbsp;<?php echo $fones['fone']; ?></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="2">
					<a class="btn sr-form-bt" href="#" data-url="/contatos/add/"><span class="icon icon-plus-sign"></span>&nbsp;Contato</a>
					<a class="btn sr-form-bt" href="#" data-url="/contatos/addContatosFone/<?php echo $contato['Contato']['id'];?>"><span class="icon icon-plus-sign"></span>&nbsp;Fone</a>
					<a class="btn sr-form-bt" href="#" data-url="/contatos/addContatosEmail/<?php echo $contato['Contato']['id'];?>"><span class="icon icon-plus-sign"></span>&nbsp;Email</a>
				</td>
			</tr>
		</table>
	<?php }
} ?>
