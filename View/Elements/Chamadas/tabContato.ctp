<div id="list-contatos">

<select name="data[Chamada][contato_id]" id="contato-select" class="span6">
<?php foreach ($contatos as $contato) { ?>
	<option value="<?php echo $contato['Contato']['id'];?>"><?php echo $contato['Contato']['nome'].' - '.$contato['Cargo']['nome'];?></option>
<?php } ?>
</select>
				<?php
				if (isset($contatos)) { 
				foreach ($contatos as $contato) { ?>
				<table class="table table-bordered hide contato-table" id="contato-table-<?php echo $contato['Contato']['id'];?>">
				<tr>
					<th class="span1 alert-info">Nome</th>
				    <td class="alert-info"><?php echo $contato['Contato']['nome']; ?></td>
				</tr>
				<tr>
					<th>Cargo</th>
				    <td><?php echo $contato['Cargo']['nome'];?></td>
				</tr>
				<?php foreach ($contato['Contato']['ContatosEmail'] as $emails) { ?>
				<tr>
					<td>
				    	<div class="btn-group">
				    		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    			<i class="icon-wrench"></i>
				    			<span class="caret"></span>
				    		</a>
				    		<ul class="dropdown-menu">
					    		<li><a href="/contatos/editContatosEmail/<?php echo $emails['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id'];?>">Editar</a></li>
				    			<li><a href="/contatos/delContatosEmail/<?php echo $emails['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id'];?>">Excluir</a></li>
				    		</ul>
				    	</div>
				    </td>
				    <td><?php echo $emails['email']; ?></td>
				    </tr>
				    <?php } ?>
				    <?php foreach ($contato['Contato']['ContatosFone'] as $fones) { ?>
				    <tr>
				    	<td>
				    		<div class="btn-group">
				    			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    				<i class="icon-wrench"></i>
				    				<span class="caret"></span>
				    			</a>
				    			<ul class="dropdown-menu">
				    				<li><a href="/contatos/editContatosFone/<?php echo $fones['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id'];?>">Editar</a></li>
				    				<li><a href="/contatos/delContatosFone/<?php echo $fones['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id'];?>">Excluir</a></li>
				    			</ul>
				    		</div>
				    	</td>
				    	<td><?php echo $fones['fone']; ?></td>
				    </tr>
				    <?php } ?>
				    <tr>
				    	<td colspan="2">
				    		<a href="#" class="btn" id="btn-add-email">Adicionar Email</a>
				    		<a href="contatos/addContatosFone/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id'];?>" class="btn">Adicionar Telefone</a>
				    		<a href="/contatos/edit/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id']; ?>" class="btn">Editar Contato</a>
				    	</td>
				    </tr>
				</table>
				<?php } } ?>
</div>

<div class="modal hide fade" id="modal-add-email">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Modal header</h3>
  </div>
  <div class="modal-body">
    <p>One fine body…</p>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Save changes</a>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('#btn-add-email').live(
			'click',
			function(){
				$('#modal-add-email').modal('show');
			}
		);
	});
</script>

