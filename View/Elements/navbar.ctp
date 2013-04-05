<?php
//pr(AppController::_sess_models());
$sess_models = AppController::_sess_models();

?>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
	<div class="container">
		<a href="/" class="brand">Cáritas - SAC</a>
		<ul class="nav">
			<li <?php if ($name == 'Pages') echo 'class="active"';?>><?php echo $this->Html->link('Home', '/');?></li>
			<?php foreach($menu_control as $category){ ?>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo $category['name'];?><b class="caret"></b></a>
				<ul class="dropdown-menu">
					<?php foreach($category['data'] as $key=>$value){ ?>
					<?php if ($key == 'divider') { ?>
					<li class="divider"></li>
					<li class="nav-header"><?php echo $value;?></li>
					<?php continue; } ?>
					<?php if (!AppController::_hasPermission($key)) continue; ?>
					
					<li <?php if ($name == $key) echo 'class="active"';?>><?php echo $this->Html->link($value[0],$value[1]);?></li>
					<?php } ?>
				</ul>
			</li>
			<?php } ?>
			<?php if (AppController::_isAdmin()) { ?>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Segurança<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><?php echo $this->Html->link('Backup Banco de Dados','/backups');?></li>
					<li><?php echo $this->Html->link('Log de Acesso','/logs');?></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Controle de Acesso<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><?php echo $this->Html->link('Atendentes','/atendentes');?></li>
					<li><?php echo $this->Html->link('Níveis de Acesso','/niveis_acesso');?></li>
					<li><?php echo $this->Html->link('Permissoes','/permissoes');?></li>
					<li><?php echo $this->Html->link('Modo Debug','/systems/debugMode');?></li>
				</ul>
			</li>
			<?php } ?>
		</ul>
		<?php if(!$this->Session->check('Auth.User')) { ?>
		<form action="/atendentes/login" method="post" class="navbar-form pull-right">
			<input type="text" class="span2" name="data[Atendente][email]" placeholder="Email">
			<input type="password" class="span2" name="data[Atendente][senha]" placeholder="Senha">
			<input type="submit" value="Login" class="btn btn-primary">
		</form>
		<?php } else { ?>
		<ul class="nav pull-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo( $this->Session->read('Auth.User.Atendente.nome'));?> [ <span id="user_timeout">20:00</span> ]<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#" data-toggle="modal" data-target="#changePass">Alterar Senha</a></li>
					<li><a href="/atendentes/edit/<?php echo $this->Session->read('Auth.User.Atendente.id');?>">Seu Cadastro</a></li>
					<li><a href="/atendentes/logout">Sair</a></li>
					<li class="divider"></li>
					<li><a href="#" id="listChamadaAbertasUser">Chamadas em Aberto: <span class="label label-important"><?php echo $chamadas_aberto;?></span></a></li>
					<li><a href="#">Nível: <?php echo( $this->Session->read('Auth.User.NiveisAcesso.nome'));?></a></li>
				</ul>
			</li>
		</ul>
		<form id="projeto_id_form" action="/systems/changeProjeto" method="post" class="navbar-form pull-right">
			<input type="hidden" id="action_hidden" name="data[here]" value="<?php echo $this->here; ?>">
			<input type="hidden" id="action_hidden" name="data[name]" value="<?php echo $this->name; ?>">
			<input type="hidden" id="action_hidden" name="data[action]" value="<?php echo $this->action; ?>">
			<select id="projeto_id_select" name="data[projeto_id]">
				<option <?php echo ($sess_models['Projetos']['id']==0)?('selected="selected"'):('');?> value="0">Todos os Projetos</option>
				<?php foreach($app_projetos as $projeto) { ?>
				<option <?php echo ($sess_models['Projetos']['id']==$projeto['Projeto']['id'])?('selected="selected"'):('');?> value="<?php echo $projeto['Projeto']['id'];?>"><?php echo $projeto['Projeto']['nome'];?></option>
				<?php } ?>
			</select>
		</form>
		<form id="frmChamadaAbertasUsuario" action="/chamadas" method="post">
			<input type="hidden" value="1" name="data[filter][status_id]">
			<input type="hidden" value="<?php echo $this->Session->read('Auth.User.Atendente.id');?>" name="data[filter][atendente_id]">
		</form>
		
		<script>
			$(document).ready(function(){
				$('#projeto_id_select').change(function(){
					$('#projeto_id_form').submit();
				});
				$('#listChamadaAbertasUser').click(function(){
					$('#frmChamadaAbertasUsuario').submit();
				});
			});
		</script>
		<?php } ?>
	</div>
    </div>
</div>
<?php
if ($this->Session->read('do_belongsTo') == true) { 
	$belongs = $this->Session->read('sess_belongsTo');
	if (empty( $belongs[count( $belongs ) - 1])) array_pop( $belongs );
?>
<div class="container">
	<a href="/" class="brand">Controle de Relacionamentos</a>
	<ul class="breadcrumb">
		<?php foreach ($belongs as $back) { ?>
		<li><a href="/systems/back"><?php echo $back['System']['controller']; ?></a> <span class="divider">/</span></li>
		<?php } ?>
	</ul>
</div>
<?php } ?>
