<div class="accordion" id="accordion-contatos">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-contatos" href="#collapseOne">
				<h4>Contatos</h4>
			</a>
		</div>
		<div class="accordion-body collapse" id="collapseOne">
			<div class="accordion-inner" id="contatos-table">
				<?php
				if (isset($contatos)) { 
				foreach ($contatos as $contato) { ?>
				<table class="table table-bordered">
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
				    		<a href="/contatos/addContatosEmail/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id'];?>" class="btn">Adicionar Email</a>
				    		<a href="contatos/addContatosFone/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id'];?>" class="btn">Adicionar Telefone</a>
				    		<a href="/contatos/edit/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/'.$this->data['Chamada']['id']; ?>" class="btn">Editar Contato</a>
				    	</td>
				    </tr>
				</table>
				<?php } } ?>
			</div>
		</div>
	</div>
</div>

