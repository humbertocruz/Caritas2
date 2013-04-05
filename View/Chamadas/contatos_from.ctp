<select name="data[Chamada][contato_id]" class="span6" id="contato-select">
<?php foreach ($contatos as $contato) { ?>
	<option value="<?php echo $contato['Contato']['id'];?>"><?php echo $contato['Contato']['nome'].' - '.$contato['Cargo']['nome'];?></option>
<?php } ?>
</select>

<?php
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
					    		<li><a href="/contatos/editContatosEmail/<?php echo $emails['id'].'/'.$this->name.'/'.$this->action.'/'.$chamada_id;?>">Editar</a></li>
				    			<li><a href="/contatos/delContatosEmail/<?php echo $fones['id'].'/'.$this->name.'/'.$this->action.'/'.$chamada_id;?>">Excluir</a></li>
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
				    				<li><a href="/contatos/editContatosFone/<?php echo $fones['id'].'/'.$this->name.'/'.$this->action.'/'.$chamada_id;?>">Editar</a></li>
				    				<li><a href="/contatos/delContatosFone/<?php echo $fones['id'].'/'.$this->name.'/'.$this->action.'/'.$chamada_id;?>">Excluir</a></li>
				    			</ul>
				    		</div>
				    	</td>
				    	<td><?php echo $fones['fone']; ?></td>
				    </tr>
				    <?php } ?>
				    <tr>
				    	<td colspan="2">
				    		<a href="/contatos/addContatosEmail/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/0';?>" class="btn">Adicionar Email</a>
				    		<a href="contatos/addContatosFone/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/0';?>" class="btn">Adicionar Telefone</a>
				    		<a href="/contatos/edit/<?php echo $contato['Contato']['id'].'/'.$this->name.'/'.$this->action.'/0'; ?>" class="btn">Editar Contato</a>
				    	</td>
				    </tr>
				</table>
<?php } ?>
