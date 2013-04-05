<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Cáritas - Sistema de Atendimento ao Cliente</title>
		<?php echo $this->Html->meta('icon');?>
		<!-- CSS Links -->
		<?php echo $this->Html->css('../bootstrap/css/bootstrap'); ?>
		<?php echo $this->Html->css('../bootstrap/css/bootstrap-responsive'); ?>
		<?php echo $this->Html->css('../datepicker/css/datepicker'); ?>
		
		<?php echo $this->Html->css('caritas'); ?>
		<style >
			body {
				margin-top: 50px;
				margin-bottom: 50px;
				/*background: transparent url('/img/background.jpeg') no-repeat fixed;*/
			}
		</style>
		<!-- JS Links -->
		<?php echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js'); ?>
		<?php echo $this->Html->script('../bootstrap/js/bootstrap'); ?>
		<?php echo $this->Html->script('../datepicker/js/bootstrap-datepicker'); ?>
		<?php echo $this->Html->script('caritas'); ?>
		<script >
			$(document).ready(function(){
				$('[rel=tooltip]').tooltip();
				$('[rel=popover]').popover();
				$('#changePassBtn').click(function(){
					$.ajax({
						type: 'POST',
						url: '/atendentes/change_pass',
						data: $('#changePassForm').serialize(),
						success: function(data) {
							if (data == 'Senha alterada com sucesso!') {
								$('#changePassError').html('<div class="alert alert-error">'+data+'</div>');
								window.setTimeout(function() { $('#changePass').modal('hide'); }, 3000);
							} else {
								$('#changePassError').html('<div class="alert alert-error">'+data+'</div>');
							}
						}
					});
				});
			});
		</script>
		<?php echo $scripts_for_layout; ?>
	</head>
	<body>
		<script >
		if (top != self) hide = 'hide'; else hide = '';
		window.document.write('<header class="'+hide+'">'); 
		</script>
		<header>
			<?php echo $this->Element('navbar', array('action'=>$this->action, 'name'=>$this->name));?>
		</header>
		<section>
			<div class="container">
				<?php
				$debugMode = $this->Session->read('sess_debugMode');
				if ($debugMode) { ?>
				<div class="alert">
					<h3>Modo Debug</h3>
					<p>
					Modelo: <?php echo $this->name; ?><br/>
					Action: <?php echo $this->action; ?><br/>
					Permissão: <?php echo $this->name.'Controller::'.$this->action; ?>
					</p>
				</div>
				<?php } ?>
				<?php echo $this->Session->flash(); ?>
				<?php echo $this->Session->flash('email'); ?>
				<?php echo $this->Session->flash('auth'); ?>
				<?php echo $content_for_layout; ?>
			</div>
		</section>
		<div class="modal hide fade" id="changePass">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Alterar Senha</h3>
			</div>
			<div class="modal-body">
				<form class="form-vertical" id="changePassForm">
					<span id="changePassError"></span>
					<div class="control-group">
						<label>Senha atual</label>
						<div class="controls">
							<input type="password" name="data[Atendente][password]">
						</div>
					</div>
					<div class="control-group">
						<label>Nova senha</label>
						<div class="controls">
							<input type="password" name="data[Atendente][new-password]">
							<input type="password" name="data[Atendente][conf-password]">
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="#" data-dismiss="modal" class="btn">Cancelar</a>
				<a href="#" id="changePassBtn" class="btn btn-danger">Alterar</a>
			</div>
		</div>
		<footer>
			<div class="navbar navbar-fixed-bottom">
				<div class="navbar-inner">
					<div class="container">
						<a href="#" class="brand">Rodapé</a>
					</div>
				</div>
			</div>
		</footer>
		<?php echo $this->element('sql_dump'); ?>
	</body>
</html>